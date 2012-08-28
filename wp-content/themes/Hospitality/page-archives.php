<?php	 	 
/*
Template Name: Archives Page
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
                
 
    <div id="post-<?php	 	  the_ID(); ?>" class="posts bnone" >
      <div class="arclist box">
        <ul>
          <?php	 	  query_posts('showposts=60'); ?>
          <?php	 	  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <li>
            <div class="archives-time">
              <?php	 	  the_time('M j Y') ?>
            </div>
            <a href="<?php	 	  the_permalink() ?>">
            <?php	 	  the_title(); ?>
            </a> - <?php	 	  echo $post->comment_count ?> </li>
          <?php	 	  endwhile; endif; ?>
        </ul>
      </div>
      <!--/arclist -->
    </div>
    <!--/post -->
   </div> <!-- content #end -->
        
        
		<?php	 	  get_sidebar(); ?>
		
        
   </div> <!-- innerbg #end -->

<?php	 	  get_footer(); ?>