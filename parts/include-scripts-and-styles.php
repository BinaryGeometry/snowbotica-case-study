<?php


/*-------------------------------------------------------------------------------
  Frontend Javascript and CSS
-------------------------------------------------------------------------------*/
/**
 * Includes js and css
 *
 */
add_action('wp_enqueue_scripts','snowbotica_case_study_frontend_assets');

if ( ! function_exists( 'snowbotica_case_study_frontend_assets' ) ) {
    /*
     *  loads the applications css dependancies and theme css files
     */
    function snowbotica_case_study_frontend_assets() {
        
        wp_enqueue_style( 'case-study-css', SNOWBOTICASLIDES_URL .  'application/snowbotica-case-study.css', false, '', 'all');
        
        wp_enqueue_script( 'slick-js', SNOWBOTICASLIDES_URL .  'application/dependencies/slick/slick.js', array(), 'jquery', true);

        wp_enqueue_script( 'snowbotica-case-study-slides-js', SNOWBOTICASLIDES_URL .  'application/frontend/snowbotica-case-study-slides.js', array(), 'slick-js', true); 
    
    }
}

/*
* Register our angular app - used by meta box initialisation
*/
function snowbotica_case_study_load_admin_scripts($hook) {
 
    // if( $hook != 'widgets.php' ) 
     // return;
    
    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( CASESTUDYPOSTTYPE === $post->post_type ) {     
          wp_enqueue_script( 'angular', SNOWBOTICASLIDES_URL .  'application/dependencies/angular/angular.js', array( 'jquery'), '', true);

          wp_enqueue_script( 'snowbotica-case-study-slides-config', SNOWBOTICASLIDES_URL .  'application/dashboard/snowbotica-case-study-slides-config.js', array('angular'), '', true );
          
          wp_localize_script( 'snowbotica-case-study-slides-config', 'snowboticaCaseStudy_slides_config_object', array(
                  'partials_path' => SNOWBOTICASLIDES_URL .  '/application' 
              ), '', true);
        }
    }

}

add_action( 'admin_enqueue_scripts', 'snowbotica_case_study_load_admin_scripts', 10, 1 );