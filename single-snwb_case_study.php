<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<section class="snowbotica-case-study container">
		<?php 
		$sliderMetaJSON = get_post_meta(get_the_ID() , 'location', true ); 
		$sliderMeta = json_decode($sliderMetaJSON, true);
		$slides = $sliderMeta['slides'];

		
		$data = [
			"views" => [
				[
					"name" => "gallery_with_text",
					"text" => "Gallery with Text",
					"preview" => SNOWBOTICASLIDES_URL."/application/dashboard/assets/nowbotica-logo.png"
				],[
					"name" =>"thumbnail_list_with_images", 
					"text" => "Thumbnail list with Images",
					"preview" => SNOWBOTICASLIDES_URL."/application/dashboard/assets/oneofthose-logo.png"
				],[
					"name" => "small_thumbnail_gallery",
					"text" => "Small Thumbnail Gallery", 
					"preview" => SNOWBOTICASLIDES_URL."/application/dashboard/assets/snwb-logo.png"
				],[
					"name" => "masonry",
					"text" => "Masonry",
					"preview" => SNOWBOTICASLIDES_URL."/application/dashboard/assets/oneofthose-logo.png"
				
				],[
					"name" =>"grid", 
					"text" => "Grid",
					"preview" => SNOWBOTICASLIDES_URL."/application/dashboard/assets/nowbotica-logo.png"
				],[
					"name" =>"side_by_side", 
					"text" => "Side By Side",
					"preview" => SNOWBOTICASLIDES_URL."/application/dashboard/assets/snwb-logo.png"
				],[
					"name" =>"slideshow", 
					"text" => "Slideshow",
					"preview" => SNOWBOTICASLIDES_URL."/application/dashboard/assets/nowbotica-logo.png"
				]
			],
			"displayType" => "side_by_side",
			"paginate" => true,
			"show_page_title" => true,
			"show_lead_content" => true,
			"outgoing_links" => false,
			"python" => "https://defn.io/2018/02/25/web-app-from-scratch-01/",
			"default_style" => "outer-boxes",
			"slides" => [
				[
				"uid"       => 1,
				"name"      => "slide_one",   
				"image_url" => "/wp-content/uploads/2018/01/jamesdunbarphotography-home-page-169x300.png",
				"image_id"  => "1",
				"content"   => "<p>Some&nbsp;<b>Content One</b></p>",
				"title"     => "Title One",
				"active"    => true,
				"style"     => "A",
				"link"		=> "https://p.s"
				],[
				"uid"       => 2,
				"name"      => "slide_two",   
				"image_id"  => "2",
				"image_url" => "/wp-content/uploads/2018/01/jamesdunbarphotography-home-page-169x300.png",
				"content"   => "<p>Some&nbsp;<b>Content Two</b></p>",
				"title"     => "Title Two", 
				"active"    => true,  
				"style"     => "B",
				"link"		=> "https://p.s"
				],[
				"uid"       => 3,
				"name"      => "slide_three",   
				"image_id"  => "3",
				"image_url" => "/wp-content/uploads/2018/01/jamesdunbarphotography-home-page-169x300.png",
				"content"   => "<p>Some&nbsp;<b>Content Three</b></p>",
				"title"     => "Title Three", 
				"active"    => true,  
				"style"     => "B",
				"link"		=> "https://p.s"
				],[
				"uid"       => 4,
				"name"      => "slide_four",   
				"image_id"  => "4",
				"image_url" => "/wp-content/uploads/2018/01/jamesdunbarphotography-home-page-169x300.png",
				"content"   => "<p>Some&nbsp;<b>Content Four</b></p>",
				"title"     => "Title Four", 
				"active"    => true,  
				"style"     => "A",
				"link"		=> "https://p.s"
				]
			]
		];
		// $slides = $data["slides"];
		// $displayType = $data["displayType"];
		// side_by_side echo $data['displayType'];
		// switch ($data["displayType"]) {

		// 	case "gallery_with_text":	
		// 		include_once(SNOWBOTICASLIDES.'/partials/gallery_with_text.php');
		// 		echo $data["views"][$displayType];
		// 		break;
		// 	case "small_thumbnail_gallery":
		// 		include_once(SNOWBOTICASLIDES.'/partials/small_thumbnail_gallery.php');
		// 		echo $data["views"][$displayType];
		// 		break;
		// 	case "thumbnail_list_with_images":
		// 		include_once(SNOWBOTICASLIDES.'/partials/thumbnail_list_with_images.php');
		// 		echo $data["views"][$displayType];
		// 		break;
		// 	case "masonry":
		// 		include_once(SNOWBOTICASLIDES.'/partials/masonry.php');
		// 		echo $data["views"][$displayType];
		// 		break;
		// 	case "grid":
		// 		include_once(SNOWBOTICASLIDES.'/partials/grid.php');
		// 		echo $data["views"][$displayType];
		// 		break;
		// 	case "side_by_side":
				include_once(SNOWBOTICASLIDES.'/partials/side_by_side.php');
		// 		break;
		// 	case "slideshow":
		// 		include_once(SNOWBOTICASLIDES.'/partials/slideshow.php');
		// 		echo $data["views"][$displayType];
		// 		# code...
		// 		break;
		// 	default:
		// 		# code...
		// 		echo 'something seems to be wrong';
		// 		break;
		// }
		?>

		<?php 
		$posts = get_posts(array(
			'post_type' => CASESTUDYPOSTTYPE,
			'post_status' => 'publish',
			'posts_per_page' => 4,
			'post__not_in' => array(get_the_ID()),
		));
		?>

	</section>
	<section class="snowbotica-case-study container" style="background:#b4bfba;">

		<div class="row">
			<?php foreach($posts as $key => $post): ?>
  				<div class="medium-3 small-6 columns">
					<a href="<?php echo esc_url(get_permalink( $post->ID )); ?>">

						<div style="max-height:160px; overflow:hidden;">
							<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
							<img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr($post->post_title); ?>">
						</div>
						
						<h4 style="text-transform: uppercase;
						text-align: center;
						margin-top:10px;font-size: 12px;color:#282828;"
						><?php echo esc_html($post->post_title); ?></h4>
					</a>
				</div>			
			<?php endforeach; ?>
		</div>

	</section>
<?php endwhile;?>
<?php get_footer();?>