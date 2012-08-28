<?php	 	 
/*
Template Name: Landing Page
*/
?>
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
<?php	 	  if ( get_option('ptthemes_favicon') <> "" ) { ?>
<link rel="shortcut icon" type="image/png" href="<?php	 	  echo get_option('ptthemes_favicon'); ?>" />
<?php	 	  } ?>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php	 	  if ( get_option('ptthemes_feedburner_url') <> "" ) { echo get_option('ptthemes_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php	 	  bloginfo('pingback_url'); ?>" />

<script src="<?php	 	  bloginfo('template_directory'); ?>/library/js/jquery.js" type=text/javascript></script>

<?php	 	  if ( get_option('ptthemes_scripts_header') <> "" ) { echo stripslashes(get_option('ptthemes_scripts_header')); } ?> 
<?php	 	  wp_head(); ?>

<?php	 	  if ( get_option('ptthemes_customcss') ) { ?>
<link href="<?php	 	  bloginfo('template_directory'); ?>/custom.css" rel="stylesheet" type="text/css">
<?php	 	  } ?>

<link rel="stylesheet" type="text/css" href="<?php	 	  bloginfo('template_directory'); ?>/landing.css" media="screen" />

 </head>

<body class="body">
 
<div id="page_landing">        
        <?php	 	  if(have_posts()) : ?>
			<?php	 	  while(have_posts()) : the_post() ?>
            		<?php	 	  $pagedesc = get_post_meta($post->ID, 'pagedesc', $single = true); ?>
            
        
                    <div id="post-<?php	 	  the_ID(); ?>" class="posts bnone" >
                         
                         	<h1> <?php	 	  the_title(); ?> </h1>
                            <?php	 	  the_content(); ?>
                         
                    </div><!--/post-->
                
            <?php	 	  endwhile; else : ?>
    <?php	 	  endif; ?>
        		
             
   </div> <!-- #end -->
</body>