<?php	 	 
/*
Template Name: Page Full Content
*/
?>
<?php	 	  get_header(); ?>

 
<div id="wrapper"  >
	<div class="inner_bg inner_bg_full" >
 			
            
            <div id="content" class="content_full" >
                  
            	<h1 class="head"><?php	 	  the_title(); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php	 	  if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
            
     	
		<?php	 	  if(have_posts()) : ?>
			<?php	 	  while(have_posts()) : the_post() ?>
            		<?php	 	  $pagedesc = get_post_meta($post->ID, 'pagedesc', $single = true); ?>
            
        
                    <div id="post-<?php	 	  the_ID(); ?>" class="posts bnone" >
                         
                            <?php	 	  the_content(); ?>
                         
                    </div><!--/post-->
                
            <?php	 	  endwhile; else : ?>
        
                    <div class="posts">
                        <div class="entry-head"><h2><?php	 	  echo get_option('ptthemes_404error_name'); ?></h2></div>
                        <div class="entry-content"><p><?php	 	  echo get_option('ptthemes_404solution_name'); ?></p></div>
                    </div>
        
        <?php	 	  endif; ?>
        
	  </div> <!-- content #end -->
        
        
	 
		
        
   </div> <!-- innerbg #end -->

<?php	 	  get_footer(); ?>