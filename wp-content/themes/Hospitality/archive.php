<?php	 	  get_header(); ?>

<div id="wrapper">
	<div class="inner_bg">
 			
            
            <div id="content" >
              
			  <?php	 	  if (is_category()) { ?>
			<h1  class="head" ><?php	 	  echo single_cat_title(); ?> </h1>  

			<?php	 	  } elseif (is_day()) { ?>
			<h1  class="head"><?php	 	  the_time('F jS, Y'); ?> </h1>

			<?php	 	  } elseif (is_month()) { ?>
			<h1  class="head"> <?php	 	  the_time('F, Y'); ?> </h1>

			<?php	 	  } elseif (is_year()) { ?>
			<h1  class="head"> <?php	 	  the_time('Y'); ?> </h1>
			
			<?php	 	  } elseif (is_author()) { ?>
			<h1  class="head"><?php	 	  echo $curauth->nickname; ?> </h1>
							
			<?php	 	  } elseif (is_tag()) { ?>
			<h1  class="head"><?php	 	  echo single_tag_title('', true); ?> </h1>
			
			<?php	 	  } ?>
                <div class="breadcrumb clearfix">
                	<?php	 	  if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
             
            
            
               <?php	 	 
		
			if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
			else :
			$curauth = get_userdata(intval($author));
			endif;
			
		?>

    <?php	 	  if (is_paged()) $is_paged = true; ?>
	 <?php	 	  if(have_posts()) : ?>
					
			<?php	 	  while(have_posts()) : the_post() ?>
        
                <div id="post-<?php	 	  the_ID(); ?>" class="posts">
				    						                        
                    
					<div class="post_top">
                    <h2><a href="<?php	 	  the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php	 	  the_title_attribute(); ?>"><?php	 	  the_title(); ?></a></h2>
                            
                    <p class="postmetadata">Posted on <?php	 	  the_time('F j, Y') ?>  // 
                    <span class="commentcount"> <a href="<?php	 	  the_permalink(); ?>#commentarea"><?php	 	  comments_number('0 Comments', '1 Comments', '% Comments'); ?></a></span></p>
                    </div>
					
				 <?php	 	  if ( get_post_meta($post->ID,'image', true) ) { ?>
                  <img src="<?php	 	  echo get_option('siteurl'); ?>/?page=thumb&src=<?php	 	  echo get_post_meta($post->ID, "image", $single = true); ?>&amp;h=130&amp;width=130&amp;zc=1&amp;q=80<?php	 	  echo $thumb_url;?>" alt="<?php	 	  the_title(); ?>" class="imgleft"  />
                   <?php	 	  } ?>
						
					<?php	 	  if ( get_option( 'ptthemes_postcontent_full' )) { ?> 
					
					    <?php	 	  the_content(); ?>
					
					<?php	 	  } else { ?>
					
					    <?php	 	  the_excerpt(); ?>
						
					<?php	 	  } ?>
					
			 	
					<p class="post_bottom">Category : <?php	 	  the_category(" &amp;"); ?></p>
											
                </div><!--/post-->                            
        
            <?php	 	  endwhile; ?>
			
			<div class="pagination">
			
                <?php	 	  if (function_exists('wp_pagenavi')) { ?><?php	 	  wp_pagenavi(); ?><?php	 	  } ?>
						
            </div>
			
           
        
            <?php	 	  endif; ?>
			
		
       </div> <!-- content  #end -->
        
        
		 
        
        
		<?php	 	  get_sidebar(); ?>
		
        
   </div> <!-- wrapper #end -->

<?php	 	  get_footer(); ?>