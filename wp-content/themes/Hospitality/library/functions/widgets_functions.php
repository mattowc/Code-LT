<?php	 	 

// Register widgetized areas
if ( function_exists('register_sidebar') ) {
    register_sidebars(1,array('name' => 'Front Page Reservation & Special Offers','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
    register_sidebars(1,array('name' => 'Home Page sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(3,array('name' => 'Home page Content Widget %d','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('name' => 'Inner Page Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	register_sidebars(1,array('name' => 'Header Navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
}
	
// Check for widgets in widget-ready areas http://wordpress.org/support/topic/190184?replies=7#post-808787
// Thanks to Chaos Kaizer http://blog.kaizeku.com/
function is_sidebar_active( $index = 1){
	$sidebars	= wp_get_sidebars_widgets();
	$key		= (string) 'sidebar-'.$index;
 
	return (isset($sidebars[$key]));
}



// =============================== 2 in 1 Widget ======================================
class reservationwidget extends WP_Widget {
	function reservationwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Reservation & Special Offers', 'description' => 'Reservation & Special Offers' );		
		$this->WP_Widget('widget_reservation', 'PT &rarr; Reservation & Special Offers', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$t1 = empty($instance['t1']) ? '' : apply_filters('widget_t1', $instance['t1']);
		$t2 = empty($instance['t2']) ? '' : apply_filters('widget_t2', $instance['t2']);
		$t3 = empty($instance['t3']) ? '' : apply_filters('widget_t3', $instance['t3']);
		$t4 = empty($instance['t4']) ? '' : apply_filters('widget_t4', $instance['t4']);
		$t5 = empty($instance['t5']) ? '' : apply_filters('widget_t5', $instance['t5']);
		$t6 = empty($instance['t6']) ? '' : apply_filters('widget_t6', $instance['t6']);
		 ?>						


		    <div class="reservation">
     	<div class="reservation_top">
        	<div class="reservation_bottom">
            	
                	<div class="reservation_section">
                    	<?php	 	  if ( $t1 <> "" ) { ?>	
                            <h3>  <?php	 	  echo $t1; ?> </h3>
                             <?php	 	  } ?> 
                        
                        		<?php	 	  if ( $t2 <> "" ) { ?>	
								<p>  <?php	 	  echo $t2; ?> </p>
                                 <?php	 	  } ?> 
                                  
                                  <?php	 	  if ( $t3 <> "" ) { ?>	
								<p class="more">  <a href="<?php	 	  echo $t3; ?>"> Read More </a> </p>
                                 <?php	 	  } ?>
                        
                         </div>   <!-- reservation #end -->
                    
                    
                    <div class="special_offers">
                    	<?php	 	  if ( $t4 <> "" ) { ?>	
                            <h3>  <?php	 	  echo $t4; ?> </h3>
                             <?php	 	  } ?> 
                        
                        		<?php	 	  if ( $t5 <> "" ) { ?>	
								<p>  <?php	 	  echo $t5; ?> </p>
                                 <?php	 	  } ?> 
                                  
                                  <?php	 	  if ( $t6 <> "" ) { ?>	
								<p class="more">  <a href="<?php	 	  echo $t6; ?>"> Read More </a> </p>
                                 <?php	 	  } ?>
                    </div>   <!-- reservation #end -->
                
            </div>
        </div>
     </div> <!-- reservation #end -->

  
            
            
	<?php	 	 
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['t1'] = ($new_instance['t1']);
		$instance['t2'] = ($new_instance['t2']);
		$instance['t3'] = ($new_instance['t3']);
		$instance['t4'] = ($new_instance['t4']);
		$instance['t5'] = ($new_instance['t5']);
		$instance['t6'] = ($new_instance['t6']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  't4' => '', 't5' => '','t6' => '' ) );		
		$title = strip_tags($instance['title']);
		$t1 = ($instance['t1']);
		$t2 = ($instance['t2']);
		$t3 = ($instance['t3']);
		$t4 = ($instance['t4']);		
		$t5 = ($instance['t5']);
		$t6 = ($instance['t6']);
?>
		<?php	 	  /*?><p><label for="<?php	 	  echo $this->get_field_id('title'); ?>">Widget Title: <input class="widefat" id="<?php	 	  echo $this->get_field_id('title'); ?>" name="<?php	 	  echo $this->get_field_name('title'); ?>" type="text" value="<?php	 	  echo attribute_escape($title); ?>" /></label></p><?php	 	  */?>
	 <p><label for="<?php	 	  echo $this->get_field_id('t1'); ?>">Reservation Title : <input class="widefat" id="<?php	 	  echo $this->get_field_id('t1'); ?>" name="<?php	 	  echo $this->get_field_name('t1'); ?>" type="text" value="<?php	 	  echo attribute_escape($t1); ?>" /></label></p>
     <p><label for="<?php	 	  echo $this->get_field_id('t2'); ?>">Reservation Description : <input class="widefat" id="<?php	 	  echo $this->get_field_id('t2'); ?>" name="<?php	 	  echo $this->get_field_name('t2'); ?>" type="text" value="<?php	 	  echo attribute_escape($t2); ?>" /></label></p>
        <p><label for="<?php	 	  echo $this->get_field_id('t3'); ?>">Reservation Main Link : <input class="widefat" id="<?php	 	  echo $this->get_field_id('t3'); ?>" name="<?php	 	  echo $this->get_field_name('t3'); ?>" type="text" value="<?php	 	  echo attribute_escape($t3); ?>" /></label></p>
        <p><label for="<?php	 	  echo $this->get_field_id('t4'); ?>">Specail Offers Title : <input class="widefat" id="<?php	 	  echo $this->get_field_id('t4'); ?>" name="<?php	 	  echo $this->get_field_name('t4'); ?>" type="text" value="<?php	 	  echo attribute_escape($t4); ?>" /></label></p>
        <p><label for="<?php	 	  echo $this->get_field_id('t5'); ?>">Specail Offers Description : <input class="widefat" id="<?php	 	  echo $this->get_field_id('t5'); ?>" name="<?php	 	  echo $this->get_field_name('t5'); ?>" type="text" value="<?php	 	  echo attribute_escape($t5); ?>" /></label></p>
        <p><label for="<?php	 	  echo $this->get_field_id('t6'); ?>">Specail Offers Link : <input class="widefat" id="<?php	 	  echo $this->get_field_id('t6'); ?>" name="<?php	 	  echo $this->get_field_name('t6'); ?>" type="text" value="<?php	 	  echo attribute_escape($t6); ?>" /></label></p>
<?php	 	 
	}}
register_widget('reservationwidget');


// =============================== Special Offer Widget ======================================
class specialoffer_widget extends WP_Widget {
	function specialoffer_widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Special offers', 'description' => 'Special offers' );		
		$this->WP_Widget('widgetspecialoffer_widget', 'PT &rarr; Special offers', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						

		<div class="widget">
      		<h3> <?php	 	  echo $title; ?> </h3>
       
       
        <?php	 	  if ( $desc1 <> "" ) { ?>	
         <?php	 	  echo $desc1; ?> 
         <?php	 	  } ?>
		
        </div> <!-- widget #end -->
            
            
	<?php	 	 
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['t1'] = ($new_instance['t1']);
		$instance['t2'] = ($new_instance['t2']);
		$instance['t3'] = ($new_instance['t3']);
		$instance['img1'] = ($new_instance['img1']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$t1 = ($instance['t1']);
		$t2 = ($instance['t2']);
		$t3 = ($instance['t3']);
		$img1 = ($instance['img1']);		
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php	 	  echo $this->get_field_id('title'); ?>">Widget Title: <input class="widefat" id="<?php	 	  echo $this->get_field_id('title'); ?>" name="<?php	 	  echo $this->get_field_name('title'); ?>" type="text" value="<?php	 	  echo attribute_escape($title); ?>" /></label></p>
        <p><label for="<?php	 	  echo $this->get_field_id('desc1'); ?>">Description : <textarea class="widefat" rows="6" cols="20" id="<?php	 	  echo $this->get_field_id('desc1'); ?>" name="<?php	 	  echo $this->get_field_name('desc1'); ?>"><?php	 	  echo attribute_escape($desc1); ?></textarea></label></p>
<?php	 	  /*?> <p><label for="<?php	 	  echo $this->get_field_id('t1'); ?>">Tel <input class="widefat" id="<?php	 	  echo $this->get_field_id('t1'); ?>" name="<?php	 	  echo $this->get_field_name('t1'); ?>" type="text" value="<?php	 	  echo attribute_escape($t1); ?>" /></label></p>
     <p><label for="<?php	 	  echo $this->get_field_id('t2'); ?>">Email <input class="widefat" id="<?php	 	  echo $this->get_field_id('t2'); ?>" name="<?php	 	  echo $this->get_field_name('t2'); ?>" type="text" value="<?php	 	  echo attribute_escape($t2); ?>" /></label></p>
        <p><label for="<?php	 	  echo $this->get_field_id('t3'); ?>">Web <input class="widefat" id="<?php	 	  echo $this->get_field_id('t3'); ?>" name="<?php	 	  echo $this->get_field_name('t3'); ?>" type="text" value="<?php	 	  echo attribute_escape($t3); ?>" /></label></p><?php	 	  */?>
       
<?php	 	 
	}}
register_widget('specialoffer_widget');


// =============================== Sidebar advt Widget ======================================
class sidebar_advt_widget extends WP_Widget {
	function sidebar_advt_widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Advt 190x100px', 'description' => 'Advt 190x100px' );		
		$this->WP_Widget('widgetsidebar_advt_widget', 'PT &rarr; Advt 190x100px', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						

		<div class="widget">
         
		 <?php	 	  if ( $desc1 <> "" ) { ?>	
         <?php	 	  echo $desc1; ?> 
         <?php	 	  } ?>
		
        </div> <!-- widget #end -->
            
            
	<?php	 	 
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['t1'] = ($new_instance['t1']);
		$instance['t2'] = ($new_instance['t2']);
		$instance['t3'] = ($new_instance['t3']);
		$instance['img1'] = ($new_instance['img1']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$t1 = ($instance['t1']);
		$t2 = ($instance['t2']);
		$t3 = ($instance['t3']);
		$img1 = ($instance['img1']);		
		$desc1 = ($instance['desc1']);
?>
<?php	 	  /*?>		<p><label for="<?php	 	  echo $this->get_field_id('title'); ?>">Widget Title: <input class="widefat" id="<?php	 	  echo $this->get_field_id('title'); ?>" name="<?php	 	  echo $this->get_field_name('title'); ?>" type="text" value="<?php	 	  echo attribute_escape($title); ?>" /></label></p><?php	 	  */?>
        <p><label for="<?php	 	  echo $this->get_field_id('desc1'); ?>">Description : <textarea class="widefat" rows="6" cols="20" id="<?php	 	  echo $this->get_field_id('desc1'); ?>" name="<?php	 	  echo $this->get_field_name('desc1'); ?>"><?php	 	  echo attribute_escape($desc1); ?></textarea></label></p>
<?php	 	  /*?> <p><label for="<?php	 	  echo $this->get_field_id('t1'); ?>">Tel <input class="widefat" id="<?php	 	  echo $this->get_field_id('t1'); ?>" name="<?php	 	  echo $this->get_field_name('t1'); ?>" type="text" value="<?php	 	  echo attribute_escape($t1); ?>" /></label></p>
     <p><label for="<?php	 	  echo $this->get_field_id('t2'); ?>">Email <input class="widefat" id="<?php	 	  echo $this->get_field_id('t2'); ?>" name="<?php	 	  echo $this->get_field_name('t2'); ?>" type="text" value="<?php	 	  echo attribute_escape($t2); ?>" /></label></p>
        <p><label for="<?php	 	  echo $this->get_field_id('t3'); ?>">Web <input class="widefat" id="<?php	 	  echo $this->get_field_id('t3'); ?>" name="<?php	 	  echo $this->get_field_name('t3'); ?>" type="text" value="<?php	 	  echo attribute_escape($t3); ?>" /></label></p><?php	 	  */?>
       
<?php	 	 
	}}
register_widget('sidebar_advt_widget');

// =============================== Dyanmic Sidebar Blockquote widget ======================================
class BlockquoteWidget extends WP_Widget {
	function BlockquoteWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Testimonials', 'description' => 'Testimonials' );		
		$this->WP_Widget('widget_blockquote', 'PT &rarr; Testimonials', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$quote = array();
		$author = array();
		if($instance['quote1' ])
		{
			$quote[] = empty($instance['quote1' ]) ? '' : apply_filters('widget_quote1', $instance['quote1']);
			$author[] = empty($instance['author1']) ? '' : apply_filters('widget_author1', $instance['author1']);
		}
		if($instance['quote2' ])
		{
			$quote[] = empty($instance['quote2']) ? '' : apply_filters('widget_quote2', $instance['quote2']);
			$author[] = empty($instance['author2']) ? '' : apply_filters('widget_author2', $instance['author2']);
		}
		if($instance['quote3' ])
		{
			$quote[] = empty($instance['quote3']) ? '' : apply_filters('widget_quote3', $instance['quote3']);
			$author[] = empty($instance['author3']) ? '' : apply_filters('widget_author3', $instance['author3']);
		}
		if($instance['quote4' ])
		{
			$quote[] = empty($instance['quote4']) ? '' : apply_filters('widget_quote4', $instance['quote4']);
			$author[] = empty($instance['author4']) ? '' : apply_filters('widget_author4', $instance['author4']);
		}
		if($instance['quote5' ])
		{
			$quote[] = empty($instance['quote5']) ? '' : apply_filters('widget_quote5', $instance['quote5']);
			$author[] = empty($instance['author5']) ? '' : apply_filters('widget_author5', $instance['author5']);
		}
		$more = empty($instance['more']) ? '' : apply_filters('widget_more', $instance['more']);
		?>	

		   <h3> <?php	 	  echo $title; ?> </h3>
          
          <?php	 	 
       if($quote)
	   {
			$key = rand(0,count($quote)-1);
			$quote1 = $quote[$key];
			$author1 = $author[$key];
			?>   
             <blockquote> 
             	 <p> <?php	 	  echo $quote1; ?>  </p> 
                <cite> - <?php	 	  echo $author1; ?> </cite>
             </blockquote>
         <?php	 	 
	   }
	   ?>
         
        <?php	 	  if ( $more <> "" ) { ?>	
        <p class="more"><a href="<?php	 	  echo $more; ?>">More success stories &raquo; </a></p>
         <?php	 	  } ?>
         
       
            
            
	<?php	 	 
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['quote1'] = ($new_instance['quote1']);
		$instance['author1'] = ($new_instance['author1']);
		$instance['quote2'] = ($new_instance['quote2']);
		$instance['author2'] = ($new_instance['author2']);
		$instance['quote3'] = ($new_instance['quote3']);
		$instance['author3'] = ($new_instance['author3']);
		$instance['quote4'] = ($new_instance['quote4']);
		$instance['author4'] = ($new_instance['author4']);
		$instance['quote5'] = ($new_instance['quote5']);
		$instance['author5'] = ($new_instance['author5']);
		$instance['more'] = ($new_instance['more']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'more' => '', 'quote1' => '', 'quote2' => '', 'quote3' => '',  'quote4' => '', 'quote5' => '','author1' => '','author2' => '','author3' => '','author4' => '','author5' => '' ) );		
		$title = strip_tags($instance['title']);
		$quote1 = ($instance['quote1']);
		$author1 = ($instance['author1']);
		$quote2 = ($instance['quote2']);
		$author2 = ($instance['author2']);
		$quote3 = ($instance['quote3']);
		$author3 = ($instance['author3']);
		$quote4 = ($instance['quote4']);
		$author4 = ($instance['author4']);
		$quote5 = ($instance['quote5']);
		$author5 = ($instance['author5']);
		$more = ($instance['more']);
?>
		<p><label for="<?php	 	  echo $this->get_field_id('title'); ?>">Widget Title: <input class="widefat" id="<?php	 	  echo $this->get_field_id('title'); ?>" name="<?php	 	  echo $this->get_field_name('title'); ?>" type="text" value="<?php	 	  echo attribute_escape($title); ?>" /></label></p>
        <p><label for="<?php	 	  echo $this->get_field_id('quote1'); ?>">Testimonials 1 <textarea class="widefat" rows="6" cols="20" id="<?php	 	  echo $this->get_field_id('quote1'); ?>" name="<?php	 	  echo $this->get_field_name('quote1'); ?>"><?php	 	  echo attribute_escape($quote1); ?></textarea></label></p>
 <p><label for="<?php	 	  echo $this->get_field_id('author1'); ?>">Author Name 1 <input class="widefat" id="<?php	 	  echo $this->get_field_id('author1'); ?>" name="<?php	 	  echo $this->get_field_name('author1'); ?>" type="text" value="<?php	 	  echo attribute_escape($author1); ?>" /></label></p>
     <p><label for="<?php	 	  echo $this->get_field_id('quote2'); ?>">Testimonials 2 <textarea class="widefat" rows="6" cols="20" id="<?php	 	  echo $this->get_field_id('quote2'); ?>" name="<?php	 	  echo $this->get_field_name('quote2'); ?>"><?php	 	  echo attribute_escape($quote2); ?></textarea></label></p>
 <p><label for="<?php	 	  echo $this->get_field_id('author2'); ?>">Author Name 2 <input class="widefat" id="<?php	 	  echo $this->get_field_id('author2'); ?>" name="<?php	 	  echo $this->get_field_name('author2'); ?>" type="text" value="<?php	 	  echo attribute_escape($author2); ?>" /></label></p>
 <p><label for="<?php	 	  echo $this->get_field_id('quote3'); ?>">Testimonials 3 <textarea class="widefat" rows="6" cols="20" id="<?php	 	  echo $this->get_field_id('quote3'); ?>" name="<?php	 	  echo $this->get_field_name('quote3'); ?>"><?php	 	  echo attribute_escape($quote3); ?></textarea></label></p>
 <p><label for="<?php	 	  echo $this->get_field_id('author3'); ?>">Author Name 3 <input class="widefat" id="<?php	 	  echo $this->get_field_id('author3'); ?>" name="<?php	 	  echo $this->get_field_name('author3'); ?>" type="text" value="<?php	 	  echo attribute_escape($author3); ?>" /></label></p>
 <p><label for="<?php	 	  echo $this->get_field_id('quote4'); ?>">Testimonials 4 <textarea class="widefat" rows="6" cols="20" id="<?php	 	  echo $this->get_field_id('quote4'); ?>" name="<?php	 	  echo $this->get_field_name('quote4'); ?>"><?php	 	  echo attribute_escape($quote4); ?></textarea></label></p>
 <p><label for="<?php	 	  echo $this->get_field_id('author4'); ?>">Author Name 4 <input class="widefat" id="<?php	 	  echo $this->get_field_id('author4'); ?>" name="<?php	 	  echo $this->get_field_name('author4'); ?>" type="text" value="<?php	 	  echo attribute_escape($author4); ?>" /></label></p>
  <p><label for="<?php	 	  echo $this->get_field_id('quote5'); ?>">Testimonials 5 <textarea class="widefat" rows="6" cols="20" id="<?php	 	  echo $this->get_field_id('quote5'); ?>" name="<?php	 	  echo $this->get_field_name('quote5'); ?>"><?php	 	  echo attribute_escape($quote5); ?></textarea></label></p>
 <p><label for="<?php	 	  echo $this->get_field_id('author5'); ?>">Author Name 5 <input class="widefat" id="<?php	 	  echo $this->get_field_id('author5'); ?>" name="<?php	 	  echo $this->get_field_name('author5'); ?>" type="text" value="<?php	 	  echo attribute_escape($author5); ?>" /></label></p>
  <p><label for="<?php	 	  echo $this->get_field_id('more'); ?>">More reviews and buzz url link here (ex.http://templatic.com/review) <input class="widefat" id="<?php	 	  echo $this->get_field_id('more'); ?>" name="<?php	 	  echo $this->get_field_name('more'); ?>" type="text" value="<?php	 	  echo attribute_escape($more); ?>" /></label></p>
       
<?php	 	 
	}}
register_widget('BlockquoteWidget');



// =============================== Download Brochure Widget ======================================
class downloadwidget extends WP_Widget {
	function downloadwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Download Brochure', 'description' => 'Download Brochure' );		
		$this->WP_Widget('widget_downloadwidget', 'PT &rarr; Download Brochure', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$t1 = empty($instance['t1']) ? '' : apply_filters('widget_t1', $instance['t1']);
		$t2 = empty($instance['t2']) ? '' : apply_filters('widget_t2', $instance['t2']);
		 ?>						


			<div class="download_brochure">
                    	<div class="download_brochure_in"> 
                         <?php	 	  if ( $t1 <> "" ) { ?>	
                        <a  href="<?php	 	  echo $t1; ?>" target="_blank"><img src="<?php	 	  bloginfo('template_directory'); ?>/images/i_brochure.png" alt="" class="fl"  /></a>
                        <?php	 	  } ?> 
                        
                     	<h3><?php	 	  echo $title; ?> </h3>
                        
						<?php	 	  if ( $t2 <> "" ) { ?> <p><?php	 	  echo $t2; ?></p> <?php	 	  } ?>
              </div>
            </div>  <!-- download_brochure #end -->
			
             
	<?php	 	 
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['t1'] = ($new_instance['t1']);
		$instance['t2'] = ($new_instance['t2']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  't4' => '', 't5' => '','t6' => '' ) );		
		$title = strip_tags($instance['title']);
		$t1 = ($instance['t1']);
		$t2 = ($instance['t2']);
?>
		<p><label for="<?php	 	  echo $this->get_field_id('title'); ?>">Widget Title: <input class="widefat" id="<?php	 	  echo $this->get_field_id('title'); ?>" name="<?php	 	  echo $this->get_field_name('title'); ?>" type="text" value="<?php	 	  echo attribute_escape($title); ?>" /></label></p>
	 <p><label for="<?php	 	  echo $this->get_field_id('t1'); ?>">Download PDF URL link (http://templatic.com/templatic.pdf) : <input class="widefat" id="<?php	 	  echo $this->get_field_id('t1'); ?>" name="<?php	 	  echo $this->get_field_name('t1'); ?>" type="text" value="<?php	 	  echo attribute_escape($t1); ?>" /></label></p>
     <p><label for="<?php	 	  echo $this->get_field_id('t2'); ?>"> Description :<input class="widefat" id="<?php	 	  echo $this->get_field_id('t2'); ?>" name="<?php	 	  echo $this->get_field_name('t2'); ?>" type="text" value="<?php	 	  echo attribute_escape($t2); ?>" /></label></p>
<?php	 	 
	}}
register_widget('downloadwidget');




// =============================== Feedburner Subscribe widget ======================================
function subscribeWidget()
{
	// Include the MCAPI 
	include( TEMPLATEPATH . "/inc/MCAPI.class.php");

	// Get the settings for the widget
	$settings = get_option("widget_subscribewidget");

	// Parse the options
	$id = $settings['id'];
	$title = $settings['title'];
	$text = $settings['text'];	

	// Instantiate the Mail Chimp API object
	$api = new MCAPI( get_option( 'mailchimp_api' ) ); // TO-DO:  INSERT THE API KEY.  
?> 
	<div id="sub" style="margin-top: -60px; padding-top: 60px;"></div>
    <div class="subscribe">
        <div class="subscribe_in">
        	<?php 
        	// Handle submission
        	if( isset( $_POST['subscribe'] ) && isset( $_POST['email'] ) )
        	{
        		// Parse the email, and add it to the list
        		$email  = $_POST['email'];
				$retval = $api->listSubscribe( get_option( 'mailchimp_list_key' ), $email );

				// Give the user feedback
				if( $api->errorCode )
				{
					$text = '<span style="color: red;">Oops, there was an error!</span><br />';
					$text .= '<span style="color: red;">' . $api->errorMessage . '</span>';

				}
				else
				{
					$text = '<span style="color: green;">You\'ve been added to the list!  You will be contacted to confirm your submission.</span>';
				}
        	}
        	?>
            <p><?php echo $text; ?></p>
       		<form action="#sub" method="post"> 
				<input type="text" class="textfield" onFocus="if (this.value == 'Your Email Address') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Your Email Address';}" name="email"/>
      			<input type="hidden" value="<?php	 	  echo $id; ?>" class="" name="uri"/>
     			<input type="hidden" name="loc" value="en_US"/>
       			<input name="subscribe"  type="image" src="<?php	 	  bloginfo('template_url'); ?>/images/none.png"   value="Subscribe" class="bsubscribe" alt="submit" />
       		</form>                         
     	</div>
 </div> <!-- subscribein #end -->
		 

<?php	 	 
}

function subscribeWidgetAdmin() {

	$settings = get_option("widget_subscribewidget");

	// check if anything's been sent
	if (isset($_POST['update_subscribe'])) {
		$settings['id'] = strip_tags(stripslashes($_POST['subscribe_id']));
		$settings['title'] = strip_tags(stripslashes($_POST['subscribe_title']));
		$settings['text'] = strip_tags(stripslashes($_POST['subscribe_text']));		

		update_option("widget_subscribewidget",$settings);
	}

	echo '<p>
			<label for="subscribe_text">Text Under Title:
			<input id="subscribe_text" name="subscribe_text" type="text" class="widefat" value="'.$settings['text'].'" /></label></p>';
	echo '<p>
			<label for="subscribe_id">Feedburner ID (ex: templatic/eKPs):
			<input id="subscribe_id" name="subscribe_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';			
	echo '<input type="hidden" id="update_subscribe" name="update_subscribe" value="1" />';

}

register_sidebar_widget('PT &rarr; Subscribe', 'subscribeWidget');
register_widget_control('PT &rarr; Subscribe', 'subscribeWidgetAdmin', 400, 200);





// =============================== Flickr widget ======================================

function flickrWidget()
{
	$settings = get_option("widget_flickrwidget");

	$id = $settings['id'];
	$number = $settings['number'];

?>

<div class="widget flickr">
			
        <h3 class="hl"><span><span class="flickr-logo">flick<b>r</b></span> photostream</span></h3>
				
		<div class="fix"></div>
            			
            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php	 	  echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php	 	  echo $id; ?>"></script>  
		
		<div class="fix"></div>
		
</div>		

<?php	 	 
}
function flickrWidgetAdmin() {

	$settings = get_option("widget_flickrwidget");

	// check if anything's been sent
	if (isset($_POST['update_flickr'])) {
		$settings['id'] = strip_tags(stripslashes($_POST['flickr_id']));
		$settings['number'] = strip_tags(stripslashes($_POST['flickr_number']));

		update_option("widget_flickrwidget",$settings);
	}

	echo '<p>
			<label for="flickr_id">Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):
			<input id="flickr_id" name="flickr_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';
	echo '<p>
			<label for="flickr_number">Number of photos:
			<input id="flickr_number" name="flickr_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_flickr" name="update_flickr" value="1" />';

}

register_sidebar_widget('PT &rarr; Flickr Photos', 'flickrWidget');
register_widget_control('PT &rarr; Flickr Photos', 'flickrWidgetAdmin', 250, 200);



 // =============================== Latest Posts Widget (particular category) ======================================

class LatestPostsParticular2 extends WP_Widget {
	function LatestPostsParticular2() {

	//Constructor
		$widget_ops = array('classname' => 'widget Latest News', 'description' => 'List of latest News in particular category' );
		$this->WP_Widget('widget_posts', 'PT &rarr; Latest News', $widget_ops);
	}

 

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '&nbsp;' : apply_filters('widget_post_number', $instance['post_number']);
		$more_link = empty($instance['more_link']) ? '&nbsp;' : apply_filters('widget_more_link', $instance['more_link']);

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo '<ul class="news">';
		        ?><?php	 	  
			        global $post;
			        $latest_menus = get_posts('numberposts='.$post_number.'postlink='.$post_link.'&category='.$category.'');
                    foreach($latest_menus as $post) :
                    setup_postdata($post);

			    ?>
                 <li><span><?php	 	  the_time('j') ?> <br /> <small><?php	 	  the_time('F') ?></s> </small> </span> <a class="widget-title" href="<?php	 	  the_permalink(); ?>"><?php	 	  the_title(); ?>
                </a></li>
             
		<?php	 	  endforeach; ?>
        <?php	 	 
		
		
		

	    echo '</ul>';
					
					?>
				 <?php	 	  if ( $more_link <> "" ) { ?>	
        		<p class="more_news"> <a href="<?php	 	  echo $more_link; ?>">More News</a>  </p>
         <?php	 	  } 
				
		

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {

	//save the widget

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['more_link'] = strip_tags($new_instance['more_link']);
		return $instance;

	}

 

	function form($instance) {

	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '', 'more_link' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$more_link = strip_tags($instance['more_link']);

?>
<p>
  <label for="<?php	 	  echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php	 	  echo $this->get_field_id('title'); ?>" name="<?php	 	  echo $this->get_field_name('title'); ?>" type="text" value="<?php	 	  echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php	 	  echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
    <input class="widefat" id="<?php	 	  echo $this->get_field_id('category'); ?>" name="<?php	 	  echo $this->get_field_name('category'); ?>" type="text" value="<?php	 	  echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php	 	  echo $this->get_field_id('post_number'); ?>">Number of posts:
    <input class="widefat" id="<?php	 	  echo $this->get_field_id('post_number'); ?>" name="<?php	 	  echo $this->get_field_name('post_number'); ?>" type="text" value="<?php	 	  echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php	 	  echo $this->get_field_id('more_link'); ?>">View More New Link :
    <input class="widefat" id="<?php	 	  echo $this->get_field_id('more_link'); ?>" name="<?php	 	  echo $this->get_field_name('more_link'); ?>" type="text" value="<?php	 	  echo attribute_escape($more_link); ?>" />
  </label>
</p>
<?php	 	 

	}

}

register_widget('LatestPostsParticular2');




// =============================== Popular Posts Widget ======================================

function PopularPostsSidebar()
{

    $settings_pop = get_option("widget_popularposts");

	$name = $settings_pop['name'];
	$number = $settings_pop['number'];
	if ($name <> "") { $popname = $name; } else { $popname = 'Popular Posts'; }
	if ($number <> "") { $popnumber = $number; } else { $popnumber = '10'; }

?>

<div class="widget popular">

	<h3 class="hl"><span><?php	 	  echo $popname; ?></span></h3>
	
		<ul>
			 
			<?php	 	 
			global $wpdb;
            $now = gmdate("Y-m-d H:i:s",time());
            $lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
            $popularposts = "SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT $popnumber";
            $posts = $wpdb->get_results($popularposts);
            $popular = '';
            if($posts){
                foreach($posts as $post){
	                $post_title = stripslashes($post->post_title);
		               $guid = get_permalink($post->ID);
					   
					      $first_post_title=substr($post_title,0,26);
            ?>
		        <li>
                    <a href="<?php	 	  echo $guid; ?>" title="<?php	 	  echo $post_title; ?>"><?php	 	  echo $first_post_title; ?></a>
                    <br style="clear:both" />
                </li>
            <?php	 	  } } ?>

		</ul>
</div>

<?php	 	 
}
function PopularPostsAdmin() {

	$settings_pop = get_option("widget_popularposts");

	// check if anything's been sent
	if (isset($_POST['update_popular'])) {
		$settings_pop['name'] = strip_tags(stripslashes($_POST['popular_name']));
		$settings_pop['number'] = strip_tags(stripslashes($_POST['popular_number']));

		update_option("widget_popularposts",$settings_pop);
	}

	echo '<p>
			<label for="popular_name">Title:
			<input id="popular_name" name="popular_name" type="text" class="widefat" value="'.$settings_pop['name'].'" /></label></p>';
	echo '<p>
			<label for="popular_number">Number of popular posts:
			<input id="popular_number" name="popular_number" type="text" class="widefat" value="'.$settings_pop['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_popular" name="update_popular" value="1" />';

}

register_sidebar_widget('PT &rarr; Popular Posts', 'PopularPostsSidebar');
register_widget_control('PT &rarr; Popular Posts', 'PopularPostsAdmin', 250, 200);


// =============================== Twitter widget ======================================
// Plugin Name: Twitter Widget
// Plugin URI: http://seanys.com/2007/10/12/twitter-wordpress-widget/
// Description: Adds a sidebar widget to display Twitter updates (uses the Javascript <a href="http://twitter.com/badges/which_badge">Twitter 'badge'</a>)
// Version: 1.0.3
// Author: Sean Spalding
// Author URI: http://seanys.com/
// License: GPL

function widget_Twidget_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;

	function widget_Twidget($args) {

		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);

		// These are our own options
		$options = get_option('widget_Twidget');
		$account = $options['account'];  // Your Twitter account name
		$title = $options['title'];  // Title in sidebar for widget
		$show = $options['show'];  // # of Updates to show
		$follow = $options['follow'];  // # of Updates to show

        // Output
		echo $before_widget ;

		// start
		echo '<div class="twitter clearfix"><h3><a href="http://www.twitter.com/'.$account.'/" title="'.$follow.'">'.$title.' </a></h3>';              
		echo '<div class="twitter_post"><div id="twitter">';
		echo '<ul id="twitter_update_list"><li></li></ul>
		      <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>';
		echo '<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.$account.'.json?callback=twitterCallback2&amp;count='.$show.'"></script>';
		echo '</div></div></div>';
			
				
		// echo widget closing tag
		echo $after_widget;
	}

	// Settings form
	function widget_Twidget_control() {

		// Get options
		$options = get_option('widget_Twidget');
		// options exist? if not set defaults
		if ( !is_array($options) )
			$options = array('account'=>'rbhavesh', 'title'=>'Twitter Updates', 'show'=>'3');

        // form posted?
		if ( $_POST['Twitter-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['account'] = strip_tags(stripslashes($_POST['Twitter-account']));
			$options['title'] = strip_tags(stripslashes($_POST['Twitter-title']));
			$options['show'] = strip_tags(stripslashes($_POST['Twitter-show']));
			$options['follow'] = strip_tags(stripslashes($_POST['Twitter-follow']));
			$options['linkedin'] = strip_tags(stripslashes($_POST['Twitter-linkedin']));
			$options['facebook'] = strip_tags(stripslashes($_POST['Twitter-facebook']));
			update_option('widget_Twidget', $options);
		}

		// Get options for form fields to show
		$account = htmlspecialchars($options['account'], ENT_QUOTES);
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$show = htmlspecialchars($options['show'], ENT_QUOTES);
		$follow = htmlspecialchars($options['follow'], ENT_QUOTES);

		// The form fields
		echo '<p style="text-align:left;">
				<label for="Twitter-account">' . __('Twitter Account ID:') . '
				<input style="width: 280px;" id="Twitter-account" name="Twitter-account" type="text" value="'.$account.'" />
				</label></p>';
		echo '<p style="text-align:left;">
				<label for="Twitter-title">' . __('Title:') . '
				<input style="width: 280px;" id="Twitter-title" name="Twitter-title" type="text" value="'.$title.'" />
				</label></p>';
		echo '<p style="text-align:left;">
				<label for="Twitter-show">' . __('Show Twitter Posts:') . '
				<input style="width: 280px;" id="Twitter-show" name="Twitter-show" type="text" value="'.$show.'" />
				</label></p>';
		echo '<input type="hidden" id="Twitter-submit" name="Twitter-submit" value="1" />';
	}


	// Register widget for use
	register_sidebar_widget(array('PT &rarr; Twitter', 'widgets'), 'Widget_Twidget');

	// Register settings for use, 300x200 pixel form
	register_widget_control(array('PT &rarr; Twitter', 'widgets'), 'Widget_Twidget_control', 300, 200);
	
}

// Run code and init
add_action('widgets_init', 'widget_Twidget_init');
?>