<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<section class="snowbotica-case-study container">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php 
	$slides = $data["slides"];
	$displayType = $data["displayType"];
	// side_by_side echo $data['displayType'];
	switch ($data["displayType"]) {

		case "gallery_with_text":	
			include_once(SNOWBOTICASLIDES.'/partials/gallery_with_text.php');
			echo $data["views"][$displayType];
			break;
		case "small_thumbnail_gallery":
			include_once(SNOWBOTICASLIDES.'/partials/small_thumbnail_gallery.php');
			echo $data["views"][$displayType];
			break;
		case "thumbnail_list_with_images":
			include_once(SNOWBOTICASLIDES.'/partials/thumbnail_list_with_images.php');
			echo $data["views"][$displayType];
			break;
		case "masonry":
			include_once(SNOWBOTICASLIDES.'/partials/masonry.php');
			echo $data["views"][$displayType];
			break;
		case "grid":
			include_once(SNOWBOTICASLIDES.'/partials/grid.php');
			echo $data["views"][$displayType];
			break;
		case "side_by_side":
			include_once(SNOWBOTICASLIDES.'/partials/side_by_side.php');
			break;
		case "slideshow":
			include_once(SNOWBOTICASLIDES.'/partials/slideshow.php');
			echo $data["views"][$displayType];
			# code...
			break;
		default:
			# code...
			echo 'something seems to be wrong';
			break;
	}
	?>
	
	<?php endwhile;?>
</section>
<?php get_footer();