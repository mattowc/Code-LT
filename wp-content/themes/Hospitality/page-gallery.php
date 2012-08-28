<?php	 	 
/*
Template Name: Gallery Listing Page
*/
?>
<?php	 	  get_header(); ?>

<div id="wrapper"  >
	<div class="inner_bg" >
 			
            
            <div id="content" >
                  
            	<h1 class="head"><?php	 	  the_title(); ?></h1>
                <div class="breadcrumb clearfix">
                	<?php	 	  if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
                

	<script type="text/javascript" src="<?php	 	  bloginfo('template_url'); ?>/library/js/fancybox/jquery.min.js"></script>       
		  <script type="text/javascript" src="<?php	 	  bloginfo('template_url'); ?>/library/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
            <link rel="stylesheet" type="text/css" href="<?php	 	  bloginfo('template_url'); ?>/library/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
            <script type="text/javascript">
                $(document).ready(function() {
         
                    $("a[rel=example_group]").fancybox({
                        'transitionIn'		: 'none',
                        'transitionOut'		: 'none',
                        'titlePosition' 	: 'over',
                        'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
                            return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                        }
                    });
        
                });
        </script>          
                
     	 
    
    <ul class="gallerylist">
    
    <?php	 	  if(have_posts()) : ?>
    <?php	 	  $post_images = bdw_get_images($post->ID,'large');
	$post_images_thumb = bdw_get_images($post->ID,'thumb');
	
	?>
			<?php	 	  while(have_posts()) : the_post() ?>
             
    
      <?php	 	 
                if(count($post_images)>1)
				{
					for($im=0;$im<count($post_images);$im++)
					{
					?>
                       <li> <a href="<?php	 	  echo $post_images[$im];?>" alt="<?php	 	  the_title(); ?>" rel="example_group" title="<?php	 	  the_title(); ?>">   
                       <img src="<?php	 	  echo $post_images_thumb[$im];?>" alt="<?php	 	  the_title(); ?>" height="169" width="185"  /> 
                       </a></li>
                     <?php	 	 	
					}
				}
				?>
                
                
                <?php	 	  endwhile; ?>
 <?php	 	  endif; ?>
    
    
    </ul>
   
        
	    </div> <!-- content #end -->
        
        
		<?php	 	  get_sidebar(); ?>
		
        
   </div> <!-- innerbg #end -->

<?php	 	  get_footer(); ?>