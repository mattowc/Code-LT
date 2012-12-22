<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<title>
<?php	 	  if ( is_home() ) { ?><?php	 	  bloginfo('description'); ?>&nbsp;|&nbsp;<?php	 	  bloginfo('name'); ?><?php	 	  } ?>
<?php	 	  if ( is_search() ) { ?>Search Results&nbsp;|&nbsp;<?php	 	  bloginfo('name'); ?><?php	 	  } ?>
<?php	 	  if ( is_author() ) { ?>Author Archives&nbsp;|&nbsp;<?php	 	  bloginfo('name'); ?><?php	 	  } ?>
<?php	 	  if ( is_single() ) { ?><?php	 	  wp_title(''); ?><?php	 	  } ?>
<?php	 	  if ( is_page() ) { ?><?php	 	  wp_title(''); ?><?php	 	  } ?>
<?php	 	  if ( is_category() ) { ?><?php	 	  single_cat_title(); ?>&nbsp;|&nbsp;<?php	 	  bloginfo('name'); ?><?php	 	  } ?>
<?php	 	  if ( is_month() ) { ?><?php	 	  the_time('F'); ?>&nbsp;|&nbsp;<?php	 	  bloginfo('name'); ?><?php	 	  } ?>
<?php	 	  if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php	 	  bloginfo('name'); ?>&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;<?php	 	  single_tag_title("", true); } } ?>
</title>

<meta http-equiv="Content-Type" content="<?php	 	  bloginfo('html_type'); ?>; charset=<?php	 	  bloginfo('charset'); ?>" />
<?php	 	  if (is_home()) { ?>
<?php	 	  if ( get_option('ptthemes_meta_description') <> "" ) { ?>
<meta name="description" content="<?php	 	  echo stripslashes(get_option('ptthemes_meta_description')); ?>" />
<?php	 	  } ?>
<?php	 	  if ( get_option('ptthemes_meta_keywords') <> "" ) { ?>
<meta name="keywords" content="<?php	 	  echo stripslashes(get_option('ptthemes_meta_keywords')); ?>" />
<?php	 	  } ?>
<?php	 	  if ( get_option('ptthemes_meta_author') <> "" ) { ?>
<meta name="author" content="<?php	 	  echo stripslashes(get_option('ptthemes_meta_author')); ?>" />
<?php	 	  } ?>
<?php	 	  } ?>
<link rel="stylesheet" type="text/css" href="<?php	 	  bloginfo('stylesheet_url'); ?>" media="screen" />

<?php	 	  if ( get_option('ptthemes_favicon') <> "" ) { ?>
<link rel="shortcut icon" type="image/png" href="<?php	 	  echo get_option('ptthemes_favicon'); ?>" />
<?php	 	  } ?>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php	 	  if ( get_option('ptthemes_feedburner_url') <> "" ) { echo get_option('ptthemes_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php	 	  bloginfo('pingback_url'); ?>" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet" type="text/css" />
<!--[if lt IE 7]>
<script type="text/javascript" src="<?php	 	  bloginfo('template_directory'); ?>/library/js/pngfix.js"></script>
<![endif]-->
<script src="<?php	 	  bloginfo('template_directory'); ?>/library/js/jquery.js" type=text/javascript></script>

<?php	 	  if ( get_option('ptthemes_scripts_header') <> "" ) { echo stripslashes(get_option('ptthemes_scripts_header')); } ?>
<script type="text/javascript" src="<?php	 	  bloginfo('template_directory'); ?>/library/js/menu.js"></script>
<link type='text/css' href='<?php	 	  bloginfo('template_directory'); ?>/library/css/dropdownmenu.css' rel='stylesheet' media='screen' />
<?php	 	 
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
?>
<?php	 	  wp_head(); ?>

<?php	 	  if ( get_option('ptthemes_customcss') ) { ?>
<link href="<?php	 	  bloginfo('template_directory'); ?>/custom.css" rel="stylesheet" type="text/css">
<?php	 	  } ?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.js"></script>
<script type="text/javascript" src="//learningtechnicsutah.com/special/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-content/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/css" media="screen" />

<script>
jQuery(document).ready(function($) {

	/* This is basic - uses default settings */
	
	$("a#single_image").fancybox();
	
	/* Using custom settings */
	
	$("a#inline").fancybox({
		'hideOnContentClick': true
	});

	/* Apply fancybox to multiple items */
	
	$("a.group").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
	
	$(".various").fancybox({
		'transitionIn'	: 'none',
		'transitionOut'	: 'none',
		'type' : 'iframe'
	});
	
});
</script>
<link rel="stylesheet" href="<?php	 	  bloginfo('url'); ?>/wp-content/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

</head>

<body <?php	 	  body_class(); ?>>


		<div id="header">
        	
            
             <?php	 	  if ( get_option('ptthemes_hotel_phone') != "") { ?>
 					<div class="call_now"><?php	 	  echo stripslashes(get_option('ptthemes_hotel_phone'));  ?></div>
        <?php	 	  } ?>
            
             
            
            
            <div class="logo">
            
            	<?php	 	  if ( get_option('ptthemes_show_blog_title') ) { ?>
                
				   <?php	 	  if ( get_option('ptthemes_logo_url') ) { ?>
                      <a href="<?php	 	  echo get_option('home'); ?>/"><img src="<?php	 	  echo get_option('ptthemes_logo_url'); ?>" alt="<?php	 	  bloginfo('name'); ?>" class="photo"  /></a>
                    <?php	 	  } else { ?>  <?php	 	  } ?>
                 
                   <div class="blog-title"><a href="<?php	 	  echo get_option('home'); ?>/"><?php	 	  bloginfo('name'); ?></a> </div>
                <p class="blog-description">
                  <?php	 	  bloginfo('description'); ?>
                </p>
                
                <?php	 	  } else { ?>
                <a href="<?php	 	  echo get_option('home'); ?>/"><img src="<?php	 	  if ( get_option('ptthemes_logo_url') <> "" ) { echo get_option('ptthemes_logo_url'); } else { echo get_bloginfo('template_directory').'/images/logo.png'; } ?>" alt="<?php	 	  bloginfo('name'); ?>"   /></a>
                
                 <p class="blog-description">
                  <?php	 	  bloginfo('description'); ?>
                </p>
                 
                <?php	 	  } ?>
            	 
            </div>
            
            
            <?php	 	  if ( get_option('ptthemes_hotel_address') != "") { ?>
 					<div class="address"><?php	 	  echo stripslashes(get_option('ptthemes_hotel_address'));  ?>
 					</div>
        <?php	 	  } ?>
            
            
        
        </div> <!-- header #end -->
		
        
        <div id="nav">
		 <?php	 	  if (function_exists('dynamic_sidebar') && dynamic_sidebar('Header Navigation') ){}else{  ?>
 		<ul > 
        		
                <li class="hometab <?php	 	  if ( is_home() && $_REQUEST['page']=='' ) { ?> current_page_item <?php	 	  } ?>"><a href="<?php	 	  echo get_option('home'); ?>/"><?php	 	  _e(Home); ?></a></li>
        		
          	  <?php	 	  wp_list_pages('title_li=&depth=0&exclude=' . get_inc_pages("pag_exclude_") .'&sort_column=menu_order'); ?>
            
            <?php	 	 
 		global $wpdb;
 		$blogcatname = get_option('ptthemes_blogcategory');
 		$catid = $wpdb->get_var("SELECT term_ID FROM $wpdb->terms WHERE name = '$blogcatname'");
   		 ?>
             <?php	 	  if ( get_option('ptthemes_blogcategory') <> "" && $catid ) { ?>
             <li <?php	 	  if ( is_category() || is_search() || is_single() || is_tag() || is_search() || is_archive() ) { ?> class="current_page_item" <?php	 	  } ?>><a href="<?php	 	  echo get_option('home');?>/?cat=<?php	 	  echo $catid; ?>" title="<?php	 	  echo $blogcatname; ?>"><?php	 	  echo $blogcatname; ?></a></li>
            <?php	 	  } ?>
              
		</ul> 
        <?php	 	  }?>
		</div>