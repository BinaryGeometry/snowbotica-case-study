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
	<div class="row">
	  	<div class="medium-5 large-6 columns">
		  	<section class="gallery-slideshow">
		  		<?php /*
            	<div class="row case-study-masonry" data-masonry-options='{ "itemSelector": ".item" }'>
				<?php $slides = get_field('case_study_gallery');?>
	        	<?php foreach ( $slides as $key => $value) :?>
	           		 <div class="large-6 small-6 columns item">
	           		 	<article class="gallery-image">
	           		 		<?php $image_id = $slides[$key]['gallery_image']['id'];?>
	           		 		<?php echo wp_get_attachment_image( $image_id, 'service' );?>
	           		 		<?php /*
	           		 		<!-- <img src="<?= $slides[$key]['gallery_image']['url'];?>" alt="<?= $slides[$key]['gallery_image']['alt'];?>" /> -->
	           		 	</article>
	           		 </div>
	        	<?php endforeach;?>
            	</div>
	           	*/ ?>
				<div class="make-this-slide top">
					<div class="slide image-slide mobile-preview-slide" data-index="0">
						<div class="style-wrapper">
							<img src="http://bin.geo/wp-content/uploads/2018/01/accordian-open-two.jpg" alt="" width="379" height="670" class="alignnone size-full wp-image-89" />
							<!-- <p>The off canvas system uses javascript and css tranisitions to animate in context panels from either side of the browser screen.</p> -->
						</div>
					</div>
					<div class="slide image-slide mobile-preview-slide" data-index="1">
						<div class="style-wrapper">
							<img src="http://bin.geo/wp-content/uploads/2018/01/accordian-open-two-two.jpg" alt="" width="379" height="670" class="alignnone size-full wp-image-90" />
							<!-- <p>The accordian menu which allows double nesting of categories has a suite of qunit functional tests to ensure new behaviours do not break existing functionality. </p> -->
						</div>
					</div>
					<div class="slide image-slide mobile-preview-slide" data-index="2">
						<div class="style-wrapper">
							<img src="http://bin.geo/wp-content/uploads/2018/01/off-canvas-cart.jpg" alt="" width="379" height="670" class="alignnone size-full wp-image-91" />	 	
							<!-- <p>The off canvas cart utilises plugin.xml to place the mini-cart html into the finished widget.</p>    -->
						</div>
					</div>
				</div>
	 		</section>
	  	</div>
		<div class="medium-7 large-6  columns">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="service-info background:#c6c6cf">
					<h2><?php the_title();?></h2>
					<div class="case-study-description">
						<?php the_content();?>
					</div>
					<?php 
					$sliderMetaJSON = get_post_meta( get_the_ID(), 'location', true ); 
					// $sliderMetaJSON = preg_replace('/\s+/', '',$sliderMetaJSON);
					// var_dump($sliderMetaJSON);

// json_decode($k)
					$sliderMeta = json_decode(stripslashes($sliderMetaJSON), true);
					var_dump($sliderMeta);


					$image_attributes = wp_get_attachment_image_src( $attachment_id = 8 );
if ( $image_attributes ) : ?>
    <img src="<?php echo $image_attributes[0]; ?>" width="<?php echo $image_attributes[1]; ?>" height="<?php echo $image_attributes[2]; ?>" />
<?php endif; ?>

					
						<h2>go</h2>
					<?php if (get_post_meta( get_the_ID(), 'location', true ) ) : ?>
					<?php endif; ?>
					<div class="make-this-slide sub">
						<div class="slide image-slide description-slide" data-index="0">
							<div class="style-wrapper">
								<p>The off canvas system uses javascript and css tranisitions to animate in context panels from either side of the browser screen.</p>
							</div>
						</div>
						<div class="slide image-slide description-slide" data-index="1">
							<div class="style-wrapper">
								<p>The accordian menu which allows double nesting of categories has a suite of qunit functional tests to ensure new behaviours do not break existing functionality. </p>
							</div>
						</div>
						<div class="slide image-slide description-slide" data-index="2">
							<div class="style-wrapper">
								<p>The off canvas cart utilises plugin.xml to place the mini-cart html into the finished widget.</p>   
							</div>
						</div>
					</div>
				</article>
			<?php endwhile;?>
		</div>
	</div>
</section>
<?php get_footer();