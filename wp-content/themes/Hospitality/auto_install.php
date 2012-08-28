<?php	 	 
set_time_limit(0);
global  $wpdb;
//require_once (TEMPLATEPATH . '/delete_data.php');

global  $wpdb;
$dummy_image_path = get_template_directory_uri().'/images/dummy/';
/*echo "<pre>";
print_r(get_option('sidebars_widgets'));
print_r(get_option('widget_widgetsidebar_advt_widget'));
exit;*/

//====================================================================================//
/////////////// TERMS START ///////////////
require_once(ABSPATH.'wp-admin/includes/taxonomy.php');
$category_array = array('Blog');
insert_category($category_array);
function insert_category($category_array)
{
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				$last_catid = wp_create_category( $catname, $parent_catid);
				if($j==0)
				{
					$parent_catid = $last_catid;
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			wp_create_category( $catname, $parent_catid);
		}
	}
}
/////////////// TERMS END ///////////////
//====================================================================================//
$post_info = array();
////post start 1///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in1.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Maecenas urna purus, fermentum id, molestie in dolor siteamet',
					"post_content"	=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///
////post start 2///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in2.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Quisque ornare risus quis  ligula. dolor site amet dolor siteamet',
					"post_content"	=>	'Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///
////post start 3///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in3.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Vestibulum ut nisl. Donec eu mi sed turpis fermentum id, molestie in',
					"post_content"	=>	'<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl.</p><p>Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl.</p>',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///
////post start 4///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in4.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Dolor  ipsum dolor sit amet, consecte tuer adipiscing elit  justo',
					"post_content"	=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///
////post start 5///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in5.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Dolor  ipsum dolor sit',
					"post_content"	=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///
////post start 6///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in1.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Commodo  porttitor  ipsum dolor sit',
					"post_content"	=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///
////post start 7///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in2.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Aommodo  porttitor  ipsum dolor sit',
					"post_content"	=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///
////post start 7///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in3.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Qommodo  porttitor  ipsum dolor sit',
					"post_content"	=>	'Consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///
////post start 8///
$image_array = array();
$post_meta = array();
$post_meta = array(
					"tl_dummy_content"	=> '1',
					"image"				=> $dummy_image_path.'hotel_in2.jpg',
				);
$post_info[] = array(
					"post_title"	=>	'Qommodo  porttitor  ipsum dolor sit',
					"post_content"	=>	'Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array()
					);
////post end///

//====================================================================================//
insert_posts($post_info);
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
//====================================================================================//

$pages_array = array('Privacy Policy','Terms & Conditions',array('Gallery','Hotel Front View','Hotel Other Photos'),array('Page&ndash;Templates','Page Full Content','Archives','Location','Careers'),'Services','Special Offers','Testimonials','Contact Us');
$page_info_arr = array();
$page_info_arr['Page&ndash;Templates'] = '
<p>The Templatic is a brand that combines a rich legacy of carefully nurtured values steeped in a culture of excellence with opportunities for participating in new vistas of the Company growth. The main success factor for the Company growth, are the Templatic employees and talent selected for this exciting journey. The Templatic considers its employees among its most important stakeholders in taking it to new pinnacles of service standards and guest delight.</p>
<p>At the Templatic, every employee is an ambassador of the culture and spirit of the Templatic. The Templatic magic is all about passion in what one is doing, the pursuit of excellence, feeling included, warmth and the highest levels of service standards with a relentless and untiring obsession about delighting the guest. This spirit that rings through the heart of every Templatic employee makes the difference between a job in any hospitality company and career with the Templatic.</p>
<p>What is in it for you to work for the Templatic?<br>
A career in the hospitality industry offers an opportunity to sharpen the saw of one
At the Templatic, every employee is an ambassador of the culture and spirit of the Templatic. The Templatic magic is all about passion in what one is doing, the pursuit of excellence, feeling included, warmth and the highest levels of service standards with a relentless and untiring obsession about delighting the guest. This spirit that rings through the heart of every Templatic employee makes the difference between a job in any hospitality company and career with the Templatic.</p>
<p>What is in it for you to work for the Templatic?<br>A career in the hospitality industry offers an opportunity to sharpen the saw of one</p>
<p>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>';
$page_info_arr['Page Full Content'] = '
<img class="imgright" alt="" src="'.$dummy_image_path.'careers.jpg"> The Templatic is a brand that combines a rich legacy of carefully nurtured values steeped in a culture of excellence with opportunities for participating in new vistas of the Company growth. The main success factor for the Company growth, are the Templatic employees and talent selected for this exciting journey. The Templatic considers its employees among its most important stakeholders in taking it to new pinnacles of service standards and guest delight.
<br><br>
At the Templatic, every employee is an ambassador of the culture and spirit of the Templatic. The Templatic magic is all about passion in what one is doing, the pursuit of excellence, feeling included, warmth and the highest levels of service standards with a relentless and untiring obsession about delighting the guest. This spirit that rings through the heart of every Templatic employee makes the difference between a job in any hospitality company and career with the Templatic.
<br><br>
What is in it for you to work for the Templatic?<br>
A career in the hospitality industry offers an opportunity to sharpen the saw of one';
$page_info_arr['Location'] = 
'<div class="google_map">
<iframe width="640" height="365" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=727+Flournoy+Lucas+Road,+Shreveport,+La+71118&sll=44.246913,-62.944799&sspn=91.718249,227.636719&num=10&ie=UTF8&hq=&hnear=727+Flournoy+Lucas+Rd,+Shreveport,+Caddo,+Louisiana+71118&z=16&ll=32.389906,-93.773502&output=embed"></iframe>
</div>
<p>
Naumi is situated where the shopping and financial districts meet. With the airport a quick 20 minutes ride by taxi and the SUNTEC Convention Centre, the Formula One Race Track, and the upcoming Integrated Resort at Marina Bay a stone&acute;s throw away, Naumi is within easy access of main transportation lines, traffic thoroughfares and urban attractions
</p>
Address<br>
401 Elliott Avenue West<br>
Seattle, WA 98119<br><br>
Contact numbers<br>
Tel +65 6403 6000<br>
Fax +65 6403 6010 <br><br>
<h3>How to reach us from the north</h3>
<br>
Exit the A1 Highway or Motorway at Firenze Nord or A11 (coming from Bologna o Lucca): follow the sign that shows the direction of "CENTRO" or "STADIO", until you get to Piazza della Libert';
$page_info_arr['Privacy Policy'] = '
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.';
$page_info_arr['Terms & Conditions'] = '
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.';

$page_info_arr['Services'] = '
 <div class="services"><img src="'.$dummy_image_path.'services1.jpg" alt="" class="imgright" ><h3> Guest Room </h3><p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. 
Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. </div>

 <div class="services"><img src="'.$dummy_image_path.'services2.jpg" alt="" class="imgright" ><h3> Wedding & Cermonses </h3><p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. 
Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. </div>

 <div class="services"><img src="'.$dummy_image_path.'services3.jpg" alt="" class="imgright" ><h3> Business Meeting </h3><p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. 
Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. </div>

 <div class="services"><img src="'.$dummy_image_path.'services4.jpg" alt="" class="imgright" ><h3>Pool & Fitness Centre </h3><p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. 
Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. </div>

 <div class="services"><img src="'.$dummy_image_path.'services5.jpg" alt="" class="imgright" ><h3>Spa </h3><p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. 
Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. </div>
';
$page_info_arr['Careers'] = '
<img class="imgright" alt="" src="'.$dummy_image_path.'careers.jpg"> The Templatic is a brand that combines a rich legacy of carefully nurtured values steeped in a culture of excellence with opportunities for participating in new vistas of the Company growth. The main success factor for the Company growth, are the Templatic employees and talent selected for this exciting journey. The Templatic considers its employees among its most important stakeholders in taking it to new pinnacles of service standards and guest delight.

At the Templatic, every employee is an ambassador of the culture and spirit of the Templatic. The Templatic magic is all about passion in what one is doing, the pursuit of excellence, feeling included, warmth and the highest levels of service standards with a relentless and untiring obsession about delighting the guest. This spirit that rings through the heart of every Templatic employee makes the difference between a job in any hospitality company and career with the Templatic.

What is in it for you to work for the Templatic?
A career in the hospitality industry offers an opportunity to sharpen the saw of one’s own emotional quotient. The Templatic compounds this advantage because of the diversity of its products, properties and people. The Templatic nurtures a service mentality that demands an attitude of being quick and agile in terms of response time, attention to detail, operational excellence, postponing gratification to ensure that the guest is delighted at all times and developing one social radar through networking skills. The Templatic provides its employees space and elbow room for exploring opportunities to emerge as career leaders in a supportive environment through a high potential program in which every executive has a chance to participate. The safe environment of the Templatic encourages its employees to be outspoken, to grow in self-confidence and this self-development journey which accompanies a career in the Templatic become a self fulfilling prophecy for success and excellence.

We have an internal mobility process which allows employees to move freely between functions, hotels and disciplines, and develop their skills as well rounded professionals in an employee self discovery environment. Opportunities for career choices are multiple and there are possibilities of moving across to other Tata companies for talented professionals. Templatic’s growth plan which includes expanding its footprint in the global arena as well as growing in domestic dominance provides opportunities for a large number of roles and careers unfolding. This perhaps is the most attractive proposition while exploring a career with the Templatic.

You can visit our Job Search section to know about the current opportunities available.
';
$page_info_arr['Special Offers'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>
The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul>
current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two o&acute;clock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.
<p style="text-align: center;">Part of the little raft&acute;s belongings consisted of an old sail, and this they spread over a nook in the bushes for a tent to shelter their provisions; but they themselves would sleep in the open air in good weather, as became outlaws.</p>

<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Testimonials'] = '<blockquote> Up We had a great night. The food was amazing. The service excellent and very accommodating, especially when we had an extra person turn up. Would definitely recommend to friends and work colleagues </blockquote>
<cite>- Catty</cite>
<hr />

<blockquote> Wanted to let you know that we had a fantastic evening Saturday night! The food was amazing and service great! Great venue will definitely recommend it to my friends.  </blockquote>
<cite>- Krista</cite>

<hr />

<blockquote> Just wanted to drop you a line to say thanks for Tuesday night. Everything went really well with our event so we are pleased. We had lots of positive feedback from our guests regarding the venue space and the food. </blockquote>
<cite>- Carpy</em></cite>

<hr />

<blockquote> A great time was had by all and everyone thought the food was great so thanks for ensuring that all went smoothly.Ill defo bear you in mind if we need a venue in the future.</blockquote>
<cite>- Taniya</cite>
';
set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}

		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				
				$post_name = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_'),array('','','','','','','','','','','','','','','','','','','','',',',''),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name like \"$post_name%\" and post_type='page'");
				if($post_name_count>0)
				{
					$post_name = $post_name.'-'.($post_name_count+1);
				}
				$post_id_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_id_count==0)
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = get_option('siteurl')."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'tl_dummy_content', 1 );
				}
			}
		}
	}
}
/////////////// Design Settings START ///////////////
update_option("ptthemes_alt_stylesheet",'1-default.css');
update_option("ptthemes_feedburner_url",'http://feeds2.feedburner.com/Templatic');
update_option("ptthemes_breadcrumbs",'true'); 
update_option("ptthemes_hotel_phone",'Call Now! <br /><span> +91 999 999 9999 </span>'); 
update_option("ptthemes_hotel_address",'401 Elliott Avenue West <br />Seattle, WA 98119'); 
update_option("ptthemes_banner1_url",$dummy_image_path.'hotel1.png');
update_option("ptthemes_banner1_link",'http://www.templatic.com');
update_option("ptthemes_banner1_caption",'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum');
update_option("ptthemes_banner2_url",$dummy_image_path.'hotel2.png');
update_option("ptthemes_banner2_link",'http://www.templatic.com');
update_option("ptthemes_banner2_caption",'Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget');
update_option("ptthemes_banner3_url",$dummy_image_path.'hotel3.png');
update_option("ptthemes_banner3_link",'http://www.templatic.com');
update_option("ptthemes_banner3_caption",'Nam blandit quam ut lacus. Quisque ornare risus quis ligula.');
update_option("ptthemes_banner4_url",$dummy_image_path.'hotel1.png');
update_option("ptthemes_banner4_link",'http://www.templatic.com');
update_option("ptthemes_banner4_caption",'Donec et ipsum et sapien vehicula nonummy.');
update_option("ptthemes_banner5_url",$dummy_image_path.'hotel3.png');
update_option("ptthemes_banner5_link",'http://www.templatic.com');
update_option("ptthemes_banner5_caption",'In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat');

$page_ids = $wpdb->get_var("SELECT group_concat(ID) FROM $wpdb->posts where post_title in ('Terms & Conditions','Privacy Policy','About') and post_type='page'");
if($page_ids)
{
	$page_ids_arr = explode(',',$page_ids);
	for($p=0;$p<count($page_ids_arr);$p++)
	{
		update_option("pag_exclude_".$page_ids_arr[$p],'true');
	}
}
update_option("ptthemes_footerpages",$page_ids);
update_option("ptthemes_blogcategory",'Blog');

$gallery_cat_id = $wpdb->get_var("SELECT group_concat(term_id) FROM $wpdb->terms where name in ('Hotel Front View','Hotel Other Photos')");
if($gallery_cat_id)
{
	$gallery_cat_id_arr = explode(',',$gallery_cat_id);
	for($p=0;$p<count($gallery_cat_id_arr);$p++)
	{
		update_option("cat_exclude_".$gallery_cat_id_arr[$p],'true');
	}
}
update_option("ptthemes_home_name",'Home'); ////
update_option("ptthemes_search_name",'Search');
update_option("ptthemes_search_nothing_found",'Nothing found, please search again.');
update_option("ptthemes_general_tags_name",'Tags');
update_option("ptthemes_browsing_category",'Browsing Category');
update_option("ptthemes_browsing_tag",'Browsing Tag');
update_option("ptthemes_browsing_author",'Browsing Posts of Author');
update_option("ptthemes_browsing_search",'Browsing Posts filed under Search Term');
update_option("ptthemes_browsing_day",'Browsing Day');
update_option("ptthemes_browsing_month",'Browsing Month');
update_option("ptthemes_browsing_year",'Browsing Year');
update_option("ptthemes_404error_name",'Error 404 | Nothing found!');
update_option("ptthemes_404solution_name",'Sorry, but you are looking for something that is not here.');
update_option("ptthemes_password_protected_name",'This post is password protected. Enter the password to view comments.');
update_option("ptthemes_comment_responsesa_name",'No Comments');
update_option("ptthemes_comment_responsesb_name",'One Comment');
update_option("ptthemes_comment_responsesc_name",'% Comments');
update_option("ptthemes_comment_trackbacks_name",'Trackbacks For This Post');
update_option("ptthemes_comment_moderation_name",'Your comment is awaiting moderation.');
update_option("ptthemes_comment_conversation_name",'Be the first to start a conversation');
update_option("ptthemes_comment_closed_name",'Comments are closed.');
update_option("ptthemes_comment_off_name",'Comments are off for this post');
update_option("ptthemes_comment_reply_name",'Leave a Reply');
update_option("ptthemes_comment_mustbe_name",'You must be');
update_option("ptthemes_comment_loggedin_name",'logged in');
update_option("ptthemes_comment_postcomment_name",'to post a comment.');
update_option("ptthemes_comment_name_name",'Name');
update_option("ptthemes_comment_mail_name",'Mail');
update_option("ptthemes_comment_website_name",'Website');
update_option("ptthemes_comment_addcomment_name",'Add Comment');
update_option("ptthemes_comment_justreply_name",'Reply');
update_option("ptthemes_comment_edit_name",'Edit');
update_option("ptthemes_comment_delete_name",'Delete');
update_option("ptthemes_comment_spam_name",'Spam');
update_option("ptthemes_pagination_first_name",'First');
update_option("ptthemes_pagination_last_name",'Last');
update_option("ptthemes_relative_posted",'Posted');
update_option("ptthemes_relative_ago",'ago');
update_option("ptthemes_relative_s",'s');
update_option("ptthemes_relative_year",'year');
update_option("ptthemes_relative_month",'month');
update_option("ptthemes_relative_week",'week');
update_option("ptthemes_relative_day",'day');
update_option("ptthemes_relative_hour",'hour');
update_option("ptthemes_relative_minute",'minute');
update_option("ptthemes_relative_second",'second');
update_option("ptthemes_relative_moments",'moments');
$page_ids = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title in ('Archives') and post_type='page'");
update_post_meta($page_ids,'_wp_page_template','page-archives.php');
$page_ids = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title in ('Page Full Content') and post_type='page'");
update_post_meta($page_ids,'_wp_page_template','page_full.php');

$page_ids = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title in ('Gallery') and post_type='page'");
$last_postid = $page_ids;
update_post_meta($page_ids,'_wp_page_template','page-gallery.php');
$gallery_image = array('dummy/hotel1.jpg','dummy/hotel2.jpg','dummy/hotel3.jpg','dummy/hotel_in1.jpg','dummy/hotel_in2.jpg','dummy/hotel_in3.jpg','dummy/hotel_in4.jpg','dummy/hotel_in5.jpg','dummy/hotel_in15.jpg');
if($last_postid && $gallery_image)
{
	for($m=0;$m<count($gallery_image);$m++)
	{
		$menu_order = $m+1;
		$image_name_arr = explode('/',$gallery_image[$m]);
		$img_name = $image_name_arr[count($image_name_arr)-1];
		$img_name_arr = explode('.',$img_name);
		$post_img = array();
		$post_img['post_title'] = $img_name_arr[0];
		$post_img['post_status'] = 'attachment';
		$post_img['post_parent'] = $last_postid;
		$post_img['post_type'] = 'attachment';
		$post_img['post_mime_type'] = 'image/jpeg';
		$post_img['menu_order'] = $menu_order;
		$last_postimage_id = wp_insert_post( $post_img );
		update_post_meta($last_postimage_id, '_wp_attached_file', $gallery_image[$m]);					
		$post_attach_arr = array(
							"width"	=>	580,
							"height" =>	480,
							"hwstring_small"=> "height='150' width='150'",
							"file"	=> $gallery_image[$m],
							);
		wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
	}
}
$page_ids = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title in ('Hotel Front View') and post_type='page'");
$last_postid = $page_ids;
update_post_meta($page_ids,'_wp_page_template','page-gallery.php');
$gallery_image = array('dummy/hotel1.jpg','dummy/hotel2.jpg','dummy/hotel3.jpg','dummy/hotel_in1.jpg','dummy/hotel_in2.jpg','dummy/hotel_in10.jpg','dummy/hotel_in11.jpg','dummy/hotel_in12.jpg','dummy/hotel_in13.jpg','dummy/hotel_in14.jpg','dummy/hotel_in15.jpg','dummy/hotel_in15.jpg');
if($last_postid && $gallery_image)
{
	for($m=0;$m<count($gallery_image);$m++)
	{
		$menu_order = $m+1;
		$image_name_arr = explode('/',$gallery_image[$m]);
		$img_name = $image_name_arr[count($image_name_arr)-1];
		$img_name_arr = explode('.',$img_name);
		$post_img = array();
		$post_img['post_title'] = $img_name_arr[0];
		$post_img['post_status'] = 'attachment';
		$post_img['post_parent'] = $last_postid;
		$post_img['post_type'] = 'attachment';
		$post_img['post_mime_type'] = 'image/jpeg';
		$post_img['menu_order'] = $menu_order;
		$last_postimage_id = wp_insert_post( $post_img );
		update_post_meta($last_postimage_id, '_wp_attached_file', $gallery_image[$m]);					
		$post_attach_arr = array(
							"width"	=>	580,
							"height" =>	480,
							"hwstring_small"=> "height='150' width='150'",
							"file"	=> $gallery_image[$m],
							);
		wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
	}
}
$page_ids = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title in ('Hotel Other Photos') and post_type='page'");
$last_postid = $page_ids;
update_post_meta($page_ids,'_wp_page_template','page-gallery.php');
$gallery_image = array('dummy/hotel_in6.jpg','dummy/hotel_in7.jpg','dummy/hotel_in8.jpg','dummy/hotel_in9.jpg','dummy/hotel_in10.jpg','dummy/hotel_in11.jpg','dummy/hotel_in12.jpg','dummy/hotel_in13.jpg','dummy/hotel_in14.jpg');
if($last_postid && $gallery_image)
{
	for($m=0;$m<count($gallery_image);$m++)
	{
		$menu_order = $m+1;
		$image_name_arr = explode('/',$gallery_image[$m]);
		$img_name = $image_name_arr[count($image_name_arr)-1];
		$img_name_arr = explode('.',$img_name);
		$post_img = array();
		$post_img['post_title'] = $img_name_arr[0];
		$post_img['post_status'] = 'attachment';
		$post_img['post_parent'] = $last_postid;
		$post_img['post_type'] = 'attachment';
		$post_img['post_mime_type'] = 'image/jpeg';
		$post_img['menu_order'] = $menu_order;
		$last_postimage_id = wp_insert_post( $post_img );
		update_post_meta($last_postimage_id, '_wp_attached_file', $gallery_image[$m]);					
		$post_attach_arr = array(
							"width"	=>	580,
							"height" =>	480,
							"hwstring_small"=> "height='150' width='150'",
							"file"	=> $gallery_image[$m],
							);
		wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
	}
}

$page_ids = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title in ('Contact Us') and post_type='page'");
update_post_meta($page_ids,'_wp_page_template','page_contact.php');

/////////////// Design Settings END ///////////////
/////////////// WIDGET SETTINGS START ///////////////
$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
$reservation = array();
$reservation[1] = array(
					"title"				=>	'',
					"t1"				=>	'Need a Reservation?',
					"t2"				=>	'Lorem ipsum dolor sit amet, consectetuer elit. Praesent aliquam,  justo convallisu.',
					"t3"				=>	'http://www.templatic.com',
					"t4"				=>	'Special Offers',
					"t5"				=>	'Lorem ipsum dolor sit amet, consectetuer elit. Praesent aliquam,  justo convallisu.',
					"t6"				=>	'Read More',
					);
$reservation['_multiwidget'] = '1';
update_option('widget_widget_reservation',$reservation);
$reservation = get_option('widget_widget_reservation');
krsort($reservation);
foreach($reservation as $key1=>$val1)
{
	$reservation_key = $key1;
	if(is_int($reservation_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-1"] = array('widget_reservation-'.$reservation_key);

$news_cat_id = $wpdb->get_var("SELECT group_concat(term_id) FROM $wpdb->terms where name in ('Blog')");
$latest = array();
$latest[1] = array(
					"title"				=>	'Latest News',
					"category"			=>	$news_cat_id,
					"post_number"		=>	'5',
					"more_link"			=>	'http://templatic.com',
					);
$latest['_multiwidget'] = '1';
update_option('widget_widget_posts',$latest);
$latest = get_option('widget_widget_posts');
krsort($latest);
foreach($latest as $key1=>$val1)
{
	$latest_key = $key1;
	if(is_int($latest_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-2"] = array('widget_posts-'.$latest_key);

$download = array();
$download [1] = array(
					"title"				=>	'Download Brochure',
					"t1"				=>	'http://templatic.com',
					"t2"				=>	'Lorem ipsum dolor sit amet, consectetuer elit. Praesent aliquam',
					);
$download ['_multiwidget'] = '1';
update_option('widget_widget_downloadwidget',$download );
$download  = get_option('widget_widget_downloadwidget');
krsort($download );
foreach($download  as $key1=>$val1)
{
	$download_key = $key1;
	if(is_int($download_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-3"] = array('widget_downloadwidget-'.$download_key);

$subscribe = array();
$subscribe = array(
					"title"				=>	'',
					"id"				=>	'templatic/eKPs',
					"text"				=>	'If you&acute;d like to stay updated with all our latest news please enter your e-mail address here',
					);

update_option('widget_subscribewidget',$subscribe );
$sidebars_widgets["sidebar-4"] = array('pt-subscribe');

$blockquote = array();
$blockquote[1] = array(
					"title"				=>	'Testimonials',
					"quote1"			=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam,',
					"author1"			=>	'Roma',
					"quote2"			=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam,',
					"author2"			=>	'Robbin',
					"quote3"			=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam,',
					"author3"			=>	'John',
					"quote4"			=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam,',
					"author4"			=>	'Stiven',
					"quote5"			=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam,',
					"author5"			=>	'Smith',
					"more"			=>	'',
					);
$blockquote ['_multiwidget'] = '1';
update_option('widget_widget_blockquote',$blockquote );
$blockquote  = get_option('widget_widget_blockquote');
krsort($blockquote);
foreach($blockquote  as $key1=>$val1)
{
	$blockquote_key = $key1;
	if(is_int($blockquote_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-5"] = array('widget_blockquote-'.$blockquote_key);

$news_cat_id = $wpdb->get_var("SELECT group_concat(term_id) FROM $wpdb->terms where name in ('Blog')");
$latest = array();
$latest = get_option('widget_widget_posts');
$latest[] = array(
					"title"				=>	'Latest News',
					"category"			=>	$news_cat_id,
					"post_number"		=>	'5',
					"more_link"			=>	'http://templatic.com',
					);
$latest['_multiwidget'] = '1';
update_option('widget_widget_posts',$latest);
$latest = get_option('widget_widget_posts');
krsort($latest);
foreach($latest as $key1=>$val1)
{
	$latest_key = $key1;
	if(is_int($latest_key))
	{
		break;
	}
}

$specialoffer = array();
$specialoffer[1] = array(
					"title"				=>	'Special Offers',
					"desc1"				=>	'<a href="#" ><img src="'.$dummy_image_path.'banner_specialoffer.png" alt="" /></a><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum. </p><p><a href="#" >Read More</a></p>',
					);
$specialoffer['_multiwidget'] = '1';
update_option('widget_widgetspecialoffer_widget',$specialoffer);
$specialoffer = get_option('widget_widgetspecialoffer_widget');
krsort($specialoffer);
foreach($specialoffer as $key1=>$val1)
{
	$specialoffer_key = $key1;
	if(is_int($specialoffer_key))
	{
		break;
	}
}

$adv = array();
$adv[1] = array(
					"title"				=>	'',
					"desc1"				=>	'<a href="#" ><img src="'.$dummy_image_path.'banner.png" alt="" /></a>',
					);
$adv['_multiwidget'] = '1';
update_option('widget_widgetsidebar_advt_widget',$adv);
$adv = get_option('widget_widgetsidebar_advt_widget');
krsort($adv);
foreach($adv as $key1=>$val1)
{
	$adv_key = $key1;
	if(is_int($adv_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-6"] = array('widget_posts-'.$latest_key,'widgetspecialoffer_widget-'.$specialoffer_key,'widgetsidebar_advt_widget-'.$adv_key);
//////////////////////////////////////////////////////
update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
/////////////// WIDGET SETTINGS END ///////////////
global $upload_folder_path;
full_copy( TEMPLATEPATH."/images/dummy/", ABSPATH . $upload_folder_path."dummy/" );
function full_copy( $source, $target ) 
{
	global $upload_folder_path;
	$imagepatharr = explode('/',$upload_folder_path."dummy");
	$year_path = ABSPATH;
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i])
	  {
		  $year_path .= $imagepatharr[$i]."/";
		  //echo "<br>";
		  if (!file_exists($year_path)){
			  mkdir($year_path, 0777);
		  }     
		}
	}
	@mkdir( $target );
		$d = dir( $source );
		
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		copy( $source, $target );
	}
}
?>