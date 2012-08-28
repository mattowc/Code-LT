<?php	 	  get_header(); ?>
	
<div id="wrapper"  >
	<div class="inner_bg" >
 			
            
            <div id="content" >
            
            	<h1 class="head"><?php	 	  the_title(); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php	 	  if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
         

	  

			<?php	 	  if(have_posts()) : ?>
 			<?php	 	  while(have_posts()) : the_post() ?>
        
                <div id="post-<?php	 	  the_ID(); ?>" class="posts">
				    						                        
                  
                     
                    <?php	 	  if ( get_post_meta($post->ID,'image', true) ) { ?>
        <div class="post_img clearfix"> <img src="<?php	 	  echo bloginfo('template_url'); ?>/thumb.php?src=<?php	 	  echo get_post_meta($post->ID, "image", $single = true); ?>&amp;w=645&amp;zc=1&amp;q=80<?php	 	  echo $thumb_url;?>" alt="<?php	 	  the_title(); ?>"  class="img"   /></div>
        <?php	 	  } ?>
                
                              	
                        							
                   
											
					<?php	 	  the_content(); ?>
					 
					<p class="post_bottom">Category : <?php	 	  the_category(" &amp;"); ?></p>
											
                </div><!--/post-->

				<div id="comments"><?php	 	  comments_template(); ?></div>
        
            <?php	 	  endwhile; ?>
			
			<div class="pagination">
			
                <?php	 	  if (function_exists('wp_pagenavi')) { ?><?php	 	  wp_pagenavi(); ?><?php	 	  } ?>
						
            </div>
			
             <?php	 	  endif; ?>
			
 
	   </div> <!-- content #end -->
        
        
		<?php	 	  get_sidebar(); ?>
		
        
   </div> <!-- innerbg #end -->

<?php	 	  get_footer(); ?>
