<?php	 	  get_header(); ?>

    <?php	 	  if (is_paged()) $is_paged = true; ?>
    
<div id="wrapper">
	<div class="inner_bg">
 			
             <div id="content" >
    
             	   <?php	 	  if (is_search()) { ?>
                    <h1 class="head"><?php	 	  echo get_option('ptthemes_browsing_search'); ?> <?php	 	  printf(__('%s'), $s) ?> </h1>
                    <?php	 	  } ?>
                <div class="breadcrumb clearfix">
                	<?php	 	  if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
    
  
			<?php	 	  if(have_posts()) : ?>
					
			<?php	 	  while(have_posts()) : the_post() ?>
        
                <div id="post-<?php	 	  the_ID(); ?>" class="posts">
				    						                        
                    <h2 class="title"><a href="<?php	 	  the_permalink() ?>" rel="bookmark" title="<?php	 	  the_title_attribute(); ?>"><?php	 	  the_title(); ?></a></h2>
				    
					<p class="post_top">
					
					    <?php	 	  if ( get_option('ptthemes_relative_date') ) { ?>
						
					        <?php	 	  relativeDate(get_the_time('YmdHis')) ?>
						
					    <?php	 	  } else { ?>
						
					    <?php	 	  the_time('F jS', '', ''); ?>, <?php	 	  the_time('Y'); ?>  //  <?php	 	  the_time('g:i a'); ?>
						
					    <?php	 	  } ?>
						
						<strong>@ <?php	 	  the_author_posts_link(); ?></strong>
						
						<?php	 	  if ( get_option( 'ptthemes_commentcount' )) { ?> 
					
					        // <?php	 	  comments_popup_link(''.get_option('ptthemes_comment_responsesa_name').'', ''.get_option('ptthemes_comment_responsesb_name').'', ''.get_option('ptthemes_comment_responsesc_name').''); ?>
						
					    <?php	 	  } ?>
					
					</p>
					
					<?php	 	  if (( get_post_meta($post->ID,'image', true) ) && (get_option( 'ptthemes_timthumb_all' )) ) { ?>
                
                        <a title="Link to <?php	 	  the_title(); ?>" href="<?php	 	  the_permalink() ?>"><img src="<?php	 	  echo bloginfo('template_url'); ?>/thumb.php?src=<?php	 	  echo get_post_meta($post->ID, "image", $single = true); ?>&amp;h=95&amp;w=95&amp;zc=1&amp;q=80<?php	 	  echo $thumb_url;?>" alt="<?php	 	  the_title(); ?>" class="fll" style="margin-right:10px; margin-bottom:10px" /></a>          	
                        							
                    <?php	 	  } ?>
						
					<?php	 	  if ( get_option( 'ptthemes_postcontent_full' )) { ?> 
					
					    <?php	 	  the_content(); ?>
					
					<?php	 	  } else { ?>
					
					    <?php	 	  the_excerpt(); ?>
						
					<?php	 	  } ?>
					
					
					<p class="post_bottom">Category : <?php	 	  the_category(" &amp;"); ?></p>
											
                </div><!--/post-->                            
        
            <?php	 	  endwhile; ?>
			
			<?php	 	  else: ?>
			
			    <div class="posts">
					
                    <h2><?php	 	  echo get_option('ptthemes_search_nothing_found'); ?></h2>
						
                </div> 
        
            <?php	 	  endif; ?>
			
			<div class="pagination">
			
                <?php	 	  if (function_exists('wp_pagenavi')) { ?><?php	 	  wp_pagenavi(); ?><?php	 	  } ?>
						
            </div>
            
            
           
			
	  </div> <!-- content #end -->
        
        
        
        
		<?php	 	  get_sidebar(); ?>
		
        
   </div> <!--innerbg #end -->

<?php	 	  get_footer(); ?>