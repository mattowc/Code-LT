<?php	 	 

$options[] = array(	"type" => "maintabletop");

    /// General Settings
	
	    $options[] = array(	"name" => "General Settings",
						"type" => "heading");
						
		    $options[] = array(	"name" => "Theme Skin",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"desc" => "Please select the CSS skin of your blog here.",
					                "id" => $shortname."_alt_stylesheet",
					                "std" => "Select a CSS skin:",
					                "type" => "select",
					                "options" => $alt_stylesheets);
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Customize Your Design",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Use Custom Stylesheet",
						            "desc" => "If you want to make custom design changes using CSS enable and <a href='". $customcssurl . "'>edit custom.css file here</a>.",
						            "id" => $shortname."_customcss",
						            "std" => "false",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Favicon",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"desc" => "Paste the full URL for your favicon image here if you wish to show it in browsers. <a href='http://www.favicon.cc/'>Create one here</a>",
						            "id" => $shortname."_favicon",
						            "std" => "",
						            "type" => "text");	
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Header Your Logo Image Set",
						        "toggle" => "true",
								"type" => "subheadingtop");

                $options[] = array(	"name" => "Choose Your Photo Image",
				                    "desc" => "Paste the full URL to your logo image here.",
						            "id" => $shortname."_logo_url",
						            "std" => "",
						            "type" => "file");

				$options[] = array(	"name" => "Choose Blog Title over Logo",
				                    "desc" => "This option will overwrite your logo selection above - You can <a href='". $generaloptionsurl . "'>change your settings here</a>",
						            "label" => "Show Blog Title + Tagline.",
						            "id" => $shortname."_show_blog_title",
						            "std" => "true",
						            "type" => "checkbox");	

			$options[] = array(	"type" => "subheadingbottom");
			
			
			$options[] = array(	"name" => "Comments Appearance",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Display Comments Count",
						            "desc" => "Show comments count in Front/Archive",
						            "id" => $shortname."_commentcount",
						            "std" => "false",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
			$options[] = array(	"name" => "Syndication / Feed",
						        "toggle" => "true",
								"type" => "subheadingtop");			
						
			$options[] = array( "desc" => "If you are using a service like Feedburner to manage your RSS feed, enter full URL to your feed into box above. If you'd prefer to use the default WordPress feed, simply leave this box blank.",
			    		            "id" => $shortname."_feedburner_url",
			    		            "std" => "",
			    		            "type" => "text");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
			

			
	$options[] = array(	"name" => "Header Your Phone Number & Address Setting ",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Your Phone Number (ex.call now 99 99 999)",
					                "id" => $shortname."_hotel_phone",
					                "std" => "",
					                "type" => "textarea");
				
				$options[] = array(	"desc" => "Your Address ",
					                "id" => $shortname."_hotel_address",
					                "std" => "",
					                "type" => "textarea");
				
				
 				$options[] = array(	"type" => "subheadingbottom");
								
 $options[] = array(	"name" => "Image Setting (Tim thumb setting - Image Cutting Edge)",
						        "toggle" => "true",
								"type" => "subheadingtop");	

$options[] = array(	"name" => __("Default Image Cutting Edge"),
					                "desc" => __("Set Default Image Cutting Edge Position."),
					                "id" => $shortname."_image_x_cut",
					                "std" => "",
									"options" => array('center','top','bottom','left','right','top right','top left','bottom right','bottom left'),
					                "type" => "select");
				$options[] = array(	"type" => "subheadingbottom");
			 
			 					
		$options[] = array(	"type" => "maintablebreak");
		
		
    /// Navigation Settings												
				
		$options[] = array(	"name" => "Navigation Settings",
						    "type" => "heading");
										
				$options[] = array(	"name" => "Exclude Pages from Header Menu",
								"toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"type" => "multihead");
						
				$options = pages_exclude($options);
									
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Breadcrumbs Navigation",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Show breadcrumbs navigation bar",
						            "desc" => "i.e. Home > Blog > Title - <a href='". $breadcrumbsurl . "'>Change options here</a>",
						            "id" => $shortname."_breadcrumbs",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
$options[] = array(	"name" => "Footer Navigation",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Show breadcrumbs navigation bar",
                	                "desc" => "Enter a comma-separated list of the <code>page ID's</code> that you'd like to display in footer (on the right). (ie. <code>1,2,3,4</code>)",
						            "id" => $shortname."_footerpages",
						            "std" => "",
						            "type" => "text");	
						
			$options[] = array(	"type" => "subheadingbottom");
						
		$options[] = array(	"type" => "maintablebreak");
		
		

				
       $options[] = array(	"name" => " Home Page Banner <br /> Advertisment  Slider Settings",
						    "type" => "heading");

			
	$options[] = array(	"name" => "Banner 1",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Banner 1 image url (ex.http://templatic.com/banner.jpg)",
					                "id" => $shortname."_banner1_url",
					                "std" => "",
					                "type" => "text");
				
				$options[] = array(	"name" => "Banner 1 link ",
					                "desc" => "Banner 1 link (ex.http://templatic.com/store)",
						            "id" => $shortname."_banner1_link",
						            "std" => "",
						            "type" => "text");
				
				$options[] = array(	"name" => "Banner 1 Caption text ",
					                "desc" => "Banner 1 Caption  text (ex. Take an Additional 20% off your Entire Order)",
						            "id" => $shortname."_banner1_caption",
						            "std" => "",
						            "type" => "text");
				
 				$options[] = array(	"type" => "subheadingbottom");
				
	$options[] = array(	"name" => "Banner 2",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Banner 2 image url (ex.http://templatic.com/banner.jpg)",
					                "id" => $shortname."_banner2_url",
					                "std" => "",
					                "type" => "text");
				
				$options[] = array(	"name" => "Banner 2 link ",
					                "desc" => "Banner 2 link (ex.http://templatic.com/store)",
						            "id" => $shortname."_banner2_link",
						            "std" => "",
						            "type" => "text");
				
				$options[] = array(	"name" => "Banner 2 Caption text ",
					                "desc" => "Banner 2 Caption  text (ex. Take an Additional 20% off your Entire Order)",
						            "id" => $shortname."_banner2_caption",
						            "std" => "",
						            "type" => "text");
				
 				$options[] = array(	"type" => "subheadingbottom");
				
				
	$options[] = array(	"name" => "Banner 3",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Banner 3 image url (ex.http://templatic.com/banner.jpg)",
					                "id" => $shortname."_banner3_url",
					                "std" => "",
					                "type" => "text");
				
				$options[] = array(	"name" => "Banner 3 link ",
					                "desc" => "Banner 3 link (ex.http://templatic.com/store)",
						            "id" => $shortname."_banner3_link",
						            "std" => "",
						            "type" => "text");
				
				$options[] = array(	"name" => "Banner 3 Caption text ",
					                "desc" => "Banner 3 Caption  text (ex. Take an Additional 20% off your Entire Order)",
						            "id" => $shortname."_banner3_caption",
						            "std" => "",
						            "type" => "text");
				
 				$options[] = array(	"type" => "subheadingbottom");
				
				
	$options[] = array(	"name" => "Banner 4",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Banner 4 image url (ex.http://templatic.com/banner.jpg)",
					                "id" => $shortname."_banner4_url",
					                "std" => "",
					                "type" => "text");
				
				$options[] = array(	"name" => "Banner 4 link ",
					                "desc" => "Banner 4 link (ex.http://templatic.com/store)",
						            "id" => $shortname."_banner4_link",
						            "std" => "",
						            "type" => "text");
				
				$options[] = array(	"name" => "Banner 4 Caption text ",
					                "desc" => "Banner 4 Caption  text (ex. Take an Additional 20% off your Entire Order)",
						            "id" => $shortname."_banner4_caption",
						            "std" => "",
						            "type" => "text");
				
 				$options[] = array(	"type" => "subheadingbottom");
				
	$options[] = array(	"name" => "Banner 5",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Banner 5 image url (ex.http://templatic.com/banner.jpg)",
					                "id" => $shortname."_banner5_url",
					                "std" => "",
					                "type" => "text");
				
				$options[] = array(	"name" => "Banner 5 link ",
					                "desc" => "Banner 5 link (ex.http://templatic.com/store)",
						            "id" => $shortname."_banner5_link",
						            "std" => "",
						            "type" => "text");
				
				$options[] = array(	"name" => "Banner 5 Caption text ",
					                "desc" => "Banner 5 Caption  text (ex. Take an Additional 20% off your Entire Order)",
						            "id" => $shortname."_banner5_caption",
						            "std" => "",
						            "type" => "text");
				
 				$options[] = array(	"type" => "subheadingbottom");		
			
			
			
		$options[] = array(	"type" => "maintablebreak");
		
 												
$options[] = array(	"type" => "maintablebottom");
				
$options[] = array(	"type" => "maintabletop");


	/// Blog Section Settings												
				
		$options[] = array(	"name" => "Blog Section Settings",
						    "type" => "heading");
			
		    $options[] = array(	"name" => "Pick Category for Your Blog Posts",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"name" => "Select a category for your blog posts",
			    		            "desc" => "Pick a category where your blog posts will be. It is advisable to create category and name it 'blog'. After that put all other blog categories as child categories of 'blog' so you don't need to change categories in posts.",
									"id" => $shortname."_blogcategory",
			    		            "type" => "select",
			    		            "options" => $pn_categories);
						
		    $options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"name" => "Content Display",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Display Full Post Content",
						            "desc" => "Instead of default Post excerpts display Full Post Content in Blog Section",
						            "id" => $shortname."_postcontent_full",
						            "std" => "false",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
 						
		$options[] = array(	"type" => "maintablebreak");
    
		
	/// Blog Stats and Scripts											
				
		$options[] = array(	"name" => "Blog Stats and Scripts",
						    "type" => "heading");
										
			$options[] = array(	"name" => "Blog Header Scripts",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Header Scripts",
					                "desc" => "If you need to add scripts to your header (like <a href='http://haveamint.com/'>Mint</a> tracking code), do so here.",
					                "id" => $shortname."_scripts_header",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Blog Footer Scripts",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Footer Scripts",
					                "desc" => "If you need to add scripts to your footer (like <a href='http://www.google.com/analytics/'>Google Analytics</a> tracking code), do so here.",
					                "id" => $shortname."_google_analytics",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
						
		$options[] = array(	"type" => "maintablebreak");
		

		
			


		
	/// SEO Options
				
		$options[] = array(	"name" => "SEO Options",
						    "type" => "heading");
						
			$options[] = array(	"name" => "Home Page <code>&lt;meta&gt;</code> tags",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"name" => "Meta Description",
					                "desc" => "You should use meta descriptions to provide search engines with additional information about topics that appear on your site. This only applies to your home page.",
					                "id" => $shortname."_meta_description",
					                "std" => "",
					                "type" => "textarea");

				$options[] = array(	"name" => "Meta Keywords (comma separated)",
					                "desc" => "Meta keywords are rarely used nowadays but you can still provide search engines with additional information about topics that appear on your site. This only applies to your home page.",
						            "id" => $shortname."_meta_keywords",
						            "std" => "",
						            "type" => "text");
									
				$options[] = array(	"name" => "Meta Author",
					                "desc" => "You should write your <em>full name</em> here but only do so if this blog is writen only by one outhor. This only applies to your home page.",
						            "id" => $shortname."_meta_author",
						            "std" => "",
						            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Add <code>&lt;noindex&gt;</code> tags",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to category archives.",
						            "id" => $shortname."_noindex_category",
						            "std" => "true",
						            "type" => "checkbox");
									
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to tag archives.",
						            "id" => $shortname."_noindex_tag",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to author archives.",
						            "id" => $shortname."_noindex_author",
						            "std" => "true",
						            "type" => "checkbox");
									
			    $options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to Search Results.",
						            "id" => $shortname."_noindex_search",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to daily archives.",
						            "id" => $shortname."_noindex_daily",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to monthly archives.",
						            "id" => $shortname."_noindex_monthly",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to yearly archives.",
						            "id" => $shortname."_noindex_yearly",
						            "std" => "true",
						            "type" => "checkbox");
				
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
		$options[] = array(	"type" => "maintablebreak");
		
		
	//////Translations		

	    $options[] = array(	"name" => "Translations",
						    "type" => "heading");
						
			$options[] = array(	"name" => "General Text",
			                    "toggle" => "true",
						        "type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Change Home link text - next to category menu in header",
			    		            "id" => $shortname."_home_name",
			    		            "std" => "Home",
			    		            "type" => "text");
						
				$options[] = array(	"desc" => "Change Search text",
			    		            "id" => $shortname."_search_name",
			    		            "std" => "Search",
			    		            "type" => "text");
									
				$options[] = array(	"desc" => "Change Nothing Found for Search text",
			    		            "id" => $shortname."_search_nothing_found",
			    		            "std" => "Nothing found, please search again.",
			    		            "type" => "text");
									
				$options[] = array(	"desc" => "Change Tags text",
			    		            "id" => $shortname."_general_tags_name",
			    		            "std" => "Tags",
			    		            "type" => "text");
				
			$options[] = array(	"type" => "subheadingbottom");
						
			$options[] = array(	"name" => "Archives Text",
			                    "toggle" => "true",
						        "type" => "subheadingtop");
				
				$options[] = array(	"desc" => "Change Browsing Category text",
			    		            "id" => $shortname."_browsing_category",
			    		            "std" => "Browsing Category",
			    		            "type" => "text");
				
				$options[] = array(	"desc" => "Change Browsing Tag text",
			    		            "id" => $shortname."_browsing_tag",
			    		            "std" => "Browsing Tag",
			    		            "type" => "text");
									
				$options[] = array(	"desc" => "Change Browsing Author text",
			    		            "id" => $shortname."_browsing_author",
			    		            "std" => "Browsing Posts of Author",
			    		            "type" => "text");
									
				$options[] = array(	"desc" => "Change Browsing Search text",
			    		            "id" => $shortname."_browsing_search",
			    		            "std" => "Browsing Posts filed under Search Term",
			    		            "type" => "text");
									
				$options[] = array(	"desc" => "Change Browsing Day text",
			    		            "id" => $shortname."_browsing_day",
			    		            "std" => "Browsing Day",
			    		            "type" => "text");
									
				$options[] = array(	"desc" => "Change Browsing Month text",
			    		            "id" => $shortname."_browsing_month",
			    		            "std" => "Browsing Month",
			    		            "type" => "text");
									
				$options[] = array(	"desc" => "Change Browsing Year text",
			    		            "id" => $shortname."_browsing_year",
			    		            "std" => "Browsing Year",
			    		            "type" => "text");
				
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "404 Error Text",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"desc" => "Change 404 error text",
			    		            "id" => $shortname."_404error_name",
			    		            "std" => "Error 404 | Nothing found!",
			    		            "type" => "text");
						
				$options[] = array(	"desc" => "Change 404 error solution text",
			    		            "id" => $shortname."_404solution_name",
			    		            "std" => "Sorry, but you are looking for something that is not here.",
			    		            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Comments Text",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"desc" => "Change password protected text",
			    		            "id" => $shortname."_password_protected_name",
			    		            "std" => "This post is password protected. Enter the password to view comments.",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change no responses text",
			    		            "id" => $shortname."_comment_responsesa_name",
			    		            "std" => "No Comments",
			    		            "type" => "text");
				
				$options[] = array( "desc" => "Change one response text",
			    		            "id" => $shortname."_comment_responsesb_name",
			    		            "std" => "One Comment",
			    		            "type" => "text");
				
				$options[] = array( "desc" => "Change multiple responses text, leave % intact!",
			    		            "id" => $shortname."_comment_responsesc_name",
			    		            "std" => "% Comments",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change trackbacks text",
			    		            "id" => $shortname."_comment_trackbacks_name",
			    		            "std" => "Trackbacks For This Post",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change comment moderation text",
			    		            "id" => $shortname."_comment_moderation_name",
			    		            "std" => "Your comment is awaiting moderation.",
			    	             	"type" => "text");
						
				$options[] = array( "desc" => "Change start conversation text",
			    		            "id" => $shortname."_comment_conversation_name",
			    		            "std" => "Be the first to start a conversation",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change closed comments text",
			    		            "id" => $shortname."_comment_closed_name",
			    		            "std" => "Comments are closed.",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change disabled comments text",
			    		            "id" => $shortname."_comment_off_name",
			    		            "std" => "Comments are off for this post",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change leave a reply text",
			    		            "id" => $shortname."_comment_reply_name",
			    		            "std" => "Leave a Reply",
			    		            "type" => "text");
				
				$options[] = array( "desc" => "Change 'you must be' text",
			    		            "id" => $shortname."_comment_mustbe_name",
			    		            "std" => "You must be",
			    		            "type" => "text");
				
				$options[] = array( "desc" => "Change 'logged in' text",
			    		            "id" => $shortname."_comment_loggedin_name",
			    		            "std" => "logged in",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change 'to post a comment' text",
			    		            "id" => $shortname."_comment_postcomment_name",
			    		            "std" => "to post a comment.",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change Logout text",
			    		            "id" => $shortname."_comment_logout_name",
			    		            "std" => "Logout",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change name text",
			    		            "id" => $shortname."_comment_name_name",
			    		            "std" => "Name",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change mail text",
			    		            "id" => $shortname."_comment_mail_name",
			    		            "std" => "Mail",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change website text",
			    		            "id" => $shortname."_comment_website_name",
			    		            "std" => "Website",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change add comment text",
			    		            "id" => $shortname."_comment_addcomment_name",
			    		            "std" => "Add Comment",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change 'reply' to threaded comment text",
			    		            "id" => $shortname."_comment_justreply_name",
			    		            "std" => "Reply",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change 'edit' comment text, only visible to administrators",
			    		            "id" => $shortname."_comment_edit_name",
			    	            	"std" => "Edit",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change 'delete' comment text, only visible to administrators",
			    		            "id" => $shortname."_comment_delete_name",
			    		            "std" => "Delete",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change 'spam' comment text, only visible to administrators",
			    		            "id" => $shortname."_comment_spam_name",
			    		            "std" => "Spam",
			    		            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Pagination Text",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"desc" => "Change first page text",
			    		            "id" => $shortname."_pagination_first_name",
			    	 	            "std" => "First",
			    		            "type" => "text");
						
				$options[] = array( "desc" => "Change last page text",
			    		            "id" => $shortname."_pagination_last_name",
			    		            "std" => "Last",
			    		            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Relative Dates Text",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"desc" => "Change Posted text",
			    		            "id" => $shortname."_relative_posted",
			    	 	            "std" => "Posted",
			    		            "type" => "text");
				
				$options[] = array(	"desc" => "Change Ago text",
			    		            "id" => $shortname."_relative_ago",
			    	 	            "std" => "ago",
			    		            "type" => "text");
				
				$options[] = array(	"desc" => "Change plural text&nbsp;  [ i.e. hour &rarr; hours ]",
			    		            "id" => $shortname."_relative_s",
			    	 	            "std" => "s",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change Year text",
			    		            "id" => $shortname."_relative_year",
			    		            "std" => "year",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change Month text",
			    		            "id" => $shortname."_relative_month",
			    		            "std" => "month",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change Week text",
			    		            "id" => $shortname."_relative_week",
			    		            "std" => "week",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change Day text",
			    		            "id" => $shortname."_relative_day",
			    		            "std" => "day",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change Hour text",
			    		            "id" => $shortname."_relative_hour",
			    		            "std" => "hour",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change Minute text",
			    		            "id" => $shortname."_relative_minute",
			    		            "std" => "minute",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change Second text",
			    		            "id" => $shortname."_relative_second",
			    		            "std" => "second",
			    		            "type" => "text");
									
				$options[] = array( "desc" => "Change Moments text",
			    		            "id" => $shortname."_relative_moments",
			    		            "std" => "moments",
			    		            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
						
		$options[] = array(	"type" => "maintablebreak");
						
$options[] = array(	"type" => "maintablebottom");

?>