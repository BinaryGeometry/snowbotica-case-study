<?php

/*-------------------------------------------------------------------------------
  Case Study posttype
-------------------------------------------------------------------------------*/

function create_case_study_posttype() {
  register_post_type( CASESTUDYPOSTTYPE,
    array(
      'labels' => array(
        'name' => __( 'Case Study' ),
        'singular_name' => __( 'Case Study Item' )
      ),
      'public' => true,
      'supports' => array( 
      	'title',
      	'editor',
      	'thumbnail',
      ),
      'rewrite' => array('slug' => CASESTUDYSLUG),
      'has_archive' => true,
      'menu_icon' => 'dashicons-clipboard',
		  // 'post-formats' //(see Post_Formats)
    )
  );
}
add_action( 'init', 'create_case_study_posttype' );


function include_template_function( $template_path ) {
    if ( get_post_type() == CASESTUDYPOSTTYPE ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-'.CASESTUDYPOSTTYPE.'.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = SNOWBOTICASLIDES . 'single-'.CASESTUDYPOSTTYPE.'.php';
            }
        }
    }
    return $template_path;
}

add_filter( 'template_include', 'include_template_function', 1 );