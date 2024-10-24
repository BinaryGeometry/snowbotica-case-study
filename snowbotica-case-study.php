<?php
/**
 * License   GPL-2.0+
 * @copyright 2024 Binary Geometry Ltd <andrew.mackay@binarygeometry.co.uk>
 * Plugin Name: Snowbotica Case Study
 * Plugin URI: http://binarygeometry.co.uk/products/snowbotica-case-study
 * Description: Creates a custom post type with built in presentation slideshow
 * Author: Andrew MacKay
 * Version: 1.0.1
 * Author URI: http://binarygeometry.co.uk/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

define( 'SNOWBOTICASLIDES', plugin_dir_path( __FILE__ ) );
define( 'SNOWBOTICASLIDES_URL', plugin_dir_url( __FILE__ ) );

define( 'CASESTUDYPOSTTYPE', 'snwb_case_study' );
define( 'CASESTUDYSLUG', 'case-study' );


# Included parts
/* Registration hooks and functions for browser assets */
include( SNOWBOTICASLIDES . '/parts/include-scripts-and-styles.php');

/* Adds a new custom post type to the dashboard and tells Wordpress where to find the template files */
include( SNOWBOTICASLIDES . '/parts/set-up-post-type-with-templates.php');

/* Adds a custom sidebar to the post type archive template */
include( SNOWBOTICASLIDES . '/parts/set-up-sidebar.php');

/* Makes the post type archive available in the Wordpress menu builder */
include( SNOWBOTICASLIDES . '/parts/set-up-menu-listing.php');

/* Uses post meta and Angularjs to attach a presentation slideshow configuration box to post edit screen */
include( SNOWBOTICASLIDES . '/parts/slide-in-custom-posts.php');