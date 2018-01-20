<?php
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Case Study Archive Sidebar',
		'id' => 'case-study-archive-sidebar',
		'description' => 'Appears as the sidebar on case study archive',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

