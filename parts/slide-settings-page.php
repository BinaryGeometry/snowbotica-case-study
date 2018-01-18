<?php  

function nwbt_tz_add_admin_menu(  ) { 

	$page = add_menu_page( 'nwbt_tz_slideshow', 'Snowbotica Slides', 'manage_options', 'nwbt_tz_slideshow', 'nwbt_tz_options_page' );

    /* Using registered $page handle to hook script load */
    add_action('admin_print_scripts-' . $page, 'tz_slideshow_load_admin_scripts');

}
add_action( 'admin_menu', 'nwbt_tz_add_admin_menu' );



/*
 * innit out settings page
 */ 
function nwbt_tz_setting_init(  ) { 

	register_setting( 'pluginPage', 'nwbt_tz_setting' );

	add_settings_section(
		'nwbt_tz_pluginPage_section', 
		__( 'Your section description', 'nwbtTz' ), 
		'nwbt_tz_setting_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'nwbt_tz_textarea_field_0', 
		__( 'Settings field description', 'nwbtTz' ), 
		'nwbt_tz_textarea_field_0_render', 
		'pluginPage', 
		'nwbt_tz_pluginPage_section' 
	);
}
add_action( 'admin_init', 'nwbt_tz_setting_init' );

/*
 * innit out settings page
 */
function nwbt_tz_textarea_field_0_render(  ) { 

	$options = get_option( 'nwbt_tz_setting' );
	if(!$options){
		$options['nwbt_tz_textarea_field_0'] = '{"settings": {"width":"contained", "show_captions":true}, "slides":[{"image_id":734, "caption":"Slide One"},{"image_id":735, "caption":"Slide Two"}]}' ;
	}
	?>
	<section ng-app="SnowboticaSlidesConfig">
	 	<tz-edit-slideshow 
	 	slideshow-name="nwbt_tz_setting[nwbt_tz_textarea_field_0]"
	 	slideshow-id="nwbt_tz_setting[nwbt_tz_textarea_field_0]"
	 	slideshow-value='<?php echo $options['nwbt_tz_textarea_field_0'];?>'
	 	></tz-edit-slideshow>
	 </section>
	<?php 
	/*
	<textarea cols='40' rows='5' name='nwbt_tz_setting[nwbt_tz_textarea_field_0]'> 
		<?php echo $options['nwbt_tz_textarea_field_0']; ?>
 	</textarea>
	<?php */
}

function nwbt_tz_setting_section_callback(  ) { 

	echo __( 'This section description', 'nwbtTz' );
}

function nwbt_tz_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<!-- <h2>nwbt_tz_slideshow</h2> -->

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php
}


