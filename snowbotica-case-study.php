<?php
/*
Plugin Name: Snowbotica Case Study
Plugin URI: http://nowbotica.com/lets-tzu-this/
Description: A rust proof diy starter kit for micro enterprises | Slideshow functionality
Author: Andrew MacKay
Version: 1.2.3
Author URI: http://nowbotica.com/
*/

define( 'SNOWBOTICASLIDES', plugin_dir_path( __FILE__ ) );
define( 'SNOWBOTICASLIDES_URL', plugin_dir_url( __FILE__ ) );

define( 'CASESTUDYPOSTTYPE', 'snwb_case_study' );
define( 'CASESTUDYSLUG', 'case-study' );


/**
 * Includes js and css
 *
 */
add_action('wp_enqueue_scripts','snowboticaSlides_frontend');
add_action('wp_enqueue_scripts','snowboticaSlides_dashboard');

/*-------------------------------------------------------------------------------
  Frontend dependencies Javascript and CSS to be included by [mvpmApp] shortcode
-------------------------------------------------------------------------------*/

if ( ! function_exists( 'snowboticaSlides_frontend' ) ) {
    /*
     *  loads the applications css dependancies and theme css files
     */
    function snowboticaSlides_frontend() {
        
        wp_enqueue_style( 'case-study-css', SNOWBOTICASLIDES_URL .  'application/snowbotica-case-study.css', false, '', 'all');
        
        wp_enqueue_script( 'slick-js', SNOWBOTICASLIDES_URL .  'application/dependencies/slick/slick.js', array(), 'jquery', true);

        wp_enqueue_script( 'tz-slider-js', SNOWBOTICASLIDES_URL .  'application/frontend/tz-slider.js', array(), 'slick-js', true); 
    
    }
}


if ( ! function_exists( 'snowboticaSlides_dashboard' ) ) {
    /*
     *  loads the applications js dependancies and application files
     */
    function snowboticaSlides_dashboard() {
        // echo SNOWBOTICASLIDES_URL . '/application/backend/tz-slider-config.js'; die;
        // MVP Mechanic Profile Module
        // wp_enqueue_script( 'snowbotica-slides-module', SNOWBOTICASLIDES_URL . '/application/backend/tz-slider-config.js', array(
            // 'snowbotica-treeline'
        // ), '', true);
    }
}

/*
* Register our angular app
*/
function tz_slideshow_load_admin_scripts() {
 
    // if( $hook != 'widgets.php' ) 
     // return;
    
    wp_enqueue_script( 'angular', SNOWBOTICASLIDES_URL .  'application/dependencies/angular/angular.js', array( 'jquery'), '', true);

    wp_enqueue_script( 'snowbotica-slides-config', SNOWBOTICASLIDES_URL .  'application/backend/snowbotica-slides-config.js', array('angular'), '', true );
    
    wp_localize_script( 'snowbotica-slides-config', 'snowbotica_slides_config_object', array(
            'partials_path' => SNOWBOTICASLIDES_URL .  '/application' 
        ), '', true);

}


# Included parts
include( SNOWBOTICASLIDES . '/parts/set-up-post-type-with-templates.php');
include( SNOWBOTICASLIDES . '/parts/slide-in-custom-posts.php');
include( SNOWBOTICASLIDES . '/parts/slide-settings-page.php');
include( SNOWBOTICASLIDES . '/parts/frontend-shortcode.php');
// include( SNOWBOTICASLIDES . '/parts/widgets/slideshow.php');