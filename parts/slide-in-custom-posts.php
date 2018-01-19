<?php



function add_admin_scripts( $hook ) {

    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( CASESTUDYPOSTTYPE === $post->post_type ) {     
            // wp_enqueue_script(  'myscript', get_stylesheet_directory_uri().'/js/myscript.js' );
            tz_slideshow_load_admin_scripts();
        }
    }
}
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );


/**
 * Adds a metabox to the right side of the screen under the â€œPublishâ€ box
 */
function wpt_add_event_metaboxes() {
	add_meta_box(
		'wpt_events_location',
		'Event Location',
		'wpt_events_location',
		CASESTUDYPOSTTYPE,
		'advanced', 
		'default'
	);
}
add_action( 'add_meta_boxes', 'wpt_add_event_metaboxes' );

/**
 * Output the HTML for the metabox.
 */
function wpt_events_location() {
	global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'event_fields' );
	// Get the location data if it's already been entered
	$location = get_post_meta( $post->ID, 'location', true );
	
	if($location == ''){
		$location = '{"settings": {"width":"contained", "show_captions":true}, "slides":[{"image_id":734, "caption":"Slide One"},{"image_id":735, "caption":"Slide Two"}]}'; 

	}
	// Output the field
	?>

		<!-- <input type="text" name="location" value="<?php esc_textarea( $location ); ?>" class="widefat"> -->
	 		<!-- slideshow-id="nwbt_tz_setting[nwbt_tz_textarea_field_0]" -->
	 	<h2>Configure Slides here</h2>
		<section ng-app="SnowboticaSlidesConfig">
	 		<tz-edit-slideshow 
	 		slideshow-name="location"
	 		slideshow-value='<?php  echo $location; ?>'
	 	></tz-edit-slideshow>
		<!-- <section ng-app="SnowboticaSlidesConfig"> -->
	 		<!-- <tz-edit-slideshow  -->
	 		<!-- slideshow-name="nwbt_tz_setting[nwbt_tz_textarea_field_0]" -->
	 		<!-- slideshow-id="nwbt_tz_setting[nwbt_tz_textarea_field_0]" -->
	 		<!-- // slideshow-value='<?php echo $options['nwbt_tz_textarea_field_0'];?>' -->
	 	<!-- ></tz-edit-slideshow> -->
	 	</section>
	<?php
}

/**
 * Save the metabox data
 */
function wpt_save_events_meta( $post_id, $post ) {
	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if ( ! isset( $_POST['location'] ) || ! wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}
	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $events_meta.
	// $events_meta['location'] = esc_textarea( $_POST['location'] );
	$events_meta['location'] = $_POST['location'] ;
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
add_action( 'save_post', 'wpt_save_events_meta', 1, 2 );