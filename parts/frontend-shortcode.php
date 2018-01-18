<?php

/**
  * Creates shortcode to display main application
  *
  */
function nwbtSlideshow(  ) {

	$options = get_option( 'nwbt_tz_setting' );
  	$s = json_decode($options['nwbt_tz_textarea_field_0']);
  	$settings = $s->settings;
  	$slides = $s->slides;
  	?>
  	<?php if($settings->width == 'contained'):?><div class="container"><?php endif; ?>
		<?php if($slides):?>
        <div class="slick-banner">
			<?php foreach ($slides as $key => $value): ?>
	            <article class="slick-banner-slide">
	                <div class="wrap">
	                	<!-- data-lazy=" -->
	             		<?php echo wp_get_attachment_image( $slides[$key]->image_id , 'full'); ?>
					 	<h2><?= $slides[$key]->caption; ?></h2>
	                </div>
	            </article>
			<?php endforeach ?>
        </div>
        <?php endif; ?>
	<?php if($settings->width == 'contained'):?></div><?php endif; ?>
    <!-- <ui-view autoscroll="false" ng-if='!isRouteLoading'></ui-view> -->
  <?php
}
add_shortcode('nwbtSlideshow', 'nwbtSlideshow');