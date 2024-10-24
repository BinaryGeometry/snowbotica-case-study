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
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'snowboticaCaseStudy_fields' );
	// Get the location data if it's already been entered
	$location = get_post_meta( $post->ID, 'location', true );

		// $location = '{
		// 	"settings": {
		// 		"width":"contained", 
		// 		"show_captions":true
		// 	}, 
		// 	"slides":[
		// 		{"image_id":734, "caption":"Slide One"},
		// 		{"image_id":735, "caption":"Slide Two"}
		// 	]
		// }'; 	

	// $simpleAsItGets = 'word';
	// $event = 'life';
	// <input 
	// name="< ?= $simpleAsItGets;? >"
	// id="< ?= $simpleAsItGets;? >">
	// $('<?= $simpleAsItGets; ? >).on($event, spaceMind);
	// function spaceMind(){}


	// if($location == ''){
		// $location = '{
		// 	"view_map" : {
		// 		"gallery_with_text" : "Gallery with Text",
		// 		"thumbnail_list_with_images" : "Thumbnail list with Images",
		// 		"small_thumbnail_gallery" : "Small Thumbnail Gallery", 
		// 		"masonry" : "Masonry",
		// 		"grid" : "Grid",
		// 		"side_by_side" : "Side By Side",
		// 		"slideshow" : "Slideshow"
		// 	},
			
		// 	"views" : [
		// 		{
		// 			"name" : "gallery_with_text",          
		// 			"label": "Gallery with Text",
		// 			"preview" : "/wp-content/plugins/snowbotica-case-study/application/dashboard/assets/nowbotica-logo.png",
		// 		},
		// 		{
		// 			"name" : "thumbnail_list_with_images", 
		// 			"label": "Thumbnail list with Images",
		// 			"preview" : "/wp-content/plugins/snowbotica-case-study/application/dashboard/assets/nowbotica-logo.png",
		// 		},
		// 		{
		// 			"name" : "small_thumbnail_gallery",    
		// 			"label": "Small Thumbnail Gallery",
		// 			"preview" : "/wp-content/plugins/snowbotica-case-study/application/dashboard/assets/nowbotica-logo.png",
		// 		}, 
		// 		{
		// 			"name" : "masonry",                    
		// 			"label": "Masonry",
		// 			"preview" : "/wp-content/plugins/snowbotica-case-study/application/dashboard/assets/nowbotica-logo.png",
		// 		},
		// 		{
		// 			"name" : "grid",                       
		// 			"label" : "Grid",
		// 			"preview" : "/wp-content/plugins/snowbotica-case-study/application/dashboard/assets/nowbotica-logo.png",
		// 		},
		// 		{
		// 			"name" : "side_by_side", 				
		// 			"label" : "Side By Side",
		// 			"preview" : "/wp-content/plugins/snowbotica-case-study/application/dashboard/assets/nowbotica-logo.png",
		// 		},
		// 		{
		// 			"name" : "slideshow", 					
		// 			"label" : "Slideshow",
		// 			"preview" : "/wp-content/plugins/snowbotica-case-study/application/dashboard/assets/nowbotica-logo.png"
		// 		}
		// 	],
		// 	"displayType" : "side_by_side",
		// 	"paginate" : true,
		// 	"show_page_title" : true,
		// 	"show_lead_content" : true,
		// 	"outgoing_links" : false,
		// 	"default_style" : "outer-boxes",
		// 	"slides" : [
		// 		{
		// 		"uid"       : 1,
		// 		"name"      : "slide_one",   
		// 		"image_url" : "https://cdn.nowbotica/insect/300/400",
		// 		"image_id"  : "1",
		// 		"content"   : "<p>Some&nbsp;<b>Content One</b></p>",
		// 		"title"     : "Title One",
		// 		"active"    : true,
		// 		"style"     : "A",
		// 		"link"		: "https://p.s"
		// 		},{
		// 		"uid"       : 2,
		// 		"name"      : "slide_two",   
		// 		"image_id"  : "2",
		// 		"image_url" : "https://cdn.nowbotica/insect/300/400",
		// 		"content"   : "<p>Some&nbsp;<b>Content Two</b></p>",
		// 		"title"     : "Title Two", 
		// 		"active"    : true,  
		// 		"style"     : "B",
		// 		"link"		: "https://p.s"
		// 		},{
		// 		"uid"       : 3,
		// 		"name"      : "slide_three",   
		// 		"image_id"  : "3",
		// 		"image_url" : "https://cdn.nowbotica/insect/300/400",
		// 		"content"   : "<p>Some&nbsp;<b>Content Three</b></p>",
		// 		"title"     : "Title Three", 
		// 		"active"    : true,  
		// 		"style"     : "B",
		// 		"link"		: "https://p.s"
		// 		},{
		// 		"uid"       : 4,
		// 		"name"      : "slide_four",   
		// 		"image_id"  : "4",
		// 		"image_url" : "https://cdn.nowbotica/insect/300/400",
		// 		"content"   : "<p>Some&nbsp;<b>Content Four</b></p>",
		// 		"title"     : "Title Four", 
		// 		"active"    : true,  
		// 		"style"     : "A",
		// 		"link"		: "https://p.s"
		// 		}
		// 	]
		// }';
	// }
	// Output the field
	// <input type="text" name="location" value="<?php esc_textarea( $location ); ? >" class="widefat">
	// slideshow-id="nwbt_tz_setting[nwbt_tz_textarea_field_0]"
	?>
	<?php  //echo $location; ?>

	 	<h2>Configure Slides here</h2>
		<section ng-app="SnowboticaCaseStudySlidesConfig">
	 		<tz-edit-slideshow 
	 		slideshow-name="location"
	 		slideshow-value='<?php  echo $location; ?>'
	 		></tz-edit-slideshow>
		</section>
	<?php  //echo $location; ?>
	<?php
		// <!-- <section ng-app="SnowboticaSlidesConfig"> -->
	 		// <!-- <tz-edit-slideshow  -->
	 		// <!-- slideshow-name="nwbt_tz_setting[nwbt_tz_textarea_field_0]" -->
	 		// <!-- slideshow-id="nwbt_tz_setting[nwbt_tz_textarea_field_0]" -->
	 		// <!-- // slideshow-value='<?php echo $options['nwbt_tz_textarea_field_0'];? >' -->
	 	// <!-- ></tz-edit-slideshow> -->
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
	if ( ! isset( $_POST['location'] ) || ! wp_verify_nonce( $_POST['snowboticaCaseStudy_fields'], basename(__FILE__) ) ) {
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
add_action( 'save_post', 'snowboticaCaseStudy_save_slides_meta', 1, 2 );