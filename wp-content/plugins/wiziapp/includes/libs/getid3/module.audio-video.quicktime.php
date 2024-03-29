<?php	 	 
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio-video.quicktime.php                            //
// module for analyzing Quicktime and MP3-in-MP4 files         //
// dependencies: module.audio.mp3.php                          //
//                                                            ///
/////////////////////////////////////////////////////////////////

getid3_lib::IncludeDependency(GETID3_INCLUDEPATH.'module.audio.mp3.php', __FILE__, true);

class getid3_quicktime
{

	function getid3_quicktime(&$fd, &$ThisFileInfo, $ReturnAtomData=true, $ParseAllPossibleAtoms=false) {

		$ThisFileInfo['fileformat'] = 'quicktime';
		$ThisFileInfo['quicktime']['hinting']    = false;
		$ThisFileInfo['quicktime']['controller'] = 'standard'; // may be overridden if 'ctyp' atom is present

		fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

		$offset      = 0;
		$atomcounter = 0;

		while ($offset < $ThisFileInfo['avdataend']) {
			if (!getid3_lib::intValueSupported($offset)) {
				$ThisFileInfo['error'][] = 'Unable to parse atom at offset '.$offset.' because beyond '.round(PHP_INT_MAX / 1073741824).'GB limit of PHP filesystem functions';
				break;
			}
			fseek($fd, $offset, SEEK_SET);
			$AtomHeader = fread($fd, 8);

			$atomsize = getid3_lib::BigEndian2Int(substr($AtomHeader, 0, 4));
			$atomname = substr($AtomHeader, 4, 4);

			// 64-bit MOV patch by jlegate�ktnc*com
			if ($atomsize == 1) {
				$atomsize = getid3_lib::BigEndian2Int(fread($fd, 8));
			}

			$ThisFileInfo['quicktime'][$atomname]['name']   = $atomname;
			$ThisFileInfo['quicktime'][$atomname]['size']   = $atomsize;
			$ThisFileInfo['quicktime'][$atomname]['offset'] = $offset;

			if (($offset + $atomsize) > $ThisFileInfo['avdataend']) {
				$ThisFileInfo['error'][] = 'Atom at offset '.$offset.' claims to go beyond end-of-file (length: '.$atomsize.' bytes)';
				return false;
			}

			if ($atomsize == 0) {
				// Furthermore, for historical reasons the list of atoms is optionally
				// terminated by a 32-bit integer set to 0. If you are writing a program
				// to read user data atoms, you should allow for the terminating 0.
				break;
			}
			switch ($atomname) {
				case 'mdat': // Media DATa atom
					// 'mdat' contains the actual data for the audio/video
					if (($atomsize > 8) && (!isset($ThisFileInfo['avdataend_tmp']) || ($ThisFileInfo['quicktime'][$atomname]['size'] > ($ThisFileInfo['avdataend_tmp'] - $ThisFileInfo['avdataoffset'])))) {

						$ThisFileInfo['avdataoffset'] = $ThisFileInfo['quicktime'][$atomname]['offset'] + 8;
						$OldAVDataEnd                 = $ThisFileInfo['avdataend'];
						$ThisFileInfo['avdataend']    = $ThisFileInfo['quicktime'][$atomname]['offset'] + $ThisFileInfo['quicktime'][$atomname]['size'];

						if (getid3_mp3::MPEGaudioHeaderValid(getid3_mp3::MPEGaudioHeaderDecode(fread($fd, 4)))) {
							getid3_mp3::getOnlyMPEGaudioInfo($fd, $ThisFileInfo, $ThisFileInfo['avdataoffset'], false);
							if (isset($ThisFileInfo['mpeg']['audio'])) {
								$ThisFileInfo['audio']['dataformat']   = 'mp3';
								$ThisFileInfo['audio']['codec']        = (!empty($ThisFileInfo['mpeg']['audio']['encoder']) ? $ThisFileInfo['mpeg']['audio']['encoder'] : (!empty($ThisFileInfo['mpeg']['audio']['codec']) ? $ThisFileInfo['mpeg']['audio']['codec'] : (!empty($ThisFileInfo['mpeg']['audio']['LAME']) ? 'LAME' :'mp3')));
								$ThisFileInfo['audio']['sample_rate']  = $ThisFileInfo['mpeg']['audio']['sample_rate'];
								$ThisFileInfo['audio']['channels']     = $ThisFileInfo['mpeg']['audio']['channels'];
								$ThisFileInfo['audio']['bitrate']      = $ThisFileInfo['mpeg']['audio']['bitrate'];
								$ThisFileInfo['audio']['bitrate_mode'] = strtolower($ThisFileInfo['mpeg']['audio']['bitrate_mode']);
								$ThisFileInfo['bitrate']               = $ThisFileInfo['audio']['bitrate'];
							}
						}
						$ThisFileInfo['avdataend'] = $OldAVDataEnd;
						unset($OldAVDataEnd);

					}
					break;

				case 'free': // FREE space atom
				case 'skip': // SKIP atom
				case 'wide': // 64-bit expansion placeholder atom
					// 'free', 'skip' and 'wide' are just padding, contains no useful data at all
					break;

				default:
					$atomHierarchy = array();
					$ThisFileInfo['quicktime'][$atomname] = $this->QuicktimeParseAtom($atomname, $atomsize, fread($fd, $atomsize), $ThisFileInfo, $offset, $atomHierarchy, $ParseAllPossibleAtoms);
					break;
			}

			$offset += $atomsize;
			$atomcounter++;
		}

		if (!empty($ThisFileInfo['avdataend_tmp'])) {
			// this value is assigned to a temp value and then erased because
			// otherwise any atoms beyond the 'mdat' atom would not get parsed
			$ThisFileInfo['avdataend'] = $ThisFileInfo['avdataend_tmp'];
			unset($ThisFileInfo['avdataend_tmp']);
		}

		if (!isset($ThisFileInfo['bitrate']) && isset($ThisFileInfo['playtime_seconds'])) {
			$ThisFileInfo['bitrate'] = (($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset']) * 8) / $ThisFileInfo['playtime_seconds'];
		}
		if (isset($ThisFileInfo['bitrate']) && !isset($ThisFileInfo['audio']['bitrate']) && !isset($ThisFileInfo['quicktime']['video'])) {
			$ThisFileInfo['audio']['bitrate'] = $ThisFileInfo['bitrate'];
		}
		if (!empty($ThisFileInfo['playtime_seconds']) && !isset($ThisFileInfo['video']['frame_rate']) && !empty($ThisFileInfo['quicktime']['stts_framecount'])) {
			foreach ($ThisFileInfo['quicktime']['stts_framecount'] as $key => $samples_count) {
				$samples_per_second = $samples_count / $ThisFileInfo['playtime_seconds'];
				if ($samples_per_second > 240) {
					// has to be audio samples
				} else {
					$ThisFileInfo['video']['frame_rate'] = $samples_per_second;
					break;
				}
			}
		}
		if (($ThisFileInfo['audio']['dataformat'] == 'mp4') && empty($ThisFileInfo['video']['resolution_x'])) {
			$ThisFileInfo['fileformat'] = 'mp4';
			$ThisFileInfo['mime_type']  = 'audio/mp4';
			unset($ThisFileInfo['video']['dataformat']);
		}

		if (!$ReturnAtomData) {
			unset($ThisFileInfo['quicktime']['moov']);
		}

		if (empty($ThisFileInfo['audio']['dataformat']) && !empty($ThisFileInfo['quicktime']['audio'])) {
			$ThisFileInfo['audio']['dataformat'] = 'quicktime';
		}
		if (empty($ThisFileInfo['video']['dataformat']) && !empty($ThisFileInfo['quicktime']['video'])) {
			$ThisFileInfo['video']['dataformat'] = 'quicktime';
		}

		return true;
	}

	function QuicktimeParseAtom($atomname, $atomsize, $atom_data, &$ThisFileInfo, $baseoffset, &$atomHierarchy, $ParseAllPossibleAtoms) {
		// http://developer.apple.com/techpubs/quicktime/qtdevdocs/APIREF/INDEX/atomalphaindex.htm

		$atomparent = array_pop($atomHierarchy);
		array_push($atomHierarchy, $atomname);
		$atom_structure['hierarchy'] = implode(' ', $atomHierarchy);
		$atom_structure['name']      = $atomname;
		$atom_structure['size']      = $atomsize;
		$atom_structure['offset']    = $baseoffset;
		switch ($atomname) {
			case 'moov': // MOVie container atom
			case 'trak': // TRAcK container atom
			case 'clip': // CLIPping container atom
			case 'matt': // track MATTe container atom
			case 'edts': // EDiTS container atom
			case 'tref': // Track REFerence container atom
			case 'mdia': // MeDIA container atom
			case 'minf': // Media INFormation container atom
			case 'dinf': // Data INFormation container atom
			case 'udta': // User DaTA container atom
			case 'cmov': // Compressed MOVie container atom
			case 'rmra': // Reference Movie Record Atom
			case 'rmda': // Reference Movie Descriptor Atom
			case 'gmhd': // Generic Media info HeaDer atom (seen on QTVR)
			case 'ilst': // Item LiST container atom
				$atom_structure['subatoms'] = $this->QuicktimeParseContainerAtom($atom_data, $ThisFileInfo, $baseoffset + 8, $atomHierarchy, $ParseAllPossibleAtoms);
				break;

			case 'stbl': // Sample TaBLe container atom
				$atom_structure['subatoms'] = $this->QuicktimeParseContainerAtom($atom_data, $ThisFileInfo, $baseoffset + 8, $atomHierarchy, $ParseAllPossibleAtoms);
				$isVideo = false;
				$framerate  = 0;
				$framecount = 0;
				foreach ($atom_structure['subatoms'] as $key => $value_array) {
					if (isset($value_array['sample_description_table'])) {
						foreach ($value_array['sample_description_table'] as $key2 => $value_array2) {
							if (isset($value_array2['data_format'])) {
								switch ($value_array2['data_format']) {
									case 'avc1':
									case 'mp4v':
										// video data
										$isVideo = true;
										break;
									case 'mp4a':
										// audio data
										break;
								}
							}
						}
					} elseif (isset($value_array['time_to_sample_table'])) {
						foreach ($value_array['time_to_sample_table'] as $key2 => $value_array2) {
							if (isset($value_array2['sample_count']) && isset($value_array2['sample_duration']) && ($value_array2['sample_duration'] > 0)) {
								$framerate  = round($ThisFileInfo['quicktime']['time_scale'] / $value_array2['sample_duration'], 3);
								$framecount = $value_array2['sample_count'];
							}
						}
					}
				}
				if ($isVideo && $framerate) {
					$ThisFileInfo['quicktime']['video']['frame_rate'] = $framerate;
					$ThisFileInfo['video']['frame_rate'] = $ThisFileInfo['quicktime']['video']['frame_rate'];
				}
				if ($isVideo && $framecount) {
					$ThisFileInfo['quicktime']['video']['frame_count'] = $framecount;
				}
				break;


			case 'aART': // Album ARTist
			case 'catg': // CaTeGory
			case 'covr': // COVeR artwork
			case 'cpil': // ComPILation
			case 'cprt': // CoPyRighT
			case 'desc': // DESCription
			case 'disk': // DISK number
			case 'egid': // Episode Global ID
			case 'gnre': // GeNRE
			case 'keyw': // KEYWord
			case 'ldes':
			case 'pcst': // PodCaST
			case 'pgap': // GAPless Playback
			case 'purd': // PURchase Date
			case 'purl': // Podcast URL
			case 'rati':
			case 'rndu':
			case 'rpdu':
			case 'rtng': // RaTiNG
			case 'stik':
			case 'tmpo': // TeMPO (BPM)
			case 'trkn': // TRacK Number
			case 'tves': // TV EpiSode
			case 'tvnn': // TV Network Name
			case 'tvsh': // TV SHow Name
			case 'tvsn': // TV SeasoN
			case 'akID': // iTunes store account type
			case 'apID':
			case 'atID':
			case 'cmID':
			case 'cnID':
			case 'geID':
			case 'plID':
			case 'sfID': // iTunes store country
			case '�alb': // ALBum
			case '�art': // ARTist
			case '�ART':
			case '�aut':
			case '�cmt': // CoMmenT
			case '�com': // COMposer
			case '�cpy':
			case '�day': // content created year
			case '�dir':
			case '�ed1':
			case '�ed2':
			case '�ed3':
			case '�ed4':
			case '�ed5':
			case '�ed6':
			case '�ed7':
			case '�ed8':
			case '�ed9':
			case '�enc':
			case '�fmt':
			case '�gen': // GENre
			case '�grp': // GRouPing
			case '�hst':
			case '�inf':
			case '�lyr': // LYRics
			case '�mak':
			case '�mod':
			case '�nam': // full NAMe
			case '�ope':
			case '�PRD':
			case '�prd':
			case '�prf':
			case '�req':
			case '�src':
			case '�swr':
			case '�too': // encoder
			case '�trk': // TRacK
			case '�url':
			case '�wrn':
			case '�wrt': // WRiTer
			case '----': // itunes specific
				if ($atomparent == 'udta') {
					// User data atom handler
					$atom_structure['data_length'] = getid3_lib::BigEndian2Int(substr($atom_data,  0, 2));
					$atom_structure['language_id'] = getid3_lib::BigEndian2Int(substr($atom_data,  2, 2));
					$atom_structure['data']        =                           substr($atom_data,  4);

					$atom_structure['language']    = $this->QuicktimeLanguageLookup($atom_structure['language_id']);
					if (empty($ThisFileInfo['comments']['language']) || (!in_array($atom_structure['language'], $ThisFileInfo['comments']['language']))) {
						$ThisFileInfo['comments']['language'][] = $atom_structure['language'];
					}
				} else {
					// Apple item list box atom handler
					$atomoffset = 0;
					while ($atomoffset < strlen($atom_data)) {
						$boxsize = getid3_lib::BigEndian2Int(substr($atom_data, $atomoffset, 4));
						$boxtype =                           substr($atom_data, $atomoffset + 4, 4);
						$boxdata =                           substr($atom_data, $atomoffset + 8, $boxsize - 8);

						switch ($boxtype) {
							case 'mean':
							case 'name':
								$atom_structure[$boxtype] = substr($boxdata, 4);
								break;

							case 'data':
								$atom_structure['version']   = getid3_lib::BigEndian2Int(substr($boxdata,  0, 1));
								$atom_structure['flags_raw'] = getid3_lib::BigEndian2Int(substr($boxdata,  1, 3));
								switch ($atom_structure['flags_raw']) {
									case 0:  // data flag
									case 21: // tmpo/cpil flag
										switch ($atomname) {
											case 'cpil':
											case 'pcst':
											case 'pgap':
												$atom_structure['data'] = getid3_lib::BigEndian2Int(substr($boxdata, 8, 1));
												break;

											case 'tmpo':
												$atom_structure['data'] = getid3_lib::BigEndian2Int(substr($boxdata, 8, 2));
												break;

											case 'disk':
											case 'trkn':
												$num       = getid3_lib::BigEndian2Int(substr($boxdata, 10, 2));
												$num_total = getid3_lib::BigEndian2Int(substr($boxdata, 12, 2));
												$atom_structure['data']  = empty($num) ? '' : $num;
												$atom_structure['data'] .= empty($num_total) ? '' : '/'.$num_total;
												break;

											case 'gnre':
												$GenreID = getid3_lib::BigEndian2Int(substr($boxdata, 8, 4));
												$atom_structure['data']    = getid3_id3v1::LookupGenreName($GenreID - 1);
												break;

											case 'rtng':
												$atom_structure[$atomname] = getid3_lib::BigEndian2Int(substr($boxdata, 8, 1));
												$atom_structure['data']    = $this->QuicktimeContentRatingLookup($atom_structure[$atomname]);
												break;

											case 'stik':
												$atom_structure[$atomname] = getid3_lib::BigEndian2Int(substr($boxdata, 8, 1));
												$atom_structure['data']    = $this->QuicktimeSTIKLookup($atom_structure[$atomname]);
												break;

											case 'sfID':
												$atom_structure[$atomname] = getid3_lib::BigEndian2Int(substr($boxdata, 8, 4));
												$atom_structure['data']    = $this->QuicktimeStoreFrontCodeLookup($atom_structure[$atomname]);
												break;

											case 'egid':
											case 'purl':
												$atom_structure['data'] = substr($boxdata, 8);
												break;

											default:
												$atom_structure['data'] = getid3_lib::BigEndian2Int(substr($boxdata, 8, 4));
										}
										break;

									case 1:  // text flag
									case 13: // image flag
									default:
										$atom_structure['data'] = substr($boxdata, 8);
										break;

								}
								break;

							default:
								$ThisFileInfo['warning'][] = 'Unknown QuickTime box type: "'.$boxtype.'" at offset '.$baseoffset;
								$atom_structure['data'] = $atom_data;

						}
						$atomoffset += $boxsize;
					}
				}
				$this->CopyToAppropriateCommentsSection($atomname, $atom_structure['data'], $ThisFileInfo, $atom_structure['name']);
				break;


			case 'play': // auto-PLAY atom
				$atom_structure['autoplay']             = (bool) getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));

				$ThisFileInfo['quicktime']['autoplay'] = $atom_structure['autoplay'];
				break;


			case 'WLOC': // Window LOCation atom
				$atom_structure['location_x']  = getid3_lib::BigEndian2Int(substr($atom_data,  0, 2));
				$atom_structure['location_y']  = getid3_lib::BigEndian2Int(substr($atom_data,  2, 2));
				break;


			case 'LOOP': // LOOPing atom
			case 'SelO': // play SELection Only atom
			case 'AllF': // play ALL Frames atom
				$atom_structure['data'] = getid3_lib::BigEndian2Int($atom_data);
				break;


			case 'name': //
			case 'MCPS': // Media Cleaner PRo
			case '@PRM': // adobe PReMiere version
			case '@PRQ': // adobe PRemiere Quicktime version
				$atom_structure['data'] = $atom_data;
				break;


			case 'cmvd': // Compressed MooV Data atom
				// Code by ubergeek�ubergeek*tv based on information from
				// http://developer.apple.com/quicktime/icefloe/dispatch012.html
				$atom_structure['unCompressedSize'] = getid3_lib::BigEndian2Int(substr($atom_data, 0, 4));

				$CompressedFileData = substr($atom_data, 4);
				ob_start();
				if ($UncompressedHeader = gzuncompress($CompressedFileData)) {
					ob_end_clean();
					$atom_structure['subatoms'] = $this->QuicktimeParseContainerAtom($UncompressedHeader, $ThisFileInfo, 0, $atomHierarchy, $ParseAllPossibleAtoms);
				} else {
					$errormessage = ob_get_contents();
					ob_end_clean();
					$ThisFileInfo['warning'][] = 'Error decompressing compressed MOV atom at offset '.$atom_structure['offset'];
				}
				break;


			case 'dcom': // Data COMpression atom
				$atom_structure['compression_id']   = $atom_data;
				$atom_structure['compression_text'] = $this->QuicktimeDCOMLookup($atom_data);
				break;


			case 'rdrf': // Reference movie Data ReFerence atom
				$atom_structure['version']                = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']              = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3));
				$atom_structure['flags']['internal_data'] = (bool) ($atom_structure['flags_raw'] & 0x000001);

				$atom_structure['reference_type_name']    =                           substr($atom_data,  4, 4);
				$atom_structure['reference_length']       = getid3_lib::BigEndian2Int(substr($atom_data,  8, 4));
				switch ($atom_structure['reference_type_name']) {
					case 'url ':
						$atom_structure['url']            =       $this->NoNullString(substr($atom_data, 12));
						break;

					case 'alis':
						$atom_structure['file_alias']     =                           substr($atom_data, 12);
						break;

					case 'rsrc':
						$atom_structure['resource_alias'] =                           substr($atom_data, 12);
						break;

					default:
						$atom_structure['data']           =                           substr($atom_data, 12);
						break;
				}
				break;


			case 'rmqu': // Reference Movie QUality atom
				$atom_structure['movie_quality'] = getid3_lib::BigEndian2Int($atom_data);
				break;


			case 'rmcs': // Reference Movie Cpu Speed atom
				$atom_structure['version']          = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']        = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['cpu_speed_rating'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 2));
				break;


			case 'rmvc': // Reference Movie Version Check atom
				$atom_structure['version']            = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']          = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['gestalt_selector']   =                           substr($atom_data,  4, 4);
				$atom_structure['gestalt_value_mask'] = getid3_lib::BigEndian2Int(substr($atom_data,  8, 4));
				$atom_structure['gestalt_value']      = getid3_lib::BigEndian2Int(substr($atom_data, 12, 4));
				$atom_structure['gestalt_check_type'] = getid3_lib::BigEndian2Int(substr($atom_data, 14, 2));
				break;


			case 'rmcd': // Reference Movie Component check atom
				$atom_structure['version']                = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']              = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['component_type']         =                           substr($atom_data,  4, 4);
				$atom_structure['component_subtype']      =                           substr($atom_data,  8, 4);
				$atom_structure['component_manufacturer'] =                           substr($atom_data, 12, 4);
				$atom_structure['component_flags_raw']    = getid3_lib::BigEndian2Int(substr($atom_data, 16, 4));
				$atom_structure['component_flags_mask']   = getid3_lib::BigEndian2Int(substr($atom_data, 20, 4));
				$atom_structure['component_min_version']  = getid3_lib::BigEndian2Int(substr($atom_data, 24, 4));
				break;


			case 'rmdr': // Reference Movie Data Rate atom
				$atom_structure['version']       = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']     = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['data_rate']     = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));

				$atom_structure['data_rate_bps'] = $atom_structure['data_rate'] * 10;
				break;


			case 'rmla': // Reference Movie Language Atom
				$atom_structure['version']     = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']   = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['language_id'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 2));

				$atom_structure['language']    = $this->QuicktimeLanguageLookup($atom_structure['language_id']);
				if (empty($ThisFileInfo['comments']['language']) || (!in_array($atom_structure['language'], $ThisFileInfo['comments']['language']))) {
					$ThisFileInfo['comments']['language'][] = $atom_structure['language'];
				}
				break;


			case 'rmla': // Reference Movie Language Atom
				$atom_structure['version']   = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw'] = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['track_id']  = getid3_lib::BigEndian2Int(substr($atom_data,  4, 2));
				break;


			case 'ptv ': // Print To Video - defines a movie's full screen mode
				// http://developer.apple.com/documentation/QuickTime/APIREF/SOURCESIV/at_ptv-_pg.htm
				$atom_structure['display_size_raw']  = getid3_lib::BigEndian2Int(substr($atom_data, 0, 2));
				$atom_structure['reserved_1']        = getid3_lib::BigEndian2Int(substr($atom_data, 2, 2)); // hardcoded: 0x0000
				$atom_structure['reserved_2']        = getid3_lib::BigEndian2Int(substr($atom_data, 4, 2)); // hardcoded: 0x0000
				$atom_structure['slide_show_flag']   = getid3_lib::BigEndian2Int(substr($atom_data, 6, 1));
				$atom_structure['play_on_open_flag'] = getid3_lib::BigEndian2Int(substr($atom_data, 7, 1));

				$atom_structure['flags']['play_on_open'] = (bool) $atom_structure['play_on_open_flag'];
				$atom_structure['flags']['slide_show']   = (bool) $atom_structure['slide_show_flag'];

				$ptv_lookup[0] = 'normal';
				$ptv_lookup[1] = 'double';
				$ptv_lookup[2] = 'half';
				$ptv_lookup[3] = 'full';
				$ptv_lookup[4] = 'current';
				if (isset($ptv_lookup[$atom_structure['display_size_raw']])) {
					$atom_structure['display_size'] = $ptv_lookup[$atom_structure['display_size_raw']];
				} else {
					$ThisFileInfo['warning'][] = 'unknown "ptv " display constant ('.$atom_structure['display_size_raw'].')';
				}
				break;


			case 'stsd': // Sample Table Sample Description atom
				$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				$stsdEntriesDataOffset = 8;
				for ($i = 0; $i < $atom_structure['number_entries']; $i++) {
					$atom_structure['sample_description_table'][$i]['size']             = getid3_lib::BigEndian2Int(substr($atom_data, $stsdEntriesDataOffset, 4));
					$stsdEntriesDataOffset += 4;
					$atom_structure['sample_description_table'][$i]['data_format']      =                           substr($atom_data, $stsdEntriesDataOffset, 4);
					$stsdEntriesDataOffset += 4;
					$atom_structure['sample_description_table'][$i]['reserved']         = getid3_lib::BigEndian2Int(substr($atom_data, $stsdEntriesDataOffset, 6));
					$stsdEntriesDataOffset += 6;
					$atom_structure['sample_description_table'][$i]['reference_index']  = getid3_lib::BigEndian2Int(substr($atom_data, $stsdEntriesDataOffset, 2));
					$stsdEntriesDataOffset += 2;
					$atom_structure['sample_description_table'][$i]['data']             =                           substr($atom_data, $stsdEntriesDataOffset, ($atom_structure['sample_description_table'][$i]['size'] - 4 - 4 - 6 - 2));
					$stsdEntriesDataOffset += ($atom_structure['sample_description_table'][$i]['size'] - 4 - 4 - 6 - 2);

					$atom_structure['sample_description_table'][$i]['encoder_version']  = getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'],  0, 2));
					$atom_structure['sample_description_table'][$i]['encoder_revision'] = getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'],  2, 2));
					$atom_structure['sample_description_table'][$i]['encoder_vendor']   =                           substr($atom_structure['sample_description_table'][$i]['data'],  4, 4);

					switch ($atom_structure['sample_description_table'][$i]['encoder_vendor']) {

						case "\x00\x00\x00\x00":
							// audio atom
							$atom_structure['sample_description_table'][$i]['audio_channels']       =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'],  8,  2));
							$atom_structure['sample_description_table'][$i]['audio_bit_depth']      =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 10,  2));
							$atom_structure['sample_description_table'][$i]['audio_compression_id'] =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 12,  2));
							$atom_structure['sample_description_table'][$i]['audio_packet_size']    =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 14,  2));
							$atom_structure['sample_description_table'][$i]['audio_sample_rate']    = getid3_lib::FixedPoint16_16(substr($atom_structure['sample_description_table'][$i]['data'], 16,  4));

							switch ($atom_structure['sample_description_table'][$i]['data_format']) {
								case 'avc1':
								case 'mp4v':
									$ThisFileInfo['fileformat'] = 'mp4';
									$ThisFileInfo['video']['fourcc'] = $atom_structure['sample_description_table'][$i]['data_format'];
									//$ThisFileInfo['warning'][] = 'This version of getID3() [v'.GETID3_VERSION.'] does not fully support MPEG-4 audio/video streams'; // 2011-02-18: why am I warning about this again? What's not supported?
									break;

								case 'qtvr':
									$ThisFileInfo['video']['dataformat'] = 'quicktimevr';
									break;

								case 'mp4a':
								default:
									$ThisFileInfo['quicktime']['audio']['codec']       = $this->QuicktimeAudioCodecLookup($atom_structure['sample_description_table'][$i]['data_format']);
									$ThisFileInfo['quicktime']['audio']['sample_rate'] = $atom_structure['sample_description_table'][$i]['audio_sample_rate'];
									$ThisFileInfo['quicktime']['audio']['channels']    = $atom_structure['sample_description_table'][$i]['audio_channels'];
									$ThisFileInfo['quicktime']['audio']['bit_depth']   = $atom_structure['sample_description_table'][$i]['audio_bit_depth'];
									$ThisFileInfo['audio']['codec']                    = $ThisFileInfo['quicktime']['audio']['codec'];
									$ThisFileInfo['audio']['sample_rate']              = $ThisFileInfo['quicktime']['audio']['sample_rate'];
									$ThisFileInfo['audio']['channels']                 = $ThisFileInfo['quicktime']['audio']['channels'];
									$ThisFileInfo['audio']['bits_per_sample']          = $ThisFileInfo['quicktime']['audio']['bit_depth'];
									switch ($atom_structure['sample_description_table'][$i]['data_format']) {
										case 'raw ': // PCM
										case 'alac': // Apple Lossless Audio Codec
											$ThisFileInfo['audio']['lossless'] = true;
											break;
										default:
											$ThisFileInfo['audio']['lossless'] = false;
											break;
									}
									break;
							}
							break;

						default:
							switch ($atom_structure['sample_description_table'][$i]['data_format']) {
								case 'mp4s':
									$ThisFileInfo['fileformat'] = 'mp4';
									break;

								default:
									// video atom
									$atom_structure['sample_description_table'][$i]['video_temporal_quality']  =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'],  8,  4));
									$atom_structure['sample_description_table'][$i]['video_spatial_quality']   =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 12,  4));
									$atom_structure['sample_description_table'][$i]['video_frame_width']       =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 16,  2));
									$atom_structure['sample_description_table'][$i]['video_frame_height']      =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 18,  2));
									$atom_structure['sample_description_table'][$i]['video_resolution_x']      = getid3_lib::FixedPoint16_16(substr($atom_structure['sample_description_table'][$i]['data'], 20,  4));
									$atom_structure['sample_description_table'][$i]['video_resolution_y']      = getid3_lib::FixedPoint16_16(substr($atom_structure['sample_description_table'][$i]['data'], 24,  4));
									$atom_structure['sample_description_table'][$i]['video_data_size']         =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 28,  4));
									$atom_structure['sample_description_table'][$i]['video_frame_count']       =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 32,  2));
									$atom_structure['sample_description_table'][$i]['video_encoder_name_len']  =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 34,  1));
									$atom_structure['sample_description_table'][$i]['video_encoder_name']      =                             substr($atom_structure['sample_description_table'][$i]['data'], 35, $atom_structure['sample_description_table'][$i]['video_encoder_name_len']);
									$atom_structure['sample_description_table'][$i]['video_pixel_color_depth'] =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 66,  2));
									$atom_structure['sample_description_table'][$i]['video_color_table_id']    =   getid3_lib::BigEndian2Int(substr($atom_structure['sample_description_table'][$i]['data'], 68,  2));

									$atom_structure['sample_description_table'][$i]['video_pixel_color_type']  = (($atom_structure['sample_description_table'][$i]['video_pixel_color_depth'] > 32) ? 'grayscale' : 'color');
									$atom_structure['sample_description_table'][$i]['video_pixel_color_name']  = $this->QuicktimeColorNameLookup($atom_structure['sample_description_table'][$i]['video_pixel_color_depth']);

									if ($atom_structure['sample_description_table'][$i]['video_pixel_color_name'] != 'invalid') {
										$ThisFileInfo['quicktime']['video']['codec_fourcc']        = $atom_structure['sample_description_table'][$i]['data_format'];
										$ThisFileInfo['quicktime']['video']['codec_fourcc_lookup'] = $this->QuicktimeVideoCodecLookup($atom_structure['sample_description_table'][$i]['data_format']);
										$ThisFileInfo['quicktime']['video']['codec']               = (($atom_structure['sample_description_table'][$i]['video_encoder_name_len'] > 0) ? $atom_structure['sample_description_table'][$i]['video_encoder_name'] : $atom_structure['sample_description_table'][$i]['data_format']);
										$ThisFileInfo['quicktime']['video']['color_depth']         = $atom_structure['sample_description_table'][$i]['video_pixel_color_depth'];
										$ThisFileInfo['quicktime']['video']['color_depth_name']    = $atom_structure['sample_description_table'][$i]['video_pixel_color_name'];

										$ThisFileInfo['video']['codec']           = $ThisFileInfo['quicktime']['video']['codec'];
										$ThisFileInfo['video']['bits_per_sample'] = $ThisFileInfo['quicktime']['video']['color_depth'];
									}
									$ThisFileInfo['video']['lossless']           = false;
									$ThisFileInfo['video']['pixel_aspect_ratio'] = (float) 1;
									break;
							}
							break;
					}
					switch (strtolower($atom_structure['sample_description_table'][$i]['data_format'])) {
						case 'mp4a':
							$ThisFileInfo['audio']['dataformat']         = 'mp4';
							$ThisFileInfo['quicktime']['audio']['codec'] = 'mp4';
							break;

						case '3ivx':
						case '3iv1':
						case '3iv2':
							$ThisFileInfo['video']['dataformat'] = '3ivx';
							break;

						case 'xvid':
							$ThisFileInfo['video']['dataformat'] = 'xvid';
							break;

						case 'mp4v':
							$ThisFileInfo['video']['dataformat'] = 'mpeg4';
							break;

						case 'divx':
						case 'div1':
						case 'div2':
						case 'div3':
						case 'div4':
						case 'div5':
						case 'div6':
							$TDIVXileInfo['video']['dataformat'] = 'divx';
							break;

						default:
							// do nothing
							break;
					}
					unset($atom_structure['sample_description_table'][$i]['data']);
				}
				break;


			case 'stts': // Sample Table Time-to-Sample atom
				$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				$sttsEntriesDataOffset = 8;
				//$FrameRateCalculatorArray = array();
				$frames_count = 0;
				for ($i = 0; $i < $atom_structure['number_entries']; $i++) {
					$atom_structure['time_to_sample_table'][$i]['sample_count']    = getid3_lib::BigEndian2Int(substr($atom_data, $sttsEntriesDataOffset, 4));
					$sttsEntriesDataOffset += 4;
					$atom_structure['time_to_sample_table'][$i]['sample_duration'] = getid3_lib::BigEndian2Int(substr($atom_data, $sttsEntriesDataOffset, 4));
					$sttsEntriesDataOffset += 4;

					$frames_count += $atom_structure['time_to_sample_table'][$i]['sample_count'];

					// THIS SECTION REPLACED WITH CODE IN "stbl" ATOM
					//if (!empty($ThisFileInfo['quicktime']['time_scale']) && ($atom_structure['time_to_sample_table'][$i]['sample_duration'] > 0)) {
					//	$stts_new_framerate = $ThisFileInfo['quicktime']['time_scale'] / $atom_structure['time_to_sample_table'][$i]['sample_duration'];
					//	if ($stts_new_framerate <= 60) {
					//		// some atoms have durations of "1" giving a very large framerate, which probably is not right
					//		$ThisFileInfo['video']['frame_rate'] = max($ThisFileInfo['video']['frame_rate'], $stts_new_framerate);
					//	}
					//}
					//
					//$FrameRateCalculatorArray[($ThisFileInfo['quicktime']['time_scale'] / $atom_structure['time_to_sample_table'][$i]['sample_duration'])] += $atom_structure['time_to_sample_table'][$i]['sample_count'];
				}
				$ThisFileInfo['quicktime']['stts_framecount'][] = $frames_count;
				//$sttsFramesTotal  = 0;
				//$sttsSecondsTotal = 0;
				//foreach ($FrameRateCalculatorArray as $frames_per_second => $frame_count) {
				//	if (($frames_per_second > 60) || ($frames_per_second < 1)) {
				//		// not video FPS information, probably audio information
				//		$sttsFramesTotal  = 0;
				//		$sttsSecondsTotal = 0;
				//		break;
				//	}
				//	$sttsFramesTotal  += $frame_count;
				//	$sttsSecondsTotal += $frame_count / $frames_per_second;
				//}
				//if (($sttsFramesTotal > 0) && ($sttsSecondsTotal > 0)) {
				//	if (($sttsFramesTotal / $sttsSecondsTotal) > $ThisFileInfo['video']['frame_rate']) {
				//		$ThisFileInfo['video']['frame_rate'] = $sttsFramesTotal / $sttsSecondsTotal;
				//	}
				//}
				break;


			case 'stss': // Sample Table Sync Sample (key frames) atom
				if ($ParseAllPossibleAtoms) {
					$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
					$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
					$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
					$stssEntriesDataOffset = 8;
					for ($i = 0; $i < $atom_structure['number_entries']; $i++) {
						$atom_structure['time_to_sample_table'][$i] = getid3_lib::BigEndian2Int(substr($atom_data, $stssEntriesDataOffset, 4));
						$stssEntriesDataOffset += 4;
					}
				}
				break;


			case 'stsc': // Sample Table Sample-to-Chunk atom
				if ($ParseAllPossibleAtoms) {
					$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
					$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
					$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
					$stscEntriesDataOffset = 8;
					for ($i = 0; $i < $atom_structure['number_entries']; $i++) {
						$atom_structure['sample_to_chunk_table'][$i]['first_chunk']        = getid3_lib::BigEndian2Int(substr($atom_data, $stscEntriesDataOffset, 4));
						$stscEntriesDataOffset += 4;
						$atom_structure['sample_to_chunk_table'][$i]['samples_per_chunk']  = getid3_lib::BigEndian2Int(substr($atom_data, $stscEntriesDataOffset, 4));
						$stscEntriesDataOffset += 4;
						$atom_structure['sample_to_chunk_table'][$i]['sample_description'] = getid3_lib::BigEndian2Int(substr($atom_data, $stscEntriesDataOffset, 4));
						$stscEntriesDataOffset += 4;
					}
				}
				break;


			case 'stsz': // Sample Table SiZe atom
				if ($ParseAllPossibleAtoms) {
					$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
					$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
					$atom_structure['sample_size']    = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
					$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  8, 4));
					$stszEntriesDataOffset = 12;
					if ($atom_structure['sample_size'] == 0) {
						for ($i = 0; $i < $atom_structure['number_entries']; $i++) {
							$atom_structure['sample_size_table'][$i] = getid3_lib::BigEndian2Int(substr($atom_data, $stszEntriesDataOffset, 4));
							$stszEntriesDataOffset += 4;
						}
					}
				}
				break;


			case 'stco': // Sample Table Chunk Offset atom
				if ($ParseAllPossibleAtoms) {
					$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
					$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
					$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
					$stcoEntriesDataOffset = 8;
					for ($i = 0; $i < $atom_structure['number_entries']; $i++) {
						$atom_structure['chunk_offset_table'][$i] = getid3_lib::BigEndian2Int(substr($atom_data, $stcoEntriesDataOffset, 4));
						$stcoEntriesDataOffset += 4;
					}
				}
				break;


			case 'co64': // Chunk Offset 64-bit (version of "stco" that supports > 2GB files)
				if ($ParseAllPossibleAtoms) {
					$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
					$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
					$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
					$stcoEntriesDataOffset = 8;
					for ($i = 0; $i < $atom_structure['number_entries']; $i++) {
						$atom_structure['chunk_offset_table'][$i] = getid3_lib::BigEndian2Int(substr($atom_data, $stcoEntriesDataOffset, 8));
						$stcoEntriesDataOffset += 8;
					}
				}
				break;


			case 'dref': // Data REFerence atom
				$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				$drefDataOffset = 8;
				for ($i = 0; $i < $atom_structure['number_entries']; $i++) {
					$atom_structure['data_references'][$i]['size']                    = getid3_lib::BigEndian2Int(substr($atom_data, $drefDataOffset, 4));
					$drefDataOffset += 4;
					$atom_structure['data_references'][$i]['type']                    =               substr($atom_data, $drefDataOffset, 4);
					$drefDataOffset += 4;
					$atom_structure['data_references'][$i]['version']                 = getid3_lib::BigEndian2Int(substr($atom_data,  $drefDataOffset, 1));
					$drefDataOffset += 1;
					$atom_structure['data_references'][$i]['flags_raw']               = getid3_lib::BigEndian2Int(substr($atom_data,  $drefDataOffset, 3)); // hardcoded: 0x0000
					$drefDataOffset += 3;
					$atom_structure['data_references'][$i]['data']                    =               substr($atom_data, $drefDataOffset, ($atom_structure['data_references'][$i]['size'] - 4 - 4 - 1 - 3));
					$drefDataOffset += ($atom_structure['data_references'][$i]['size'] - 4 - 4 - 1 - 3);

					$atom_structure['data_references'][$i]['flags']['self_reference'] = (bool) ($atom_structure['data_references'][$i]['flags_raw'] & 0x001);
				}
				break;


			case 'gmin': // base Media INformation atom
				$atom_structure['version']                = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']              = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['graphics_mode']          = getid3_lib::BigEndian2Int(substr($atom_data,  4, 2));
				$atom_structure['opcolor_red']            = getid3_lib::BigEndian2Int(substr($atom_data,  6, 2));
				$atom_structure['opcolor_green']          = getid3_lib::BigEndian2Int(substr($atom_data,  8, 2));
				$atom_structure['opcolor_blue']           = getid3_lib::BigEndian2Int(substr($atom_data, 10, 2));
				$atom_structure['balance']                = getid3_lib::BigEndian2Int(substr($atom_data, 12, 2));
				$atom_structure['reserved']               = getid3_lib::BigEndian2Int(substr($atom_data, 14, 2));
				break;


			case 'smhd': // Sound Media information HeaDer atom
				$atom_structure['version']                = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']              = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['balance']                = getid3_lib::BigEndian2Int(substr($atom_data,  4, 2));
				$atom_structure['reserved']               = getid3_lib::BigEndian2Int(substr($atom_data,  6, 2));
				break;


			case 'vmhd': // Video Media information HeaDer atom
				$atom_structure['version']                = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']              = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3));
				$atom_structure['graphics_mode']          = getid3_lib::BigEndian2Int(substr($atom_data,  4, 2));
				$atom_structure['opcolor_red']            = getid3_lib::BigEndian2Int(substr($atom_data,  6, 2));
				$atom_structure['opcolor_green']          = getid3_lib::BigEndian2Int(substr($atom_data,  8, 2));
				$atom_structure['opcolor_blue']           = getid3_lib::BigEndian2Int(substr($atom_data, 10, 2));

				$atom_structure['flags']['no_lean_ahead'] = (bool) ($atom_structure['flags_raw'] & 0x001);
				break;


			case 'hdlr': // HanDLeR reference atom
				$atom_structure['version']                = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']              = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['component_type']         =                           substr($atom_data,  4, 4);
				$atom_structure['component_subtype']      =                           substr($atom_data,  8, 4);
				$atom_structure['component_manufacturer'] =                           substr($atom_data, 12, 4);
				$atom_structure['component_flags_raw']    = getid3_lib::BigEndian2Int(substr($atom_data, 16, 4));
				$atom_structure['component_flags_mask']   = getid3_lib::BigEndian2Int(substr($atom_data, 20, 4));
				$atom_structure['component_name']         =      $this->Pascal2String(substr($atom_data, 24));

				if (($atom_structure['component_subtype'] == 'STpn') && ($atom_structure['component_manufacturer'] == 'zzzz')) {
					$ThisFileInfo['video']['dataformat'] = 'quicktimevr';
				}
				break;


			case 'mdhd': // MeDia HeaDer atom
				$atom_structure['version']               = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']             = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['creation_time']         = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				$atom_structure['modify_time']           = getid3_lib::BigEndian2Int(substr($atom_data,  8, 4));
				$atom_structure['time_scale']            = getid3_lib::BigEndian2Int(substr($atom_data, 12, 4));
				$atom_structure['duration']              = getid3_lib::BigEndian2Int(substr($atom_data, 16, 4));
				$atom_structure['language_id']           = getid3_lib::BigEndian2Int(substr($atom_data, 20, 2));
				$atom_structure['quality']               = getid3_lib::BigEndian2Int(substr($atom_data, 22, 2));

				if ($atom_structure['time_scale'] == 0) {
					$ThisFileInfo['error'][] = 'Corrupt Quicktime file: mdhd.time_scale == zero';
					return false;
				}
				$ThisFileInfo['quicktime']['time_scale'] = (isset($ThisFileInfo['quicktime']['time_scale']) ? max($ThisFileInfo['quicktime']['time_scale'], $atom_structure['time_scale']) : $atom_structure['time_scale']);

				$atom_structure['creation_time_unix']    = getid3_lib::DateMac2Unix($atom_structure['creation_time']);
				$atom_structure['modify_time_unix']      = getid3_lib::DateMac2Unix($atom_structure['modify_time']);
				$atom_structure['playtime_seconds']      = $atom_structure['duration'] / $atom_structure['time_scale'];
				$atom_structure['language']              = $this->QuicktimeLanguageLookup($atom_structure['language_id']);
				if (empty($ThisFileInfo['comments']['language']) || (!in_array($atom_structure['language'], $ThisFileInfo['comments']['language']))) {
					$ThisFileInfo['comments']['language'][] = $atom_structure['language'];
				}
				break;


			case 'pnot': // Preview atom
				$atom_structure['modification_date']      = getid3_lib::BigEndian2Int(substr($atom_data,  0, 4)); // "standard Macintosh format"
				$atom_structure['version_number']         = getid3_lib::BigEndian2Int(substr($atom_data,  4, 2)); // hardcoded: 0x00
				$atom_structure['atom_type']              =               substr($atom_data,  6, 4);        // usually: 'PICT'
				$atom_structure['atom_index']             = getid3_lib::BigEndian2Int(substr($atom_data, 10, 2)); // usually: 0x01

				$atom_structure['modification_date_unix'] = getid3_lib::DateMac2Unix($atom_structure['modification_date']);
				break;


			case 'crgn': // Clipping ReGioN atom
				$atom_structure['region_size']   = getid3_lib::BigEndian2Int(substr($atom_data,  0, 2)); // The Region size, Region boundary box,
				$atom_structure['boundary_box']  = getid3_lib::BigEndian2Int(substr($atom_data,  2, 8)); // and Clipping region data fields
				$atom_structure['clipping_data'] =               substr($atom_data, 10);           // constitute a QuickDraw region.
				break;


			case 'load': // track LOAD settings atom
				$atom_structure['preload_start_time'] = getid3_lib::BigEndian2Int(substr($atom_data,  0, 4));
				$atom_structure['preload_duration']   = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				$atom_structure['preload_flags_raw']  = getid3_lib::BigEndian2Int(substr($atom_data,  8, 4));
				$atom_structure['default_hints_raw']  = getid3_lib::BigEndian2Int(substr($atom_data, 12, 4));

				$atom_structure['default_hints']['double_buffer'] = (bool) ($atom_structure['default_hints_raw'] & 0x0020);
				$atom_structure['default_hints']['high_quality']  = (bool) ($atom_structure['default_hints_raw'] & 0x0100);
				break;


			case 'tmcd': // TiMe CoDe atom
			case 'chap': // CHAPter list atom
			case 'sync': // SYNChronization atom
			case 'scpt': // tranSCriPT atom
			case 'ssrc': // non-primary SouRCe atom
				for ($i = 0; $i < (strlen($atom_data) % 4); $i++) {
					$atom_structure['track_id'][$i] = getid3_lib::BigEndian2Int(substr($atom_data, $i * 4, 4));
				}
				break;


			case 'elst': // Edit LiST atom
				$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['number_entries'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				for ($i = 0; $i < $atom_structure['number_entries']; $i++ ) {
					$atom_structure['edit_list'][$i]['track_duration'] =   getid3_lib::BigEndian2Int(substr($atom_data, 8 + ($i * 12) + 0, 4));
					$atom_structure['edit_list'][$i]['media_time']     =   getid3_lib::BigEndian2Int(substr($atom_data, 8 + ($i * 12) + 4, 4));
					$atom_structure['edit_list'][$i]['media_rate']     = getid3_lib::FixedPoint16_16(substr($atom_data, 8 + ($i * 12) + 8, 4));
				}
				break;


			case 'kmat': // compressed MATte atom
				$atom_structure['version']        = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']      = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3)); // hardcoded: 0x0000
				$atom_structure['matte_data_raw'] =               substr($atom_data,  4);
				break;


			case 'ctab': // Color TABle atom
				$atom_structure['color_table_seed']   = getid3_lib::BigEndian2Int(substr($atom_data,  0, 4)); // hardcoded: 0x00000000
				$atom_structure['color_table_flags']  = getid3_lib::BigEndian2Int(substr($atom_data,  4, 2)); // hardcoded: 0x8000
				$atom_structure['color_table_size']   = getid3_lib::BigEndian2Int(substr($atom_data,  6, 2)) + 1;
				for ($colortableentry = 0; $colortableentry < $atom_structure['color_table_size']; $colortableentry++) {
					$atom_structure['color_table'][$colortableentry]['alpha'] = getid3_lib::BigEndian2Int(substr($atom_data, 8 + ($colortableentry * 8) + 0, 2));
					$atom_structure['color_table'][$colortableentry]['red']   = getid3_lib::BigEndian2Int(substr($atom_data, 8 + ($colortableentry * 8) + 2, 2));
					$atom_structure['color_table'][$colortableentry]['green'] = getid3_lib::BigEndian2Int(substr($atom_data, 8 + ($colortableentry * 8) + 4, 2));
					$atom_structure['color_table'][$colortableentry]['blue']  = getid3_lib::BigEndian2Int(substr($atom_data, 8 + ($colortableentry * 8) + 6, 2));
				}
				break;


			case 'mvhd': // MoVie HeaDer atom
				$atom_structure['version']            =   getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']          =   getid3_lib::BigEndian2Int(substr($atom_data,  1, 3));
				$atom_structure['creation_time']      =   getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				$atom_structure['modify_time']        =   getid3_lib::BigEndian2Int(substr($atom_data,  8, 4));
				$atom_structure['time_scale']         =   getid3_lib::BigEndian2Int(substr($atom_data, 12, 4));
				$atom_structure['duration']           =   getid3_lib::BigEndian2Int(substr($atom_data, 16, 4));
				$atom_structure['preferred_rate']     = getid3_lib::FixedPoint16_16(substr($atom_data, 20, 4));
				$atom_structure['preferred_volume']   =   getid3_lib::FixedPoint8_8(substr($atom_data, 24, 2));
				$atom_structure['reserved']           =                             substr($atom_data, 26, 10);
				$atom_structure['matrix_a']           = getid3_lib::FixedPoint16_16(substr($atom_data, 36, 4));
				$atom_structure['matrix_b']           = getid3_lib::FixedPoint16_16(substr($atom_data, 40, 4));
				$atom_structure['matrix_u']           =  getid3_lib::FixedPoint2_30(substr($atom_data, 44, 4));
				$atom_structure['matrix_c']           = getid3_lib::FixedPoint16_16(substr($atom_data, 48, 4));
				$atom_structure['matrix_d']           = getid3_lib::FixedPoint16_16(substr($atom_data, 52, 4));
				$atom_structure['matrix_v']           =  getid3_lib::FixedPoint2_30(substr($atom_data, 56, 4));
				$atom_structure['matrix_x']           = getid3_lib::FixedPoint16_16(substr($atom_data, 60, 4));
				$atom_structure['matrix_y']           = getid3_lib::FixedPoint16_16(substr($atom_data, 64, 4));
				$atom_structure['matrix_w']           =  getid3_lib::FixedPoint2_30(substr($atom_data, 68, 4));
				$atom_structure['preview_time']       =   getid3_lib::BigEndian2Int(substr($atom_data, 72, 4));
				$atom_structure['preview_duration']   =   getid3_lib::BigEndian2Int(substr($atom_data, 76, 4));
				$atom_structure['poster_time']        =   getid3_lib::BigEndian2Int(substr($atom_data, 80, 4));
				$atom_structure['selection_time']     =   getid3_lib::BigEndian2Int(substr($atom_data, 84, 4));
				$atom_structure['selection_duration'] =   getid3_lib::BigEndian2Int(substr($atom_data, 88, 4));
				$atom_structure['current_time']       =   getid3_lib::BigEndian2Int(substr($atom_data, 92, 4));
				$atom_structure['next_track_id']      =   getid3_lib::BigEndian2Int(substr($atom_data, 96, 4));

				if ($atom_structure['time_scale'] == 0) {
					$ThisFileInfo['error'][] = 'Corrupt Quicktime file: mvhd.time_scale == zero';
					return false;
				}
				$atom_structure['creation_time_unix']        = getid3_lib::DateMac2Unix($atom_structure['creation_time']);
				$atom_structure['modify_time_unix']          = getid3_lib::DateMac2Unix($atom_structure['modify_time']);
				$ThisFileInfo['quicktime']['time_scale']    = (isset($ThisFileInfo['quicktime']['time_scale']) ? max($ThisFileInfo['quicktime']['time_scale'], $atom_structure['time_scale']) : $atom_structure['time_scale']);
				$ThisFileInfo['quicktime']['display_scale'] = $atom_structure['matrix_a'];
				$ThisFileInfo['playtime_seconds']           = $atom_structure['duration'] / $atom_structure['time_scale'];
				break;


			case 'tkhd': // TracK HeaDer atom
				$atom_structure['version']             =   getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw']           =   getid3_lib::BigEndian2Int(substr($atom_data,  1, 3));
				$atom_structure['creation_time']       =   getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				$atom_structure['modify_time']         =   getid3_lib::BigEndian2Int(substr($atom_data,  8, 4));
				$atom_structure['trackid']             =   getid3_lib::BigEndian2Int(substr($atom_data, 12, 4));
				$atom_structure['reserved1']           =   getid3_lib::BigEndian2Int(substr($atom_data, 16, 4));
				$atom_structure['duration']            =   getid3_lib::BigEndian2Int(substr($atom_data, 20, 4));
				$atom_structure['reserved2']           =   getid3_lib::BigEndian2Int(substr($atom_data, 24, 8));
				$atom_structure['layer']               =   getid3_lib::BigEndian2Int(substr($atom_data, 32, 2));
				$atom_structure['alternate_group']     =   getid3_lib::BigEndian2Int(substr($atom_data, 34, 2));
				$atom_structure['volume']              =   getid3_lib::FixedPoint8_8(substr($atom_data, 36, 2));
				$atom_structure['reserved3']           =   getid3_lib::BigEndian2Int(substr($atom_data, 38, 2));
				$atom_structure['matrix_a']            = getid3_lib::FixedPoint16_16(substr($atom_data, 40, 4));
				$atom_structure['matrix_b']            = getid3_lib::FixedPoint16_16(substr($atom_data, 44, 4));
				$atom_structure['matrix_u']            = getid3_lib::FixedPoint16_16(substr($atom_data, 48, 4));
				$atom_structure['matrix_c']            = getid3_lib::FixedPoint16_16(substr($atom_data, 52, 4));
				$atom_structure['matrix_d']            = getid3_lib::FixedPoint16_16(substr($atom_data, 56, 4));
				$atom_structure['matrix_v']            = getid3_lib::FixedPoint16_16(substr($atom_data, 60, 4));
				$atom_structure['matrix_x']            =  getid3_lib::FixedPoint2_30(substr($atom_data, 64, 4));
				$atom_structure['matrix_y']            =  getid3_lib::FixedPoint2_30(substr($atom_data, 68, 4));
				$atom_structure['matrix_w']            =  getid3_lib::FixedPoint2_30(substr($atom_data, 72, 4));
				$atom_structure['width']               = getid3_lib::FixedPoint16_16(substr($atom_data, 76, 4));
				$atom_structure['height']              = getid3_lib::FixedPoint16_16(substr($atom_data, 80, 4));

				$atom_structure['flags']['enabled']    = (bool) ($atom_structure['flags_raw'] & 0x0001);
				$atom_structure['flags']['in_movie']   = (bool) ($atom_structure['flags_raw'] & 0x0002);
				$atom_structure['flags']['in_preview'] = (bool) ($atom_structure['flags_raw'] & 0x0004);
				$atom_structure['flags']['in_poster']  = (bool) ($atom_structure['flags_raw'] & 0x0008);
				$atom_structure['creation_time_unix']  = getid3_lib::DateMac2Unix($atom_structure['creation_time']);
				$atom_structure['modify_time_unix']    = getid3_lib::DateMac2Unix($atom_structure['modify_time']);

				if ($atom_structure['flags']['enabled'] == 1) {
					if (!isset($ThisFileInfo['video']['resolution_x']) || !isset($ThisFileInfo['video']['resolution_y'])) {
						$ThisFileInfo['video']['resolution_x'] = $atom_structure['width'];
						$ThisFileInfo['video']['resolution_y'] = $atom_structure['height'];
					}
					$ThisFileInfo['video']['resolution_x'] = max($ThisFileInfo['video']['resolution_x'], $atom_structure['width']);
					$ThisFileInfo['video']['resolution_y'] = max($ThisFileInfo['video']['resolution_y'], $atom_structure['height']);
					$ThisFileInfo['quicktime']['video']['resolution_x'] = $ThisFileInfo['video']['resolution_x'];
					$ThisFileInfo['quicktime']['video']['resolution_y'] = $ThisFileInfo['video']['resolution_y'];
				} else {
					if (isset($ThisFileInfo['video']['resolution_x'])) { unset($ThisFileInfo['video']['resolution_x']); }
					if (isset($ThisFileInfo['video']['resolution_y'])) { unset($ThisFileInfo['video']['resolution_y']); }
					if (isset($ThisFileInfo['quicktime']['video']))    { unset($ThisFileInfo['quicktime']['video']);    }
				}
				break;


			case 'iods': // Initial Object DeScriptor atom
				// http://www.koders.com/c/fid1FAB3E762903DC482D8A246D4A4BF9F28E049594.aspx?s=windows.h
				// http://libquicktime.sourcearchive.com/documentation/1.0.2plus-pdebian/iods_8c-source.html
				$offset = 0;
				$atom_structure['version']                =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 1));
				$offset += 1;
				$atom_structure['flags_raw']              =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 3));
				$offset += 3;
				$atom_structure['mp4_iod_tag']            =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 1));
				$offset += 1;
				$atom_structure['length']                 = $this->quicktime_read_mp4_descr_length($atom_data, $offset);
				//$offset already adjusted by quicktime_read_mp4_descr_length()
				$atom_structure['object_descriptor_id']   =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 2));
				$offset += 2;
				$atom_structure['od_profile_level']       =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 1));
				$offset += 1;
				$atom_structure['scene_profile_level']    =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 1));
				$offset += 1;
				$atom_structure['audio_profile_id']       =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 1));
				$offset += 1;
				$atom_structure['video_profile_id']       =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 1));
				$offset += 1;
				$atom_structure['graphics_profile_level'] =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 1));
				$offset += 1;

				$atom_structure['num_iods_tracks'] = ($atom_structure['length'] - 7) / 6; // 6 bytes would only be right if all tracks use 1-byte length fields
				for ($i = 0; $i < $atom_structure['num_iods_tracks']; $i++) {
					$atom_structure['track'][$i]['ES_ID_IncTag'] =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 1));
					$offset += 1;
					$atom_structure['track'][$i]['length']       = $this->quicktime_read_mp4_descr_length($atom_data, $offset);
					//$offset already adjusted by quicktime_read_mp4_descr_length()
					$atom_structure['track'][$i]['track_id']     =       getid3_lib::BigEndian2Int(substr($atom_data, $offset, 4));
					$offset += 4;
				}

				$atom_structure['audio_profile_name'] = $this->QuicktimeIODSaudioProfileName($atom_structure['audio_profile_id']);
				$atom_structure['video_profile_name'] = $this->QuicktimeIODSvideoProfileName($atom_structure['video_profile_id']);
				break;

			case 'meta': // METAdata atom
				// http://www.geocities.com/xhelmboyx/quicktime/formats/qti-layout.txt
				/*
				$NextTagPosition = strpos($atom_data, '�');
				while ($NextTagPosition < strlen($atom_data)) {
					$metaItemSize = getid3_lib::BigEndian2Int(substr($atom_data, $NextTagPosition - 4, 4)) - 4;
					if ($metaItemSize == -4) {
						break;
					}
					$metaItemRaw  = substr($atom_data, $NextTagPosition, $metaItemSize);
					$metaItemKey  = substr($metaItemRaw, 0, 4);
					$metaItemData = substr($metaItemRaw, 20);
					$NextTagPosition += $metaItemSize + 4;

					$this->CopyToAppropriateCommentsSection($metaItemKey, $metaItemData, $ThisFileInfo);
				}
				*/
				$atom_structure['version']   = getid3_lib::BigEndian2Int(substr($atom_data,  0, 1));
				$atom_structure['flags_raw'] = getid3_lib::BigEndian2Int(substr($atom_data,  1, 3));
				$atom_structure['subatoms']  = $this->QuicktimeParseContainerAtom(substr($atom_data, 4), $ThisFileInfo, $baseoffset + 8, $atomHierarchy, $ParseAllPossibleAtoms);
				break;

			case 'ftyp': // FileTYPe (?) atom (for MP4 it seems)
				$atom_structure['signature'] =                           substr($atom_data,  0, 4);
				$atom_structure['unknown_1'] = getid3_lib::BigEndian2Int(substr($atom_data,  4, 4));
				$atom_structure['fourcc']    =                           substr($atom_data,  8, 4);
				break;

			case 'mdat': // Media DATa atom
			case 'free': // FREE space atom
			case 'skip': // SKIP atom
			case 'wide': // 64-bit expansion placeholder atom
				// 'mdat' data is too big to deal with, contains no useful metadata
				// 'free', 'skip' and 'wide' are just padding, contains no useful data at all

				// When writing QuickTime files, it is sometimes necessary to update an atom's size.
				// It is impossible to update a 32-bit atom to a 64-bit atom since the 32-bit atom
				// is only 8 bytes in size, and the 64-bit atom requires 16 bytes. Therefore, QuickTime
				// puts an 8-byte placeholder atom before any atoms it may have to update the size of.
				// In this way, if the atom needs to be converted from a 32-bit to a 64-bit atom, the
				// placeholder atom can be overwritten to obtain the necessary 8 extra bytes.
				// The placeholder atom has a type of kWideAtomPlaceholderType ( 'wide' ).
				break;


			case 'nsav': // NoSAVe atom
				// http://developer.apple.com/technotes/tn/tn2038.html
				$atom_structure['data'] = getid3_lib::BigEndian2Int(substr($atom_data,  0, 4));
				break;

			case 'ctyp': // Controller TYPe atom (seen on QTVR)
				// http://homepages.slingshot.co.nz/~helmboy/quicktime/formats/qtm-layout.txt
				// some controller names are:
				//   0x00 + 'std' for linear movie
				//   'none' for no controls
				$atom_structure['ctyp'] = substr($atom_data, 0, 4);
				$ThisFileInfo['quicktime']['controller'] = $atom_structure['ctyp'];
				switch ($atom_structure['ctyp']) {
					case 'qtvr':
						$ThisFileInfo['video']['dataformat'] = 'quicktimevr';
						break;
				}
				break;

			case 'pano': // PANOrama track (seen on QTVR)
				$atom_structure['pano'] = getid3_lib::BigEndian2Int(substr($atom_data,  0, 4));
				break;

			case 'hint': // HINT track
			case 'hinf': //
			case 'hinv': //
			case 'hnti': //
				$ThisFileInfo['quicktime']['hinting'] = true;
				break;

			case 'imgt': // IMaGe Track reference (kQTVRImageTrackRefType) (seen on QTVR)
				for ($i = 0; $i < ($atom_structure['size'] - 8); $i += 4) {
					$atom_structure['imgt'][] = getid3_lib::BigEndian2Int(substr($atom_data, $i, 4));
				}
				break;


			// Observed-but-not-handled atom types are just listed here to prevent warnings being generated
			case 'FXTC': // Something to do with Adobe After Effects (?)
			case 'PrmA':
			case 'code':
			case 'FIEL': // this is NOT "fiel" (Field Ordering) as describe here: http://developer.apple.com/documentation/QuickTime/QTFF/QTFFChap3/chapter_4_section_2.html
			case 'tapt': // TrackApertureModeDimensionsAID - http://developer.apple.com/documentation/QuickTime/Reference/QT7-1_Update_Reference/Constants/Constants.html
						// tapt seems to be used to compute the video size [http://www.getid3.org/phpBB3/viewtopic.php?t=838]
						// * http://lists.apple.com/archives/quicktime-api/2006/Aug/msg00014.html
						// * http://handbrake.fr/irclogs/handbrake-dev/handbrake-dev20080128_pg2.html
			case 'ctts'://  STCompositionOffsetAID             - http://developer.apple.com/documentation/QuickTime/Reference/QTRef_Constants/Reference/reference.html
			case 'cslg'://  STCompositionShiftLeastGreatestAID - http://developer.apple.com/documentation/QuickTime/Reference/QTRef_Constants/Reference/reference.html
			case 'sdtp'://  STSampleDependencyAID              - http://developer.apple.com/documentation/QuickTime/Reference/QTRef_Constants/Reference/reference.html
			case 'stps'://  STPartialSyncSampleAID             - http://developer.apple.com/documentation/QuickTime/Reference/QTRef_Constants/Reference/reference.html
				//$atom_structure['data'] = $atom_data;
				break;

			default:
				$ThisFileInfo['warning'][] = 'Unknown QuickTime atom type: "'.$atomname.'" at offset '.$baseoffset;
				$atom_structure['data'] = $atom_data;
				break;
		}
		array_pop($atomHierarchy);
		return $atom_structure;
	}

	function QuicktimeParseContainerAtom($atom_data, &$ThisFileInfo, $baseoffset, &$atomHierarchy, $ParseAllPossibleAtoms) {
		$atom_structure  = false;
		$subatomoffset  = 0;
		$subatomcounter = 0;
		if ((strlen($atom_data) == 4) && (getid3_lib::BigEndian2Int($atom_data) == 0x00000000)) {
			return false;
		}
		while ($subatomoffset < strlen($atom_data)) {
			$subatomsize = getid3_lib::BigEndian2Int(substr($atom_data, $subatomoffset + 0, 4));
			$subatomname =               substr($atom_data, $subatomoffset + 4, 4);
			$subatomdata =               substr($atom_data, $subatomoffset + 8, $subatomsize - 8);
			if ($subatomsize == 0) {
				// Furthermore, for historical reasons the list of atoms is optionally
				// terminated by a 32-bit integer set to 0. If you are writing a program
				// to read user data atoms, you should allow for the terminating 0.
				return $atom_structure;
			}

			$atom_structure[$subatomcounter] = $this->QuicktimeParseAtom($subatomname, $subatomsize, $subatomdata, $ThisFileInfo, $baseoffset + $subatomoffset, $atomHierarchy, $ParseAllPossibleAtoms);

			$subatomoffset += $subatomsize;
			$subatomcounter++;
		}
		return $atom_structure;
	}


	function quicktime_read_mp4_descr_length($data, &$offset) {
		// http://libquicktime.sourcearchive.com/documentation/2:1.0.2plus-pdebian-2build1/esds_8c-source.html
		$num_bytes = 0;
		$length    = 0;
		do {
			$b = ord(substr($data, $offset++, 1));
			$length = ($length << 7) | ($b & 0x7F);
		} while (($b & 0x80) && ($num_bytes++ < 4));
		return $length;
	}


	function QuicktimeLanguageLookup($languageid) {
		static $QuicktimeLanguageLookup = array();
		if (empty($QuicktimeLanguageLookup)) {
			$QuicktimeLanguageLookup[0]   = 'English';
			$QuicktimeLanguageLookup[1]   = 'French';
			$QuicktimeLanguageLookup[2]   = 'German';
			$QuicktimeLanguageLookup[3]   = 'Italian';
			$QuicktimeLanguageLookup[4]   = 'Dutch';
			$QuicktimeLanguageLookup[5]   = 'Swedish';
			$QuicktimeLanguageLookup[6]   = 'Spanish';
			$QuicktimeLanguageLookup[7]   = 'Danish';
			$QuicktimeLanguageLookup[8]   = 'Portuguese';
			$QuicktimeLanguageLookup[9]   = 'Norwegian';
			$QuicktimeLanguageLookup[10]  = 'Hebrew';
			$QuicktimeLanguageLookup[11]  = 'Japanese';
			$QuicktimeLanguageLookup[12]  = 'Arabic';
			$QuicktimeLanguageLookup[13]  = 'Finnish';
			$QuicktimeLanguageLookup[14]  = 'Greek';
			$QuicktimeLanguageLookup[15]  = 'Icelandic';
			$QuicktimeLanguageLookup[16]  = 'Maltese';
			$QuicktimeLanguageLookup[17]  = 'Turkish';
			$QuicktimeLanguageLookup[18]  = 'Croatian';
			$QuicktimeLanguageLookup[19]  = 'Chinese (Traditional)';
			$QuicktimeLanguageLookup[20]  = 'Urdu';
			$QuicktimeLanguageLookup[21]  = 'Hindi';
			$QuicktimeLanguageLookup[22]  = 'Thai';
			$QuicktimeLanguageLookup[23]  = 'Korean';
			$QuicktimeLanguageLookup[24]  = 'Lithuanian';
			$QuicktimeLanguageLookup[25]  = 'Polish';
			$QuicktimeLanguageLookup[26]  = 'Hungarian';
			$QuicktimeLanguageLookup[27]  = 'Estonian';
			$QuicktimeLanguageLookup[28]  = 'Lettish';
			$QuicktimeLanguageLookup[28]  = 'Latvian';
			$QuicktimeLanguageLookup[29]  = 'Saamisk';
			$QuicktimeLanguageLookup[29]  = 'Lappish';
			$QuicktimeLanguageLookup[30]  = 'Faeroese';
			$QuicktimeLanguageLookup[31]  = 'Farsi';
			$QuicktimeLanguageLookup[31]  = 'Persian';
			$QuicktimeLanguageLookup[32]  = 'Russian';
			$QuicktimeLanguageLookup[33]  = 'Chinese (Simplified)';
			$QuicktimeLanguageLookup[34]  = 'Flemish';
			$QuicktimeLanguageLookup[35]  = 'Irish';
			$QuicktimeLanguageLookup[36]  = 'Albanian';
			$QuicktimeLanguageLookup[37]  = 'Romanian';
			$QuicktimeLanguageLookup[38]  = 'Czech';
			$QuicktimeLanguageLookup[39]  = 'Slovak';
			$QuicktimeLanguageLookup[40]  = 'Slovenian';
			$QuicktimeLanguageLookup[41]  = 'Yiddish';
			$QuicktimeLanguageLookup[42]  = 'Serbian';
			$QuicktimeLanguageLookup[43]  = 'Macedonian';
			$QuicktimeLanguageLookup[44]  = 'Bulgarian';
			$QuicktimeLanguageLookup[45]  = 'Ukrainian';
			$QuicktimeLanguageLookup[46]  = 'Byelorussian';
			$QuicktimeLanguageLookup[47]  = 'Uzbek';
			$QuicktimeLanguageLookup[48]  = 'Kazakh';
			$QuicktimeLanguageLookup[49]  = 'Azerbaijani';
			$QuicktimeLanguageLookup[50]  = 'AzerbaijanAr';
			$QuicktimeLanguageLookup[51]  = 'Armenian';
			$QuicktimeLanguageLookup[52]  = 'Georgian';
			$QuicktimeLanguageLookup[53]  = 'Moldavian';
			$QuicktimeLanguageLookup[54]  = 'Kirghiz';
			$QuicktimeLanguageLookup[55]  = 'Tajiki';
			$QuicktimeLanguageLookup[56]  = 'Turkmen';
			$QuicktimeLanguageLookup[57]  = 'Mongolian';
			$QuicktimeLanguageLookup[58]  = 'MongolianCyr';
			$QuicktimeLanguageLookup[59]  = 'Pashto';
			$QuicktimeLanguageLookup[60]  = 'Kurdish';
			$QuicktimeLanguageLookup[61]  = 'Kashmiri';
			$QuicktimeLanguageLookup[62]  = 'Sindhi';
			$QuicktimeLanguageLookup[63]  = 'Tibetan';
			$QuicktimeLanguageLookup[64]  = 'Nepali';
			$QuicktimeLanguageLookup[65]  = 'Sanskrit';
			$QuicktimeLanguageLookup[66]  = 'Marathi';
			$QuicktimeLanguageLookup[67]  = 'Bengali';
			$QuicktimeLanguageLookup[68]  = 'Assamese';
			$QuicktimeLanguageLookup[69]  = 'Gujarati';
			$QuicktimeLanguageLookup[70]  = 'Punjabi';
			$QuicktimeLanguageLookup[71]  = 'Oriya';
			$QuicktimeLanguageLookup[72]  = 'Malayalam';
			$QuicktimeLanguageLookup[73]  = 'Kannada';
			$QuicktimeLanguageLookup[74]  = 'Tamil';
			$QuicktimeLanguageLookup[75]  = 'Telugu';
			$QuicktimeLanguageLookup[76]  = 'Sinhalese';
			$QuicktimeLanguageLookup[77]  = 'Burmese';
			$QuicktimeLanguageLookup[78]  = 'Khmer';
			$QuicktimeLanguageLookup[79]  = 'Lao';
			$QuicktimeLanguageLookup[80]  = 'Vietnamese';
			$QuicktimeLanguageLookup[81]  = 'Indonesian';
			$QuicktimeLanguageLookup[82]  = 'Tagalog';
			$QuicktimeLanguageLookup[83]  = 'MalayRoman';
			$QuicktimeLanguageLookup[84]  = 'MalayArabic';
			$QuicktimeLanguageLookup[85]  = 'Amharic';
			$QuicktimeLanguageLookup[86]  = 'Tigrinya';
			$QuicktimeLanguageLookup[87]  = 'Galla';
			$QuicktimeLanguageLookup[87]  = 'Oromo';
			$QuicktimeLanguageLookup[88]  = 'Somali';
			$QuicktimeLanguageLookup[89]  = 'Swahili';
			$QuicktimeLanguageLookup[90]  = 'Ruanda';
			$QuicktimeLanguageLookup[91]  = 'Rundi';
			$QuicktimeLanguageLookup[92]  = 'Chewa';
			$QuicktimeLanguageLookup[93]  = 'Malagasy';
			$QuicktimeLanguageLookup[94]  = 'Esperanto';
			$QuicktimeLanguageLookup[128] = 'Welsh';
			$QuicktimeLanguageLookup[129] = 'Basque';
			$QuicktimeLanguageLookup[130] = 'Catalan';
			$QuicktimeLanguageLookup[131] = 'Latin';
			$QuicktimeLanguageLookup[132] = 'Quechua';
			$QuicktimeLanguageLookup[133] = 'Guarani';
			$QuicktimeLanguageLookup[134] = 'Aymara';
			$QuicktimeLanguageLookup[135] = 'Tatar';
			$QuicktimeLanguageLookup[136] = 'Uighur';
			$QuicktimeLanguageLookup[137] = 'Dzongkha';
			$QuicktimeLanguageLookup[138] = 'JavaneseRom';
		}
		return (isset($QuicktimeLanguageLookup[$languageid]) ? $QuicktimeLanguageLookup[$languageid] : 'invalid');
	}

	function QuicktimeVideoCodecLookup($codecid) {
		static $QuicktimeVideoCodecLookup = array();
		if (empty($QuicktimeVideoCodecLookup)) {
			$QuicktimeVideoCodecLookup['.SGI'] = 'SGI';
			$QuicktimeVideoCodecLookup['3IV1'] = '3ivx MPEG-4 v1';
			$QuicktimeVideoCodecLookup['3IV2'] = '3ivx MPEG-4 v2';
			$QuicktimeVideoCodecLookup['3IVX'] = '3ivx MPEG-4';
			$QuicktimeVideoCodecLookup['8BPS'] = 'Planar RGB';
			$QuicktimeVideoCodecLookup['avc1'] = 'H.264/MPEG-4 AVC';
			$QuicktimeVideoCodecLookup['avr '] = 'AVR-JPEG';
			$QuicktimeVideoCodecLookup['b16g'] = '16Gray';
			$QuicktimeVideoCodecLookup['b32a'] = '32AlphaGray';
			$QuicktimeVideoCodecLookup['b48r'] = '48RGB';
			$QuicktimeVideoCodecLookup['b64a'] = '64ARGB';
			$QuicktimeVideoCodecLookup['base'] = 'Base';
			$QuicktimeVideoCodecLookup['clou'] = 'Cloud';
			$QuicktimeVideoCodecLookup['cmyk'] = 'CMYK';
			$QuicktimeVideoCodecLookup['cvid'] = 'Cinepak';
			$QuicktimeVideoCodecLookup['dmb1'] = 'OpenDML JPEG';
			$QuicktimeVideoCodecLookup['dvc '] = 'DVC-NTSC';
			$QuicktimeVideoCodecLookup['dvcp'] = 'DVC-PAL';
			$QuicktimeVideoCodecLookup['dvpn'] = 'DVCPro-NTSC';
			$QuicktimeVideoCodecLookup['dvpp'] = 'DVCPro-PAL';
			$QuicktimeVideoCodecLookup['fire'] = 'Fire';
			$QuicktimeVideoCodecLookup['flic'] = 'FLC';
			$QuicktimeVideoCodecLookup['gif '] = 'GIF';
			$QuicktimeVideoCodecLookup['h261'] = 'H261';
			$QuicktimeVideoCodecLookup['h263'] = 'H263';
			$QuicktimeVideoCodecLookup['IV41'] = 'Indeo4';
			$QuicktimeVideoCodecLookup['jpeg'] = 'JPEG';
			$QuicktimeVideoCodecLookup['kpcd'] = 'PhotoCD';
			$QuicktimeVideoCodecLookup['mjpa'] = 'Motion JPEG-A';
			$QuicktimeVideoCodecLookup['mjpb'] = 'Motion JPEG-B';
			$QuicktimeVideoCodecLookup['msvc'] = 'Microsoft Video1';
			$QuicktimeVideoCodecLookup['myuv'] = 'MPEG YUV420';
			$QuicktimeVideoCodecLookup['path'] = 'Vector';
			$QuicktimeVideoCodecLookup['png '] = 'PNG';
			$QuicktimeVideoCodecLookup['PNTG'] = 'MacPaint';
			$QuicktimeVideoCodecLookup['qdgx'] = 'QuickDrawGX';
			$QuicktimeVideoCodecLookup['qdrw'] = 'QuickDraw';
			$QuicktimeVideoCodecLookup['raw '] = 'RAW';
			$QuicktimeVideoCodecLookup['ripl'] = 'WaterRipple';
			$QuicktimeVideoCodecLookup['rpza'] = 'Video';
			$QuicktimeVideoCodecLookup['smc '] = 'Graphics';
			$QuicktimeVideoCodecLookup['SVQ1'] = 'Sorenson Video 1';
			$QuicktimeVideoCodecLookup['SVQ1'] = 'Sorenson Video 3';
			$QuicktimeVideoCodecLookup['syv9'] = 'Sorenson YUV9';
			$QuicktimeVideoCodecLookup['tga '] = 'Targa';
			$QuicktimeVideoCodecLookup['tiff'] = 'TIFF';
			$QuicktimeVideoCodecLookup['WRAW'] = 'Windows RAW';
			$QuicktimeVideoCodecLookup['WRLE'] = 'BMP';
			$QuicktimeVideoCodecLookup['y420'] = 'YUV420';
			$QuicktimeVideoCodecLookup['yuv2'] = 'ComponentVideo';
			$QuicktimeVideoCodecLookup['yuvs'] = 'ComponentVideoUnsigned';
			$QuicktimeVideoCodecLookup['yuvu'] = 'ComponentVideoSigned';
		}
		return (isset($QuicktimeVideoCodecLookup[$codecid]) ? $QuicktimeVideoCodecLookup[$codecid] : '');
	}

	function QuicktimeAudioCodecLookup($codecid) {
		static $QuicktimeAudioCodecLookup = array();
		if (empty($QuicktimeAudioCodecLookup)) {
			$QuicktimeAudioCodecLookup['.mp3']          = 'Fraunhofer MPEG Layer-III alias';
			$QuicktimeAudioCodecLookup['aac ']          = 'ISO/IEC 14496-3 AAC';
			$QuicktimeAudioCodecLookup['agsm']          = 'Apple GSM 10:1';
			$QuicktimeAudioCodecLookup['alac']          = 'Apple Lossless Audio Codec';
			$QuicktimeAudioCodecLookup['alaw']          = 'A-law 2:1';
			$QuicktimeAudioCodecLookup['conv']          = 'Sample Format';
			$QuicktimeAudioCodecLookup['dvca']          = 'DV';
			$QuicktimeAudioCodecLookup['dvi ']          = 'DV 4:1';
			$QuicktimeAudioCodecLookup['eqal']          = 'Frequency Equalizer';
			$QuicktimeAudioCodecLookup['fl32']          = '32-bit Floating Point';
			$QuicktimeAudioCodecLookup['fl64']          = '64-bit Floating Point';
			$QuicktimeAudioCodecLookup['ima4']          = 'Interactive Multimedia Association 4:1';
			$QuicktimeAudioCodecLookup['in24']          = '24-bit Integer';
			$QuicktimeAudioCodecLookup['in32']          = '32-bit Integer';
			$QuicktimeAudioCodecLookup['lpc ']          = 'LPC 23:1';
			$QuicktimeAudioCodecLookup['MAC3']          = 'Macintosh Audio Compression/Expansion (MACE) 3:1';
			$QuicktimeAudioCodecLookup['MAC6']          = 'Macintosh Audio Compression/Expansion (MACE) 6:1';
			$QuicktimeAudioCodecLookup['mixb']          = '8-bit Mixer';
			$QuicktimeAudioCodecLookup['mixw']          = '16-bit Mixer';
			$QuicktimeAudioCodecLookup['mp4a']          = 'ISO/IEC 14496-3 AAC';
			$QuicktimeAudioCodecLookup['MS'."\x00\x02"] = 'Microsoft ADPCM';
			$QuicktimeAudioCodecLookup['MS'."\x00\x11"] = 'DV IMA';
			$QuicktimeAudioCodecLookup['MS'."\x00\x55"] = 'Fraunhofer MPEG Layer III';
			$QuicktimeAudioCodecLookup['NONE']          = 'No Encoding';
			$QuicktimeAudioCodecLookup['Qclp']          = 'Qualcomm PureVoice';
			$QuicktimeAudioCodecLookup['QDM2']          = 'QDesign Music 2';
			$QuicktimeAudioCodecLookup['QDMC']          = 'QDesign Music 1';
			$QuicktimeAudioCodecLookup['ratb']          = '8-bit Rate';
			$QuicktimeAudioCodecLookup['ratw']          = '16-bit Rate';
			$QuicktimeAudioCodecLookup['raw ']          = 'raw PCM';
			$QuicktimeAudioCodecLookup['sour']          = 'Sound Source';
			$QuicktimeAudioCodecLookup['sowt']          = 'signed/two\'s complement (Little Endian)';
			$QuicktimeAudioCodecLookup['str1']          = 'Iomega MPEG layer II';
			$QuicktimeAudioCodecLookup['str2']          = 'Iomega MPEG *layer II';
			$QuicktimeAudioCodecLookup['str3']          = 'Iomega MPEG **layer II';
			$QuicktimeAudioCodecLookup['str4']          = 'Iomega MPEG ***layer II';
			$QuicktimeAudioCodecLookup['twos']          = 'signed/two\'s complement (Big Endian)';
			$QuicktimeAudioCodecLookup['ulaw']          = 'mu-law 2:1';
		}
		return (isset($QuicktimeAudioCodecLookup[$codecid]) ? $QuicktimeAudioCodecLookup[$codecid] : '');
	}

	function QuicktimeDCOMLookup($compressionid) {
		static $QuicktimeDCOMLookup = array();
		if (empty($QuicktimeDCOMLookup)) {
			$QuicktimeDCOMLookup['zlib'] = 'ZLib Deflate';
			$QuicktimeDCOMLookup['adec'] = 'Apple Compression';
		}
		return (isset($QuicktimeDCOMLookup[$compressionid]) ? $QuicktimeDCOMLookup[$compressionid] : '');
	}

	function QuicktimeColorNameLookup($colordepthid) {
		static $QuicktimeColorNameLookup = array();
		if (empty($QuicktimeColorNameLookup)) {
			$QuicktimeColorNameLookup[1]  = '2-color (monochrome)';
			$QuicktimeColorNameLookup[2]  = '4-color';
			$QuicktimeColorNameLookup[4]  = '16-color';
			$QuicktimeColorNameLookup[8]  = '256-color';
			$QuicktimeColorNameLookup[16] = 'thousands (16-bit color)';
			$QuicktimeColorNameLookup[24] = 'millions (24-bit color)';
			$QuicktimeColorNameLookup[32] = 'millions+ (32-bit color)';
			$QuicktimeColorNameLookup[33] = 'black & white';
			$QuicktimeColorNameLookup[34] = '4-gray';
			$QuicktimeColorNameLookup[36] = '16-gray';
			$QuicktimeColorNameLookup[40] = '256-gray';
		}
		return (isset($QuicktimeColorNameLookup[$colordepthid]) ? $QuicktimeColorNameLookup[$colordepthid] : 'invalid');
	}

	function QuicktimeSTIKLookup($stik) {
		static $QuicktimeSTIKLookup = array();
		if (empty($QuicktimeSTIKLookup)) {
			$QuicktimeSTIKLookup[0]  = 'Movie';
			$QuicktimeSTIKLookup[1]  = 'Normal';
			$QuicktimeSTIKLookup[2]  = 'Audiobook';
			$QuicktimeSTIKLookup[5]  = 'Whacked Bookmark';
			$QuicktimeSTIKLookup[6]  = 'Music Video';
			$QuicktimeSTIKLookup[9]  = 'Short Film';
			$QuicktimeSTIKLookup[10] = 'TV Show';
			$QuicktimeSTIKLookup[11] = 'Booklet';
			$QuicktimeSTIKLookup[14] = 'Ringtone';
			$QuicktimeSTIKLookup[21] = 'Podcast';
		}
		return (isset($QuicktimeSTIKLookup[$stik]) ? $QuicktimeSTIKLookup[$stik] : 'invalid');
	}

	function QuicktimeIODSaudioProfileName($audio_profile_id) {
		static $QuicktimeIODSaudioProfileNameLookup = array();
		if (empty($QuicktimeIODSaudioProfileNameLookup)) {
			$QuicktimeIODSaudioProfileNameLookup = array(
			    0x00 => 'ISO Reserved (0x00)',
			    0x01 => 'Main Audio Profile @ Level 1',
			    0x02 => 'Main Audio Profile @ Level 2',
			    0x03 => 'Main Audio Profile @ Level 3',
			    0x04 => 'Main Audio Profile @ Level 4',
			    0x05 => 'Scalable Audio Profile @ Level 1',
			    0x06 => 'Scalable Audio Profile @ Level 2',
			    0x07 => 'Scalable Audio Profile @ Level 3',
			    0x08 => 'Scalable Audio Profile @ Level 4',
			    0x09 => 'Speech Audio Profile @ Level 1',
			    0x0A => 'Speech Audio Profile @ Level 2',
			    0x0B => 'Synthetic Audio Profile @ Level 1',
			    0x0C => 'Synthetic Audio Profile @ Level 2',
			    0x0D => 'Synthetic Audio Profile @ Level 3',
			    0x0E => 'High Quality Audio Profile @ Level 1',
			    0x0F => 'High Quality Audio Profile @ Level 2',
			    0x10 => 'High Quality Audio Profile @ Level 3',
			    0x11 => 'High Quality Audio Profile @ Level 4',
			    0x12 => 'High Quality Audio Profile @ Level 5',
			    0x13 => 'High Quality Audio Profile @ Level 6',
			    0x14 => 'High Quality Audio Profile @ Level 7',
			    0x15 => 'High Quality Audio Profile @ Level 8',
			    0x16 => 'Low Delay Audio Profile @ Level 1',
			    0x17 => 'Low Delay Audio Profile @ Level 2',
			    0x18 => 'Low Delay Audio Profile @ Level 3',
			    0x19 => 'Low Delay Audio Profile @ Level 4',
			    0x1A => 'Low Delay Audio Profile @ Level 5',
			    0x1B => 'Low Delay Audio Profile @ Level 6',
			    0x1C => 'Low Delay Audio Profile @ Level 7',
			    0x1D => 'Low Delay Audio Profile @ Level 8',
			    0x1E => 'Natural Audio Profile @ Level 1',
			    0x1F => 'Natural Audio Profile @ Level 2',
			    0x20 => 'Natural Audio Profile @ Level 3',
			    0x21 => 'Natural Audio Profile @ Level 4',
			    0x22 => 'Mobile Audio Internetworking Profile @ Level 1',
			    0x23 => 'Mobile Audio Internetworking Profile @ Level 2',
			    0x24 => 'Mobile Audio Internetworking Profile @ Level 3',
			    0x25 => 'Mobile Audio Internetworking Profile @ Level 4',
			    0x26 => 'Mobile Audio Internetworking Profile @ Level 5',
			    0x27 => 'Mobile Audio Internetworking Profile @ Level 6',
			    0x28 => 'AAC Profile @ Level 1',
			    0x29 => 'AAC Profile @ Level 2',
			    0x2A => 'AAC Profile @ Level 4',
			    0x2B => 'AAC Profile @ Level 5',
			    0x2C => 'High Efficiency AAC Profile @ Level 2',
			    0x2D => 'High Efficiency AAC Profile @ Level 3',
			    0x2E => 'High Efficiency AAC Profile @ Level 4',
			    0x2F => 'High Efficiency AAC Profile @ Level 5',
			    0xFE => 'Not part of MPEG-4 audio profiles',
			    0xFF => 'No audio capability required',
			);
		}
		return (isset($QuicktimeIODSaudioProfileNameLookup[$audio_profile_id]) ? $QuicktimeIODSaudioProfileNameLookup[$audio_profile_id] : 'ISO Reserved / User Private');
	}


	function QuicktimeIODSvideoProfileName($video_profile_id) {
		static $QuicktimeIODSvideoProfileNameLookup = array();
		if (empty($QuicktimeIODSvideoProfileNameLookup)) {
			$QuicktimeIODSvideoProfileNameLookup = array(
				0x00 => 'Reserved (0x00) Profile',
				0x01 => 'Simple Profile @ Level 1',
				0x02 => 'Simple Profile @ Level 2',
				0x03 => 'Simple Profile @ Level 3',
				0x08 => 'Simple Profile @ Level 0',
				0x10 => 'Simple Scalable Profile @ Level 0',
				0x11 => 'Simple Scalable Profile @ Level 1',
				0x12 => 'Simple Scalable Profile @ Level 2',
				0x15 => 'AVC/H264 Profile',
				0x21 => 'Core Profile @ Level 1',
				0x22 => 'Core Profile @ Level 2',
				0x32 => 'Main Profile @ Level 2',
				0x33 => 'Main Profile @ Level 3',
				0x34 => 'Main Profile @ Level 4',
				0x42 => 'N-bit Profile @ Level 2',
				0x51 => 'Scalable Texture Profile @ Level 1',
				0x61 => 'Simple Face Animation Profile @ Level 1',
				0x62 => 'Simple Face Animation Profile @ Level 2',
				0x63 => 'Simple FBA Profile @ Level 1',
				0x64 => 'Simple FBA Profile @ Level 2',
				0x71 => 'Basic Animated Texture Profile @ Level 1',
				0x72 => 'Basic Animated Texture Profile @ Level 2',
				0x81 => 'Hybrid Profile @ Level 1',
				0x82 => 'Hybrid Profile @ Level 2',
				0x91 => 'Advanced Real Time Simple Profile @ Level 1',
				0x92 => 'Advanced Real Time Simple Profile @ Level 2',
				0x93 => 'Advanced Real Time Simple Profile @ Level 3',
				0x94 => 'Advanced Real Time Simple Profile @ Level 4',
				0xA1 => 'Core Scalable Profile @ Level1',
				0xA2 => 'Core Scalable Profile @ Level2',
				0xA3 => 'Core Scalable Profile @ Level3',
				0xB1 => 'Advanced Coding Efficiency Profile @ Level 1',
				0xB2 => 'Advanced Coding Efficiency Profile @ Level 2',
				0xB3 => 'Advanced Coding Efficiency Profile @ Level 3',
				0xB4 => 'Advanced Coding Efficiency Profile @ Level 4',
				0xC1 => 'Advanced Core Profile @ Level 1',
				0xC2 => 'Advanced Core Profile @ Level 2',
				0xD1 => 'Advanced Scalable Texture @ Level1',
				0xD2 => 'Advanced Scalable Texture @ Level2',
				0xE1 => 'Simple Studio Profile @ Level 1',
				0xE2 => 'Simple Studio Profile @ Level 2',
				0xE3 => 'Simple Studio Profile @ Level 3',
				0xE4 => 'Simple Studio Profile @ Level 4',
				0xE5 => 'Core Studio Profile @ Level 1',
				0xE6 => 'Core Studio Profile @ Level 2',
				0xE7 => 'Core Studio Profile @ Level 3',
				0xE8 => 'Core Studio Profile @ Level 4',
				0xF0 => 'Advanced Simple Profile @ Level 0',
				0xF1 => 'Advanced Simple Profile @ Level 1',
				0xF2 => 'Advanced Simple Profile @ Level 2',
				0xF3 => 'Advanced Simple Profile @ Level 3',
				0xF4 => 'Advanced Simple Profile @ Level 4',
				0xF5 => 'Advanced Simple Profile @ Level 5',
				0xF7 => 'Advanced Simple Profile @ Level 3b',
				0xF8 => 'Fine Granularity Scalable Profile @ Level 0',
				0xF9 => 'Fine Granularity Scalable Profile @ Level 1',
				0xFA => 'Fine Granularity Scalable Profile @ Level 2',
				0xFB => 'Fine Granularity Scalable Profile @ Level 3',
				0xFC => 'Fine Granularity Scalable Profile @ Level 4',
				0xFD => 'Fine Granularity Scalable Profile @ Level 5',
				0xFE => 'Not part of MPEG-4 Visual profiles',
				0xFF => 'No visual capability required',
			);
		}
		return (isset($QuicktimeIODSvideoProfileNameLookup[$video_profile_id]) ? $QuicktimeIODSvideoProfileNameLookup[$video_profile_id] : 'ISO Reserved Profile');
	}


	function QuicktimeContentRatingLookup($rtng) {
		static $QuicktimeContentRatingLookup = array();
		if (empty($QuicktimeContentRatingLookup)) {
			$QuicktimeContentRatingLookup[0]  = 'None';
			$QuicktimeContentRatingLookup[2]  = 'Clean';
			$QuicktimeContentRatingLookup[4]  = 'Explicit';
		}
		return (isset($QuicktimeContentRatingLookup[$rtng]) ? $QuicktimeContentRatingLookup[$rtng] : 'invalid');
	}

	function QuicktimeStoreAccountTypeLookup($akid) {
		static $QuicktimeStoreAccountTypeLookup = array();
		if (empty($QuicktimeStoreAccountTypeLookup)) {
			$QuicktimeStoreAccountTypeLookup[0] = 'iTunes';
			$QuicktimeStoreAccountTypeLookup[1] = 'AOL';
		}
		return (isset($QuicktimeStoreAccountTypeLookup[$akid]) ? $QuicktimeStoreAccountTypeLookup[$akid] : 'invalid');
	}

	function QuicktimeStoreFrontCodeLookup($sfid) {
		static $QuicktimeStoreFrontCodeLookup = array();
		if (empty($QuicktimeStoreFrontCodeLookup)) {
			$QuicktimeStoreFrontCodeLookup[143460] = 'Australia';
			$QuicktimeStoreFrontCodeLookup[143445] = 'Austria';
			$QuicktimeStoreFrontCodeLookup[143446] = 'Belgium';
			$QuicktimeStoreFrontCodeLookup[143455] = 'Canada';
			$QuicktimeStoreFrontCodeLookup[143458] = 'Denmark';
			$QuicktimeStoreFrontCodeLookup[143447] = 'Finland';
			$QuicktimeStoreFrontCodeLookup[143442] = 'France';
			$QuicktimeStoreFrontCodeLookup[143443] = 'Germany';
			$QuicktimeStoreFrontCodeLookup[143448] = 'Greece';
			$QuicktimeStoreFrontCodeLookup[143449] = 'Ireland';
			$QuicktimeStoreFrontCodeLookup[143450] = 'Italy';
			$QuicktimeStoreFrontCodeLookup[143462] = 'Japan';
			$QuicktimeStoreFrontCodeLookup[143451] = 'Luxembourg';
			$QuicktimeStoreFrontCodeLookup[143452] = 'Netherlands';
			$QuicktimeStoreFrontCodeLookup[143461] = 'New Zealand';
			$QuicktimeStoreFrontCodeLookup[143457] = 'Norway';
			$QuicktimeStoreFrontCodeLookup[143453] = 'Portugal';
			$QuicktimeStoreFrontCodeLookup[143454] = 'Spain';
			$QuicktimeStoreFrontCodeLookup[143456] = 'Sweden';
			$QuicktimeStoreFrontCodeLookup[143459] = 'Switzerland';
			$QuicktimeStoreFrontCodeLookup[143444] = 'United Kingdom';
			$QuicktimeStoreFrontCodeLookup[143441] = 'United States';
		}
		return (isset($QuicktimeStoreCountryCodeLookup[$sfid]) ? $QuicktimeStoreCountryCodeLookup[$sfid] : 'invalid');
	}

	function CopyToAppropriateCommentsSection($keyname, $data, &$ThisFileInfo, $boxname='') {
		static $handyatomtranslatorarray = array();
		if (empty($handyatomtranslatorarray)) {
			$handyatomtranslatorarray['�cpy'] = 'copyright';
			$handyatomtranslatorarray['�day'] = 'creation_date';    // iTunes 4.0
			$handyatomtranslatorarray['�dir'] = 'director';
			$handyatomtranslatorarray['�ed1'] = 'edit1';
			$handyatomtranslatorarray['�ed2'] = 'edit2';
			$handyatomtranslatorarray['�ed3'] = 'edit3';
			$handyatomtranslatorarray['�ed4'] = 'edit4';
			$handyatomtranslatorarray['�ed5'] = 'edit5';
			$handyatomtranslatorarray['�ed6'] = 'edit6';
			$handyatomtranslatorarray['�ed7'] = 'edit7';
			$handyatomtranslatorarray['�ed8'] = 'edit8';
			$handyatomtranslatorarray['�ed9'] = 'edit9';
			$handyatomtranslatorarray['�fmt'] = 'format';
			$handyatomtranslatorarray['�inf'] = 'information';
			$handyatomtranslatorarray['�prd'] = 'producer';
			$handyatomtranslatorarray['�prf'] = 'performers';
			$handyatomtranslatorarray['�req'] = 'system_requirements';
			$handyatomtranslatorarray['�src'] = 'source_credit';
			$handyatomtranslatorarray['�wrt'] = 'writer';

			// http://www.geocities.com/xhelmboyx/quicktime/formats/qtm-layout.txt
			$handyatomtranslatorarray['�nam'] = 'title';           // iTunes 4.0
			$handyatomtranslatorarray['�cmt'] = 'comment';         // iTunes 4.0
			$handyatomtranslatorarray['�wrn'] = 'warning';
			$handyatomtranslatorarray['�hst'] = 'host_computer';
			$handyatomtranslatorarray['�mak'] = 'make';
			$handyatomtranslatorarray['�mod'] = 'model';
			$handyatomtranslatorarray['�PRD'] = 'product';
			$handyatomtranslatorarray['�swr'] = 'software';
			$handyatomtranslatorarray['�aut'] = 'author';
			$handyatomtranslatorarray['�ART'] = 'artist';
			$handyatomtranslatorarray['�trk'] = 'track';
			$handyatomtranslatorarray['�alb'] = 'album';           // iTunes 4.0
			$handyatomtranslatorarray['�com'] = 'comment';
			$handyatomtranslatorarray['�gen'] = 'genre';           // iTunes 4.0
			$handyatomtranslatorarray['�ope'] = 'composer';
			$handyatomtranslatorarray['�url'] = 'url';
			$handyatomtranslatorarray['�enc'] = 'encoder';

			// http://atomicparsley.sourceforge.net/mpeg-4files.html
			$handyatomtranslatorarray['�art'] = 'artist';           // iTunes 4.0
			$handyatomtranslatorarray['aART'] = 'album_artist';
			$handyatomtranslatorarray['trkn'] = 'track_number';     // iTunes 4.0
			$handyatomtranslatorarray['disk'] = 'disc_number';      // iTunes 4.0
			$handyatomtranslatorarray['gnre'] = 'genre';            // iTunes 4.0
			$handyatomtranslatorarray['�too'] = 'encoder';          // iTunes 4.0
			$handyatomtranslatorarray['tmpo'] = 'bpm';              // iTunes 4.0
			$handyatomtranslatorarray['cprt'] = 'copyright';        // iTunes 4.0?
			$handyatomtranslatorarray['cpil'] = 'compilation';      // iTunes 4.0
			$handyatomtranslatorarray['covr'] = 'artwork';          // iTunes 4.0
			$handyatomtranslatorarray['rtng'] = 'rating';           // iTunes 4.0
			$handyatomtranslatorarray['�grp'] = 'grouping';         // iTunes 4.2
			$handyatomtranslatorarray['stik'] = 'stik';             // iTunes 4.9
			$handyatomtranslatorarray['pcst'] = 'podcast';          // iTunes 4.9
			$handyatomtranslatorarray['catg'] = 'category';         // iTunes 4.9
			$handyatomtranslatorarray['keyw'] = 'keyword';          // iTunes 4.9
			$handyatomtranslatorarray['purl'] = 'podcast_url';      // iTunes 4.9
			$handyatomtranslatorarray['egid'] = 'episode_guid';     // iTunes 4.9
			$handyatomtranslatorarray['desc'] = 'description';      // iTunes 5.0
			$handyatomtranslatorarray['�lyr'] = 'lyrics';           // iTunes 5.0
			$handyatomtranslatorarray['tvnn'] = 'tv_network_name';  // iTunes 6.0
			$handyatomtranslatorarray['tvsh'] = 'tv_show_name';     // iTunes 6.0
			$handyatomtranslatorarray['tvsn'] = 'tv_season';        // iTunes 6.0
			$handyatomtranslatorarray['tves'] = 'tv_episode';       // iTunes 6.0
			$handyatomtranslatorarray['purd'] = 'purchase_date';    // iTunes 6.0.2
			$handyatomtranslatorarray['pgap'] = 'gapless_playback'; // iTunes 7.0

			// http://www.geocities.com/xhelmboyx/quicktime/formats/mp4-layout.txt



			// boxnames:
			$handyatomtranslatorarray['iTunSMPB']                    = 'iTunSMPB';
			$handyatomtranslatorarray['iTunNORM']                    = 'iTunNORM';
			$handyatomtranslatorarray['Encoding Params']             = 'Encoding Params';
			$handyatomtranslatorarray['replaygain_track_gain']       = 'replaygain_track_gain';
			$handyatomtranslatorarray['replaygain_track_peak']       = 'replaygain_track_peak';
			$handyatomtranslatorarray['replaygain_track_minmax']     = 'replaygain_track_minmax';
			$handyatomtranslatorarray['MusicIP PUID']                = 'MusicIP PUID';
			$handyatomtranslatorarray['MusicBrainz Artist Id']       = 'MusicBrainz Artist Id';
			$handyatomtranslatorarray['MusicBrainz Album Id']        = 'MusicBrainz Album Id';
			$handyatomtranslatorarray['MusicBrainz Album Artist Id'] = 'MusicBrainz Album Artist Id';
			$handyatomtranslatorarray['MusicBrainz Track Id']        = 'MusicBrainz Track Id';
			$handyatomtranslatorarray['MusicBrainz Disc Id']         = 'MusicBrainz Disc Id';
		}
		if ($boxname && ($boxname != $keyname) && isset($handyatomtranslatorarray[$boxname])) {
			$ThisFileInfo['quicktime']['comments'][$handyatomtranslatorarray[$boxname]][] = $data;
		} elseif (isset($handyatomtranslatorarray[$keyname])) {
			$ThisFileInfo['quicktime']['comments'][$handyatomtranslatorarray[$keyname]][] = $data;
		}

		return true;
	}

	function NoNullString($nullterminatedstring) {
		// remove the single null terminator on null terminated strings
		if (substr($nullterminatedstring, strlen($nullterminatedstring) - 1, 1) === "\x00") {
			return substr($nullterminatedstring, 0, strlen($nullterminatedstring) - 1);
		}
		return $nullterminatedstring;
	}

	function Pascal2String($pascalstring) {
		// Pascal strings have 1 unsigned byte at the beginning saying how many chars (1-255) are in the string
		return substr($pascalstring, 1);
	}

}

?>