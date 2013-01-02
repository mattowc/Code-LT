    <div style="width:100%; display:block;">
    <div id="pre-footer">
        <h3>Call Us at 800-893-9315 or Schedule a Consultation by Filling the Form Below</h3>
        <?php echo do_shortcode('[contact-form-7 id="682" title="Footer Free Consultation"]'); ?>
    </div>
    </div>
    <div id="footer">
            <div class="fleft">
            <p> &copy; <?php          the_time('Y'); ?> <?php         bloginfo(); ?>  All right reserved.</p>
            
             <?php        if ( get_option('ptthemes_footerpages') <> "" ) { ?>
            <ul>
            <?php         wp_list_pages('title_li=&depth=0&include=' . get_option('ptthemes_footerpages') . '&sort_column=menu_order'); ?>
            </ul>
        <?php         } ?>
            
           </div>
            
          
        
        
        <p class="fr"> <span class="copyright ">Website Design by</span> <span class="templatic">   <a href="http://onewebcentric.com" title="onewebcentric.com">onewebcentric.com</a>  </span>  </p>
        
     </div><!-- footer #end -->

 <?php        wp_footer(); ?><?php        if ( get_option('ptthemes_google_analytics') <> "" ) { echo stripslashes(get_option('ptthemes_google_analytics')); } ?>

</body>

</html>
         