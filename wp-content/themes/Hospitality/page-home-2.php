<?php	 	 
/*
Template Name: Home Page No Slider
*/
?>
<?php	 	 
if($_REQUEST['page']=='thumb')
{
	$_REQUEST['w'] = $_REQUEST['width'];
	include(TEMPLATEPATH . '/thumb.php');
	exit;
}
?>
<?php get_header(); ?>


<link rel="stylesheet" href="<?php	 	  bloginfo('template_directory'); ?>/library/css/slider.css" type="text/css" media="screen">
<script type="text/javascript" src="<?php	 	  bloginfo('template_url'); ?>/library/js/jquery-1.3.2.min.js"></script>
<script src="<?php	 	  bloginfo('template_directory'); ?>/library/js/cufon-yui.js" type="text/javascript"></script>
<script type="text/javascript">
Cufon.replace('h2', { fontFamily:'Museo Slab' });
Cufon.replace('h3', { fontFamily:'Museo Slab' });

$(document).ready(function() {
	$('#download-form input:radio').change(function(){
		var url = $('#download-form input:radio:checked').val();
		$('#download-btn').attr('href', url);
	});

	$('a#download-jump').click(function(){
		$(window).scrollTo($('a[name="download"]'), 6000);
	});
});
</script>

<?php if( have_posts() ): the_post(); endif; ?>

    <div id="slider_banner">
     	<div id="sidebr_banner_in">
         	
            <div  id="slider" class="jon_video_page">
                <div class="jon_half">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
                <div class="jon_end_half">
<iframe src="http://player.vimeo.com/video/24204787?title=0&amp;byline=0&amp;portrait=0&amp;color=ea7202" width="510" height="383" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>                </div>
	        </div> <!-- slider #end -->
            
        </div> <!-- slider #inner -->
    </div> <!-- slider banner #end -->
     
     
     
     <div id="wrapper">
     
     
 				<?php	 	  if (function_exists('dynamic_sidebar') && dynamic_sidebar(1) )  ?>
	
    
    	<div id="index_sidebar">
        
        		
                <?php	 	  if (function_exists('dynamic_sidebar') && dynamic_sidebar(2) )  ?>
        	
              
            
        </div> <!-- index sidebar #end -->
        
        
        <div id="index_content">
        	 
             <div class="content_sepretor">
             		
                     <?php	 	  if (function_exists('dynamic_sidebar') && dynamic_sidebar(3) )  ?>
                    
                    <?php	 	  if (function_exists('dynamic_sidebar') && dynamic_sidebar(4) )  ?>
                    
                    
             </div> 
             
             
             
             <?php	 	  if (function_exists('dynamic_sidebar') && dynamic_sidebar(5) )  ?>
             
             
             
             
        </div> <!-- index content #end -->
        
    
 
	</div> <!-- wrapper #end -->	
 
<?php	 	  get_footer(); ?>    
      