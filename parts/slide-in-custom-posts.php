<?php


/**
 * Adds a metabox to the right side of the screen under the â€œPublishâ€ box
 */
function snowboticaCaseStudy_add_event_metaboxes() {
	add_meta_box(
		'snowboticaCaseStudy_slides_meta',
		'Case Study Slideshow',
		'snowboticaCaseStudy_slides_meta',
		CASESTUDYPOSTTYPE,
		'advanced', 
		'default'
	);
}
add_action( 'add_meta_boxes', 'snowboticaCaseStudy_add_event_metaboxes' );

/**
 * Output the HTML for the metabox.
 */
function snowboticaCaseStudy_slides_meta() {
	global $post;
	global $wpdb;

	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'snowboticaCaseStudy_fields' );
	// Get the location data if it's already been entered
	$location = get_post_meta( $post->ID, 'location', true );

	if(0 === strlen($location)){
		$location = '{slides:[]}';
	}

	// $sql = $wpdb->prepare("SELECT 
	// id,
	// REPLACE(REPLACE(guid, 'https://bin.geo', ''), 'http://bin.geo', '') AS url,
	// post_title AS alt
	// FROM `wp_posts` wp 
	// WHERE wp.post_type = 'attachment' 
	// AND wp.post_mime_type LIKE %s", '%image');

	$availableImages = $wpdb->get_results( // phpcs:ignore WordPress.DB.DirectDatabaseQuery 
		$wpdb->prepare("SELECT 
		id,
		REPLACE(REPLACE(guid, 'https://bin.geo', ''), 'http://bin.geo', '') AS url,
		post_title AS alt
		FROM `wp_posts` wp 
		WHERE wp.post_type = 'attachment'
		AND wp.post_mime_type LIKE %s", '%image%')
	); 
	$availableImagesJSON = wp_json_encode($availableImages, true);
	$wpdb->flush();
	// <input type="text" name="location" value="<?php esc_textarea( $location ); ? >" class="widefat">
	?>
	<?php  //echo $location; ?>

	 	<h2>Configure Slides here</h2>
		<section ng-app="SnowboticaCaseStudySlidesConfig">
	 		<tz-edit-slideshow 
	 		slideshow-name="location"
			slideshow-options='<?php echo esc_attr($availableImagesJSON); ?>'
	 		slideshow-value='<?php echo esc_attr($location); ?>'
	 		></tz-edit-slideshow>
		</section>
		<?php  //echo $location; ?>
		<?php
		// <!-- slideshow-name="nwbt_tz_setting[nwbt_tz_textarea_field_0]" -->
}

/**
 * Save the metabox data
 */
function snowboticaCaseStudy_save_slides_meta( $post_id, $post ) {
	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	// $fieldNonceField = $_POST['snowboticaCaseStudy_fields'];
	if ( ! isset( $_POST['location'] ) ) {
		return $post_id;
	}
	
	// if ( ! wp_verify_nonce(  wp_unslash(sanitize_text_field($_POST['snowboticaCaseStudy_fields'])), basename(__FILE__) ) ) {
	if ( isset($_POST['snowboticaCaseStudy_fields']) && ! wp_verify_nonce(  wp_unslash(sanitize_key($_POST['snowboticaCaseStudy_fields'])), basename(__FILE__) ) ) {
		return $post_id;
	}
	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $events_meta.
	// $events_meta['location'] = esc_textarea( $_POST['location'] );
	$events_meta['location'] = wp_kses_post(wp_unslash($_POST['location'])) ; // https://wordpress.stackexchange.com/questions/53336/wordpress-is-stripping-escape-backslashes-from-json-strings-in-post-meta
	// $mysqli->set_charset("utf8");
	// Cycle through the $events_meta array.
	// Note, in this example we just have one item, but this is helpful if you have multiple.
	foreach ( $events_meta as $key => $value ) :
		// Don't store custom data twice
		if ( 'revision' === $post->post_type ) {
			return;
		}
		if ( get_post_meta( $post_id, $key, false ) ) {
			// If the custom field already has a value, update it.
			update_post_meta( $post_id, $key, $value );
		} else {
			// If the custom field doesn't have a value, add it.
			add_post_meta( $post_id, $key, $value);
		}
		if ( ! $value ) {
			// Delete the meta key if there's no value
			delete_post_meta( $post_id, $key );
		}
	endforeach;
}
add_action( 'save_post', 'snowboticaCaseStudy_save_slides_meta', 1, 2 );