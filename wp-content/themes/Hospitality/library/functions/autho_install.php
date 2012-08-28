<?php	 	 
	//theme.php
define('THEME_DUMMY_DELETE_MESSAGE','<div class="updated fade">All Dummy data has been removed from your database successfully!</div>');
define('THEME_ACTIVE_MESSAGE','<style>* html #adminmenu { float:left; margin:0; position:absolute; z-index:0; left:85px; } .wrap { widht:600px; } * html #wpbody-content { width:80% !important; } * html #footer { position:absolute; z-index:0; bottom:0; left:0; display:none; } 
.message { padding:10px; line-height:150%; border:4px solid #e74c00; background:#FFFFC6; position:absolute; z-index:0; left:180px; top:340px; _top:310px; width:75%;  }  
#current-theme { marign:1em 0 8.5em 0 !important; padding-bottom:180px !important; }  </style><div class="message" id="message2"  ><p style="line-height:160% !important; font:bold 14px arial;"><strong>Theme Activated. We also completely installed the theme and added dummy content and categories by default.  So you can start using it right away.  </strong></p>
<p> wish to delete the dummy data that we populated in your site? <a href="'.get_option('siteurl').'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a><p></div>');


	if(strstr($_SERVER['REQUEST_URI'],'themes.php')) 
	{
		if($_REQUEST['dummy']=='del')
		{
			delete_dummy_data();	
			echo THEME_DUMMY_DELETE_MESSAGE;
		}
		$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where meta_key='pt_dummy_content' and meta_value=1");
		if(($_REQUEST['template']=='' && $post_counts>0 && $_REQUEST['page']=='') || $_REQUEST['activated']=='true')
		{
			echo THEME_ACTIVE_MESSAGE;
		}
		if($_REQUEST['activated'])
		{
			require_once (TEMPLATEPATH . '/auto_install.php');
		}
	}
	
	function delete_dummy_data()
	{
		global $wpdb;
		$productArray = array();
		$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where meta_key='pt_dummy_content' and meta_value=1";
		$pids_info = $wpdb->get_results($pids_sql);
		foreach($pids_info as $pids_info_obj)
		{
			wp_delete_post($pids_info_obj->ID);
		}
		
	}
	
?>