<?php	 	 
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
/////////////////////////////////////////////////////////////////
// See readme.txt for more details                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.graphic.jpg.php                                      //
// module for analyzing JPEG Image files                       //
// dependencies: PHP compiled with --enable-exif (optional)    //
//               module.tag.xmp.php (optional)                 //
//                                                            ///
/////////////////////////////////////////////////////////////////


class getid3_jpg
{


	function getid3_jpg(&$fd, &$ThisFileInfo) {
		$ThisFileInfo['fileformat']                  = 'jpg';
		$ThisFileInfo['video']['dataformat']         = 'jpg';
		$ThisFileInfo['video']['lossless']           = false;
		$ThisFileInfo['video']['bits_per_sample']    = 24;
		$ThisFileInfo['video']['pixel_aspect_ratio'] = (float) 1;

		fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

		$imageinfo = array();
		list($width, $height, $type) = getid3_lib::GetDataImageSize(fread($fd, $ThisFileInfo['filesize']), $imageinfo);


		if (isset($imageinfo['APP13'])) {
			// http://php.net/iptcparse
			// http://www.sno.phy.queensu.ca/~phil/exiftool/TagNames/IPTC.html
			$iptc_parsed = iptcparse($imageinfo['APP13']);
			if (is_array($iptc_parsed)) {
				foreach ($iptc_parsed as $iptc_key_raw => $iptc_values) {
					list($iptc_record, $iptc_tagkey) = explode('#', $iptc_key_raw);
					$iptc_tagkey = intval(ltrim($iptc_tagkey, '0'));
					foreach ($iptc_values as $key => $value) {
						$IPTCrecordName = $this->IPTCrecordName($iptc_record);
						$IPTCrecordTagName = $this->IPTCrecordTagName($iptc_record, $iptc_tagkey);
						if (isset($ThisFileInfo['iptc'][$IPTCrecordName][$IPTCrecordTagName])) {
							$ThisFileInfo['iptc'][$IPTCrecordName][$IPTCrecordTagName][] = $value;
						} else {
							$ThisFileInfo['iptc'][$IPTCrecordName][$IPTCrecordTagName] = array($value);
						}
					}
				}
			}
		}

		$returnOK = false;
		switch ($type) {
			case IMG_JPG:
				$ThisFileInfo['video']['resolution_x'] = $width;
				$ThisFileInfo['video']['resolution_y'] = $height;

				if (isset($imageinfo['APP1'])) {
					if (function_exists('exif_read_data')) {
						if (substr($imageinfo['APP1'], 0, 4) == 'Exif') {
							ob_start();
							$ThisFileInfo['jpg']['exif'] = exif_read_data($ThisFileInfo['filenamepath'], '', true, false);
							$errors = ob_get_contents();
							if ($errors) {
								$ThisFileInfo['warning'][] = strip_tags($errors);
								//unset($ThisFileInfo['jpg']['exif']);
							}
							ob_end_clean();
						} else {
							$ThisFileInfo['warning'][] = 'exif_read_data() cannot parse non-EXIF data in APP1 (expected "Exif", found "'.substr($imageinfo['APP1'], 0, 4).'")';
						}
					} else {
						$ThisFileInfo['warning'][] = 'EXIF parsing only available when '.(GETID3_OS_ISWINDOWS ? 'php_exif.dll enabled' : 'compiled with --enable-exif');
					}
				}
				$returnOK = true;
				break;

			default:
				break;
		}


		$cast_as_appropriate_keys = array('EXIF', 'IFD0', 'THUMBNAIL');
		foreach ($cast_as_appropriate_keys as $exif_key) {
			if (isset($ThisFileInfo['jpg']['exif'][$exif_key])) {
				foreach ($ThisFileInfo['jpg']['exif'][$exif_key] as $key => $value) {
					$ThisFileInfo['jpg']['exif'][$exif_key][$key] = $this->CastAsAppropriate($value);
				}
			}
		}


		if (isset($ThisFileInfo['jpg']['exif']['GPS'])) {

			if (isset($ThisFileInfo['jpg']['exif']['GPS']['GPSVersion'])) {
				for ($i = 0; $i < 4; $i++) {
					$version_subparts[$i] = ord(substr($ThisFileInfo['jpg']['exif']['GPS']['GPSVersion'], $i, 1));
				}
				$ThisFileInfo['jpg']['exif']['GPS']['computed']['version'] = 'v'.implode('.', $version_subparts);
			}

			if (isset($ThisFileInfo['jpg']['exif']['GPS']['GPSDateStamp'])) {
				$explodedGPSDateStamp = explode(':', $ThisFileInfo['jpg']['exif']['GPS']['GPSDateStamp']);
				$computed_time[5] = (isset($explodedGPSDateStamp[0]) ? $explodedGPSDateStamp[0] : '');
				$computed_time[3] = (isset($explodedGPSDateStamp[1]) ? $explodedGPSDateStamp[1] : '');
				$computed_time[4] = (isset($explodedGPSDateStamp[2]) ? $explodedGPSDateStamp[2] : '');

				if (function_exists('date_default_timezone_set')) {
					date_default_timezone_set('UTC');
				} else {
					ini_set('date.timezone', 'UTC');
				}

				$computed_time = array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0);
				if (isset($ThisFileInfo['jpg']['exif']['GPS']['GPSTimeStamp']) && is_array($ThisFileInfo['jpg']['exif']['GPS']['GPSTimeStamp'])) {
					foreach ($ThisFileInfo['jpg']['exif']['GPS']['GPSTimeStamp'] as $key => $value) {
						$computed_time[$key] = getid3_lib::DecimalizeFraction($value);
					}
				}
				$ThisFileInfo['jpg']['exif']['GPS']['computed']['timestamp'] = mktime($computed_time[0], $computed_time[1], $computed_time[2], $computed_time[3], $computed_time[4], $computed_time[5]);
			}

			if (isset($ThisFileInfo['jpg']['exif']['GPS']['GPSLatitude']) && is_array($ThisFileInfo['jpg']['exif']['GPS']['GPSLatitude'])) {
				$direction_multiplier = ((isset($ThisFileInfo['jpg']['exif']['GPS']['GPSLatitudeRef']) && ($ThisFileInfo['jpg']['exif']['GPS']['GPSLatitudeRef'] == 'S')) ? -1 : 1);
				foreach ($ThisFileInfo['jpg']['exif']['GPS']['GPSLatitude'] as $key => $value) {
					$computed_latitude[$key] = getid3_lib::DecimalizeFraction($value);
				}
				$ThisFileInfo['jpg']['exif']['GPS']['computed']['latitude'] = $direction_multiplier * ($computed_latitude[0] + ($computed_latitude[1] / 60) + ($computed_latitude[2] / 3600));
			}

			if (isset($ThisFileInfo['jpg']['exif']['GPS']['GPSLongitude']) && is_array($ThisFileInfo['jpg']['exif']['GPS']['GPSLongitude'])) {
				$direction_multiplier = ((isset($ThisFileInfo['jpg']['exif']['GPS']['GPSLongitudeRef']) && ($ThisFileInfo['jpg']['exif']['GPS']['GPSLongitudeRef'] == 'W')) ? -1 : 1);
				foreach ($ThisFileInfo['jpg']['exif']['GPS']['GPSLongitude'] as $key => $value) {
					$computed_longitude[$key] = getid3_lib::DecimalizeFraction($value);
				}
				$ThisFileInfo['jpg']['exif']['GPS']['computed']['longitude'] = $direction_multiplier * ($computed_longitude[0] + ($computed_longitude[1] / 60) + ($computed_longitude[2] / 3600));
			}

			if (isset($ThisFileInfo['jpg']['exif']['GPS']['GPSAltitude'])) {
				$direction_multiplier = ((isset($ThisFileInfo['jpg']['exif']['GPS']['GPSAltitudeRef']) && ($ThisFileInfo['jpg']['exif']['GPS']['GPSAltitudeRef'] === chr(1))) ? -1 : 1);
				$ThisFileInfo['jpg']['exif']['GPS']['computed']['altitude'] = $direction_multiplier * getid3_lib::DecimalizeFraction($ThisFileInfo['jpg']['exif']['GPS']['GPSAltitude']);
			}

		}


		if (getid3_lib::IncludeDependency(GETID3_INCLUDEPATH.'module.tag.xmp.php', __FILE__, false)) {
			if (isset($ThisFileInfo['filenamepath'])) {
				$image_xmp = new Image_XMP($ThisFileInfo['filenamepath']);
				$xmp_raw = $image_xmp->getAllTags();
				foreach ($xmp_raw as $key => $value) {
					list($subsection, $tagname) = explode(':', $key);
					$ThisFileInfo['xmp'][$subsection][$tagname] = $this->CastAsAppropriate($value);
				}
			}
		}

		if (!$returnOK) {
			unset($ThisFileInfo['fileformat']);
			return false;
		}
		return true;
	}


	function CastAsAppropriate($value) {
		if (is_array($value)) {
			return $value;
		} elseif (preg_match('#^[0-9]+/[0-9]+$#', $value)) {
			return getid3_lib::DecimalizeFraction($value);
		} elseif (preg_match('#^[0-9]+$#', $value)) {
			return getid3_lib::CastAsInt($value);
		} elseif (preg_match('#^[0-9\.]+$#', $value)) {
			return (float) $value;
		}
		return $value;
	}


	function IPTCrecordName($iptc_record) {
		// http://www.sno.phy.queensu.ca/~phil/exiftool/TagNames/IPTC.html
		static $IPTCrecordName = array();
		if (empty($IPTCrecordName)) {
			$IPTCrecordName = array(
				1 => 'IPTCEnvelope',
				2 => 'IPTCApplication',
				3 => 'IPTCNewsPhoto',
				7 => 'IPTCPreObjectData',
				8 => 'IPTCObjectData',
				9 => 'IPTCPostObjectData',
			);
		}
		return (isset($IPTCrecordName[$iptc_record]) ? $IPTCrecordName[$iptc_record] : '');
	}


	function IPTCrecordTagName($iptc_record, $iptc_tagkey) {
		// http://www.sno.phy.queensu.ca/~phil/exiftool/TagNames/IPTC.html
		static $IPTCrecordTagName = array();
		if (empty($IPTCrecordTagName)) {
			$IPTCrecordTagName = array(
				1 => array( // IPTC EnvelopeRecord Tags
					0   => 'EnvelopeRecordVersion',
					5   => 'Destination',
					20  => 'FileFormat',
					22  => 'FileVersion',
					30  => 'ServiceIdentifier',
					40  => 'EnvelopeNumber',
					50  => 'ProductID',
					60  => 'EnvelopePriority',
					70  => 'DateSent',
					80  => 'TimeSent',
					90  => 'CodedCharacterSet',
					100 => 'UniqueObjectName',
					120 => 'ARMIdentifier',
					122 => 'ARMVersion',
				),
				2 => array( // IPTC ApplicationRecord Tags
					0   => 'ApplicationRecordVersion',
					3   => 'ObjectTypeReference',
					4   => 'ObjectAttributeReference',
					5   => 'ObjectName',
					7   => 'EditStatus',
					8   => 'EditorialUpdate',
					10  => 'Urgency',
					12  => 'SubjectReference',
					15  => 'Category',
					20  => 'SupplementalCategories',
					22  => 'FixtureIdentifier',
					25  => 'Keywords',
					26  => 'ContentLocationCode',
					27  => 'ContentLocationName',
					30  => 'ReleaseDate',
					35  => 'ReleaseTime',
					37  => 'ExpirationDate',
					38  => 'ExpirationTime',
					40  => 'SpecialInstructions',
					42  => 'ActionAdvised',
					45  => 'ReferenceService',
					47  => 'ReferenceDate',
					50  => 'ReferenceNumber',
					55  => 'DateCreated',
					60  => 'TimeCreated',
					62  => 'DigitalCreationDate',
					63  => 'DigitalCreationTime',
					65  => 'OriginatingProgram',
					70  => 'ProgramVersion',
					75  => 'ObjectCycle',
					80  => 'By-line',
					85  => 'By-lineTitle',
					90  => 'City',
					92  => 'Sub-location',
					95  => 'Province-State',
					100 => 'Country-PrimaryLocationCode',
					101 => 'Country-PrimaryLocationName',
					103 => 'OriginalTransmissionReference',
					105 => 'Headline',
					110 => 'Credit',
					115 => 'Source',
					116 => 'CopyrightNotice',
					118 => 'Contact',
					120 => 'Caption-Abstract',
					121 => 'LocalCaption',
					122 => 'Writer-Editor',
					125 => 'RasterizedCaption',
					130 => 'ImageType',
					131 => 'ImageOrientation',
					135 => 'LanguageIdentifier',
					150 => 'AudioType',
					151 => 'AudioSamplingRate',
					152 => 'AudioSamplingResolution',
					153 => 'AudioDuration',
					154 => 'AudioOutcue',
					184 => 'JobID',
					185 => 'MasterDocumentID',
					186 => 'ShortDocumentID',
					187 => 'UniqueDocumentID',
					188 => 'OwnerID',
					200 => 'ObjectPreviewFileFormat',
					201 => 'ObjectPreviewFileVersion',
					202 => 'ObjectPreviewData',
					221 => 'Prefs',
					225 => 'ClassifyState',
					228 => 'SimilarityIndex',
					230 => 'DocumentNotes',
					231 => 'DocumentHistory',
					232 => 'ExifCameraInfo',
				),
				3 => array( // IPTC NewsPhoto Tags
					0   => 'NewsPhotoVersion',
					10  => 'IPTCPictureNumber',
					20  => 'IPTCImageWidth',
					30  => 'IPTCImageHeight',
					40  => 'IPTCPixelWidth',
					50  => 'IPTCPixelHeight',
					55  => 'SupplementalType',
					60  => 'ColorRepresentation',
					64  => 'InterchangeColorSpace',
					65  => 'ColorSequence',
					66  => 'ICC_Profile',
					70  => 'ColorCalibrationMatrix',
					80  => 'LookupTable',
					84  => 'NumIndexEntries',
					85  => 'ColorPalette',
					86  => 'IPTCBitsPerSample',
					90  => 'SampleStructure',
					100 => 'ScanningDirection',
					102 => 'IPTCImageRotation',
					110 => 'DataCompressionMethod',
					120 => 'QuantizationMethod',
					125 => 'EndPoints',
					130 => 'ExcursionTolerance',
					135 => 'BitsPerComponent',
					140 => 'MaximumDensityRange',
					145 => 'GammaCompensatedValue',
				),
				7 => array( // IPTC PreObjectData Tags
					10  => 'SizeMode',
					20  => 'MaxSubfileSize',
					90  => 'ObjectSizeAnnounced',
					95  => 'MaximumObjectSize',
				),
				8 => array( // IPTC ObjectData Tags
					10  => 'SubFile',
				),
				9 => array( // IPTC PostObjectData Tags
					10  => 'ConfirmedObjectSize',
				),
			);

		}
		return (isset($IPTCrecordTagName[$iptc_record][$iptc_tagkey]) ? $IPTCrecordTagName[$iptc_record][$iptc_tagkey] : $iptc_tagkey);
	}

}


?>