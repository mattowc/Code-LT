<?php	 	  get_header(); ?>


<div id="wrapper"  >
	<div class="inner_bg" >
 			
            
            <div id="content" >
                  
            	<h1 class="head">404 Error Page </h1>
                <div class="breadcrumb clearfix">
                	<?php	 	  if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',''); } ?>
                </div>
 
       		   
	    
 	
		<div class="pagespot">

			<div class="post archive-spot">
				    						                        
                <h2><?php	 	  echo get_option('ptthemes_404error_name'); ?></h2>
				
				<div class="cat-spot"><p><?php	 	  echo get_option('ptthemes_404solution_name'); ?></p></div>

                <div class="fix"></div>
						
            </div><!--/post-->  

		</div><!--/pagespot -->
		
 	   </div> <!-- content #end -->
        
        
		<?php	 	  get_sidebar(); ?>
		
        
   </div> <!-- innerbg #end -->

<?php	 	  get_footer(); ?>
