## Abstract

Recently I had a requirment for a portfolio page which allowed a captionable slideshow. I had solved this problem before in a variety of ways and none of theme seemed satisfactory. A third party plugin for the slider added unessecary complication to the codebase, similarly solving the problem at the theme level using AFC kept the component coupled to costly third party solutions and left a maintainance overhead should the website theme be updated at a later date.

## Plugin design 

To begin finding a soltion to the problem it helped to outline what had worked in the past and take a look at what we could reuse from this.

Clearly this is Wordpress so the native way to do things would be to use custom post types to store the data, creating custom `single-post_type.php` and `archive-post_type.php` to present the data on the frontend and then `post_meta` to create the additional fields for our post.

We aim to keep as much customisation away from the database layer as possible, deploying code is inexpensive, merging databases is not. Still we want to build a flexible component, so an easy design decision was to store the custom post type name and slug in a constant. We define this directly below the plugin definition code and plugin directory code in the main file for our plugin

```
/*
Plugin Name: Snowbotica Case Study
Plugin URI: http://binarygeometry.co.uk/products/snowbotica-case-study
Description: Creates a custom post type with built in presentation slideshow
Author: Andrew MacKay
Version: 1.2.3
Author URI: http://binarygeometry.co.uk/
*/

define( 'SNOWBOTICASLIDES', plugin_dir_path( __FILE__ ) );
define( 'SNOWBOTICASLIDES_URL', plugin_dir_url( __FILE__ ) );

define( 'CASESTUDYPOSTTYPE', 'snwb_case_study' );
define( 'CASESTUDYSLUG', 'case-study' );

```

This doesn't give a huge amount of extra flexibility but does allow the technician maintaining the website a simple way to change the url and future developers an easy place to extend the plugin with some configuration options.

I like to keep the plugin definition file as a manifest of include statements which logically seperate out the different parts of the program.

```
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
```

#### include-scripts-and-styles.php

Contains two functions 'case_study_frontend_assets' and 'case_study_load_admin_scripts'. 

The frontend assets are simply a css and js file and a third party slick.js slideshow which I chose because it has a flexible api and allows two slideshows to be paired. This is useful as I wanted the caption explaining each slide to be in a sidebar next to the image slider. There is possibly more work to do in way of conditionally loading the js, however since a future requirement is a js minification and concantaction build we just going with the absolute minimum of code.

```
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

```

Loading the admin scripts is slightly more involved as we only want to include our meta box on our custom posts. We check for the native hooks 'post-new.php' and 'post.php' i.e. are we creating or editing posts. Then from the $post global we make a comparason with our post_type_name constant.

Our js app is quite light at the moment only requiring angular core and since we will be using a directive html stored in a partial file we need to create 'slides_config_object' to store this path and make it available to the Window at runtime.

```
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
```

#### set-up-post-type-with-templates.php

This file does two things, first it sets up a standard custom post type using our constants.

```
/*-------------------------------------------------------------------------------
  Case Study posttype
-------------------------------------------------------------------------------*/

function snowbotica_case_study_create_posttype() {
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
add_action( 'init', 'snowbotica_case_study_create_posttype' );

```

And then we include our single case study template file in a way that it can be overridden at the theme level using the standard Wordpress custom post page naming convention.

We also have an archive page to include in the same manner [todo]

```
function snowbotica_case_study_include_template_function( $template_path ) {
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

add_filter( 'template_include', 'snowbotica_case_study_include_template_function', 1 );
```


#### set-up-sidebar.php 

Here we register a sidebar which will be displayed alongside our custom post type archive loop to allow the site admin to display additional content about the 'case study' group of posts.

```
<?php
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Case Study Archive Sidebar',
		'id' => CASESTUDYPOSTTYPE.'-archive-sidebar',
		'description' => 'Appears as the sidebar on case study archive',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

```


#### set-up-menu-listing.php

One of our aims is to allow the site admin control over the display of their content. Out of the box wordpress does not include the functionality to add custom post type archive pages to the menu. One way round this is to create a custom template which is assigned to a page. We want a more native feel so we use this conditionally loaded dashboard menu walker we ripped from stack overflow. Checking if the function exists allows us to reuse this code in another plugin without causing conflicts when both plugins are enabled.

```
<?php
/* Add a new walker to the dashboard menu screen to allow adding custom post archives  */ 
if ( ! function_exists( 'snowbotica_add_metabox_menu_posttype_archive' ) ) {


    add_action('admin_head-nav-menus.php', 'snowbotica_add_metabox_menu_posttype_archive');

    function snowbotica_add_metabox_menu_posttype_archive() {
        add_meta_box('snowbotica-metabox-nav-menu-posttype', 'Custom Post Type Archives', 'snowbotica_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
    }

}

if ( ! function_exists( 'snowbotica_metabox_menu_posttype_archive' ) ) {
    function snowbotica_metabox_menu_posttype_archive() {
    $post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

    if ($post_types) :
        $items = array();
        $loop_index = 999999;

        foreach ($post_types as $post_type) {
            $item = new stdClass();
            $loop_index++;

            $item->object_id = $loop_index;
            $item->db_id = 0;
            $item->object = 'post_type_' . $post_type->query_var;
            $item->menu_item_parent = 0;
            $item->type = 'custom';
            $item->title = $post_type->labels->name;
            $item->url = get_post_type_archive_link($post_type->query_var);
            $item->target = '';
            $item->attr_title = '';
            $item->classes = array();
            $item->xfn = '';

            $items[] = $item;
        }

        $walker = new Walker_Nav_Menu_Checklist(array());

        echo '<div id="posttype-archive" class="posttypediv">';
        echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
        echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
        echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
        echo '</ul>';
        echo '</div>';
        echo '</div>';

        echo '<p class="button-controls">';
        echo '<span class="add-to-menu">';
        echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'andromedamedia') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
        echo '<span class="spinner"></span>';
        echo '</span>';
        echo '</p>';

    endif;
    }
}

```

#### slide-in-custom-posts.php

This is possibly the most interesting part of the set up. Wordpress add_meta_box allows us to save and edit additional data for our post. The process is quite brittle and verbose however so the plugin innovates by using a single instance of post meta to save a JSON object containing all the additional data for this post. We use it here to store config data about the slide and and an array of slide data. 

```
<?php


/**
 * Adds a metabox to the right side of the screen under the â€œPublishâ€ box
 */
function snowboticaCaseStudy_add_event_metaboxes() {
	add_meta_box(
		'snowboticaCaseStudy_slides_meta',
		'Event Location',
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

```

Notice here we pass a hardcoded config object to our empty meta field in order to have some example data to work with on the client side.

```
	if($location == ''){
		$location = '{"settings": {"width":"contained", "show_captions":true}, "slides":[{"image_id":734, "caption":"Slide One"},{"image_id":735, "caption":"Slide Two"}]}'; 

	}
	// Output the field
	// <input type="text" name="location" value="<?php esc_textarea( $location ); ? >" class="widefat">
	// slideshow-id="nwbt_tz_setting[nwbt_tz_textarea_field_0]"
	?>

```

We then pass this data to a small angular application consisting of a view layer and a single directive which we will build out later.

```
	 	<h2>Configure Slides here</h2>
		<section ng-app="SnowboticaCaseStudySlidesConfig">
	 		<tz-edit-slideshow 
	 		slideshow-name="location"
	 		slideshow-value='<?php  echo $location; ?>'
	 	></tz-edit-slideshow>
	 	</section>
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
	// We don't sanitizes the data
	$events_meta['location'] = $_POST['location'] ;
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

```

Our angular app is very basic, we don't need a service to fetch data and because our aim is good user experience for the developer and not especially the site admin we use the absolute minimum of code.


#### application/dashboard/case-study-slides-config.js

```
window.snowboticaSlidesPartialsPath   = snowboticaCaseStudy_slides_config_object.partials_path;

// Declare app level module which depends on filters, and services
var SnowboticaSlidesConfig = angular.module('SnowboticaCaseStudySlidesConfig', []);

/* 
* Makes everything better
*/
SnowboticaSlidesConfig.directive('tzEditSlideshow', ['$parse', function($parse){
    return {
        replace: true,
        templateUrl: snowboticaSlidesPartialsPath+'/dashboard/config-template.html',
        scope: {
          data: '=slideshowValue',
          name: '@slideshowName',
          id:   '@slideshowId'
        },
        link: function(scope, element, attr) {
        	console.log('data compiled from php')
        	console.log('slideshowName', scope.name);
        	console.log('slideshowData', scope.data);
        	console.log('slideshowId', scope.id);
        },
        controller: function($scope){

        	$scope.addSlide = function(){
        		$scope.data.slides.push({"image_id": 1, "caption":"change caption" })
        	}
        	$scope.removeSlide = function(index){
        		$scope.data.slides.splice(index, 1)
        	}

        	// $scope.value = $scope.data //JSON.stringify($scope.data);        
        }
    };
}]);

```


We make use of a single angular directive to run our micro application. This provides a conventient way to pass our data into the app by echoing the contents of our meta data field into the scoped variable `data` and also a convenient way to save this data by rendering the dynamic into a hidden html form input `<input type="hidden" value='{{data}}'`. Two way binding ensures that when our simple controller adds and removes slides the value saved by the wordpress meta data is correct.

#### snowboticaSlidesPartialsPath+'/dashboard/config-template.html' 

```
<div class="snowbotica-case-study-post-edit-widget">


	<div ng-repeat="slide in data.slides track by $index">
	  <label>Image ID</label>
	  <input type="number" ng-model="slide.image_id">
	  <label>Caption</label>
	  <input type="text" ng-model="slide.caption">
	  <a class="button" ng-click="removeSlide($index)">remove</a>
	</div>
    <a class="button" ng-click="addSlide()">Add Slide</a>

	<section><!-- outputs the required markup to save using wordpress settings api -->
	<input type="hidden" 
	id="{{id}}"
	name="{{name}}"
	value='{{data}}'
	><!-- // note '"{{value}}"' around value vs "{{value}}" or '{{value}}' -->
	<h4>ID of field: {{id}}</h4>
	<h4>Name of field: {{name}}</h4>
	<h4>Name of field: {{data}}</h4>
	</section>
	
</div>
```

We now have our data object stored in the post meta field. This we can then retrieve on our frontend template using `get_post_meta()`

#### single-snwb_case_study.php

```
<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php //get_template_part( 'template-parts/featured-image' ); ?>

<!-- <section class="contains-2 snowbotica-case-study"> -->

<section class="snowbotica-case-study container">
	<?php while ( have_posts() ) : the_post(); ?>

```

Some work needs to be done with the returned data, first to decode from a JSON string into a PHP object we can work with, and later we loop through this object to build the html for both our slideshows markup.

```
	<?php 
	$sliderMetaJSON = get_post_meta( get_the_ID(), 'location', true ); 
	$sliderMeta = json_decode($sliderMetaJSON, true);
	$slides = $sliderMeta['slides'];
	?>
	<div class="row">
	  	<div class="medium-5 large-6 columns">
		  	<section class="gallery-slideshow">
				<div class="make-this-slide top">
					<?php foreach ($slides as $key => $slide):?>
						<div class="slide image-slide mobile-preview-slide" data-index="0">
							<div class="style-wrapper">
								<?php echo wp_get_attachment_image( $slide['image_id'], 'full' );?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
	 		</section>
	  	</div>
		<div class="medium-7 large-6  columns">
				<article class="service-info background:#c6c6cf">
					<h2><?php the_title();?></h2>
					<div class="case-study-description">
						<?php the_content();?>
					</div>					
					<?php if (get_post_meta( get_the_ID(), 'location', true ) ) : ?>
					<div class="make-this-slide sub">
						<?php foreach ($slides as $key => $slide):?>
						<div class="slide image-slide description-slide" data-index="<?php echo $key;?>">
							<div class="style-wrapper">
								<p><?php echo $slide['caption']; ?></p>
							</div>
						</div>
						<?php endforeach;?>
					</div>
					<?php endif; ?>
				</article>
		</div>
	</div>
	<?php endwhile;?>
</section>
<?php get_footer();

```

We then wait for the document to become ready before initialisation of our duel slideshow using the 'Slick' slideshow plugin for jQuery.

#### application/frontend/case-study-slides.js

```
(function( $ ) {
 
    "use strict";

	$('.make-this-slide.sub').slick({
	    slidesToShow: 1,
	    slidesToScroll: 1,
	    arrows: false,
	    fade: true,
	    arrows:false,
	    bullets:false,
	    dots: true,
	    asNavFor: '.make-this-slide.top'
	});

	$('.make-this-slide.top').slick({
		// autoplay: true,
		autoplaySpeed: 1400,
		speed:800,
	    slidesToShow: 1,
	    slidesToScroll: 1,
	    asNavFor: '.make-this-slide.sub',
	    dots: false,
	    centerMode: false,
	    arrows: false,
	    focusOnSelect: true
	});


})(jQuery);
```

#### application/archive-case_study.php

The main thing to note about the archive page template is that it calls the custom sidebar we added above.

```
<?php
/*
 * Template Name: Snowbotica Case Study Archive
 * @package Snowbotica Case Study
*/
?>
<?php get_header(); ?>
<section class="snowbotica-theme-content case-study-archive">
	<div class="row" data-equalizer>
	  	<div class="medium-7 columns" data-equalizer-watch>
			<?php
			    $args = array(
			        'post_type' => CASESTUDYPOSTTYPE,
			        'posts_per_page' => 5
			    );
			    $post_query = new WP_Query($args);
			?>
			<div class="row">
				<div class="medium-12 large-12 columns item">
					<?php if($post_query->have_posts() ) :?>
				  	<?php while($post_query->have_posts() ) : $post_query->the_post();?>
						<article class="case-study-listing">
						    <a href="<?php the_permalink();?>">
						    	<span class="image"><?php the_post_thumbnail('avatar');?></span>
				    			<h2 class="title"><?php the_title();?></h2>
				    		</a>
						</article>
				    <?php endwhile;?>
					<?php endif;?>
				</div>
			</div>
		</div> 
		<div class="medium-5  columns first-col">
			<aside id="case-study-archive-sidebar">
			    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(CASESTUDYPOSTTYPE.'-archive-sidebar') ) : ?>
			    <?php endif; ?>
			</aside>
		</div>
	</div>
</section>
<?php get_footer(); ?>
```

And that's it, hopefully you learned some helpful things about using data objects stored in post meta to add powerful and flexible configuration to your custom posts.

Further posts in this series will look at expanding this basic outline into something more user friendly by introducing the facility to reorder the slides using drag and drop.

