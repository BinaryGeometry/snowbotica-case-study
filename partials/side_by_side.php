<div class="row">
  	<div class="medium-5 large-6 columns">
	  	<section class="gallery-slideshow">
			<div class="make-this-slide top">
				<?php foreach ($slides as $key => $slide):?>
					<div style="text-align:center;width:100%;">
						<div class="slide image-slide mobile-preview-slide" data-index="0">
							<div class="style-wrapper">
								<img style="padding: inherit;margin:auto;" src="<?php echo $slide['image_url']; ?>" alt="<?php echo $slide['content']; ?>"/>
								<?php //echo wp_get_attachment_image( $slide['image_id'], 'full' );?>
								<h6><?php echo $slide['content']; ?></h6>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
 		</section>
  	</div>
	<div class="medium-7 large-6  columns">
		<article class="service-info background:#c6c6cf">
			
			<?php if($data["show_page_title"]):?>
			<h2><?php the_title();?></h2>
			<?php endif;?>
			
			<?php if($data["show_lead_content"]):?>
			<div class="case-study-description">
				<?php the_content();?>
			</div>					
			<?php endif;?>
			
			<?php if (get_post_meta( get_the_ID(), 'location', true ) ) : ?>
			<div class="make-this-slide sub">
				<?php foreach ($slides as $key => $slide):?>
				<div class="slide image-slide description-slide" data-index="<?php echo $key;?>">
					<div class="style-wrapper">
						<!-- <p><?php var_dump($slide[0]); ?></p> -->
						<!-- <p><?php //echo $slide['caption']; ?></p> -->
					</div>
				</div>
				<?php endforeach;?>
			</div>
			<?php endif; ?>
	
		</article>
	</div>
</div>