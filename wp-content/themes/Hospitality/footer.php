    <div id="footer">
         	<div class="fleft">
            <p> &copy; <?php	 	  the_time('Y'); ?> <?php	 	  bloginfo(); ?>  All right reserved.</p>
            
             <?php	 	  if ( get_option('ptthemes_footerpages') <> "" ) { ?>
			<ul>
			<?php	 	  wp_list_pages('title_li=&depth=0&include=' . get_option('ptthemes_footerpages') . '&sort_column=menu_order'); ?>
			</ul>
		<?php	 	  } ?>
            
           </div>
            
         
        
        
        <p class="fr"> <span class="copyright ">Website Design by</span> <span class="templatic">   <a href="http://onewebcentric.com" title="onewebcentric.com">onewebcentric.com</a>  </span>  </p>
        
     </div><!-- footer #end -->

 <?php	 	  wp_footer(); ?><?php	 	  if ( get_option('ptthemes_google_analytics') <> "" ) { echo stripslashes(get_option('ptthemes_google_analytics')); } ?>

</body>

</html>
		