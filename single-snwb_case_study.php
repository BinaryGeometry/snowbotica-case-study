<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php //get_template_part( 'template-parts/featured-image' ); ?>

<!-- <section class="contains-2 snowbotica-case-study"> -->

<section class="snowbotica-case-study container">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php 
	$sliderMetaJSON = get_post_meta( get_the_ID(), 'location', true ); 
	// $sliderMetaJSON = preg_replace('/\s+/', '',$sliderMetaJSON);
	// $sliderMetaJSON = stripslashes(str_replace('\"', '"', $sliderMetaJSON));
	/* continue with ui prototyping */
	$sliderMeta = json_decode($sliderMetaJSON, true);
	// var_dump($sliderMeta['slides']);
	$slides = $sliderMeta['slides'];
	?>
	<div class="row">
	  	<div class="medium-5 large-6 columns">
		  	<section class="gallery-slideshow">
				<div class="make-this-slide top">
					<?php foreach ($slides as $key => $slide):?>
						<?php //$image = wp_get_attachment_image_src( $slide['image_id'] );?>
						<?php //var_dump($image[0]);?>
						<?php //$alt_text = get_post_meta($slide['image_id'], '_wp_attachment_image_alt', true);?>
						<?php //$alt_text = get_post_meta($slide['image_id'], '_wp_attachment_image_title', true);?>
						<?php //var_dump($alt_text);?>
						<!-- echo $slide['image_id']; -->
						<div class="slide image-slide mobile-preview-slide" data-index="0">
							<div class="style-wrapper">
								<?php echo wp_get_attachment_image( $slide['image_id'], 'full' );?>
								<!-- <img src="http://bin.geo/wp-content/uploads/2018/01/accordian-open-two.jpg" alt="" width="379" height="670" class="alignnone size-full wp-image-89" /> -->
								<!-- <p>The off canvas system uses javascript and css tranisitions to animate in context panels from either side of the browser screen.</p> -->
							</div>
						</div>
					<?php endforeach; ?>
				</div>
	 		</section>
	  	</div>
		<div class="medium-7 large-6  columns">
				<article class="service-info background:#c6c6cf">
					<h2><?php the_title();?></h2>
					<div class="case-study-description">
						<?php the_content();?>
					</div>					
					<?php if (get_post_meta( get_the_ID(), 'location', true ) ) : ?>
					<div class="make-this-slide sub">
						<?php foreach ($slides as $key => $slide):?>
						<div class="slide image-slide description-slide" data-index="<?php echo $key;?>">
							<div class="style-wrapper">
								<p><?php echo $slide['caption']; ?></p>
							</div>
						</div>
						<?php endforeach;?>
					</div>
					<?php endif; ?>
				</article>
		</div>
	</div>
	<?php endwhile;?>
</section>
<?php get_footer();