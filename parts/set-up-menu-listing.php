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
        echo '<input type="submit"' . esc_attr(disabled(1, 0)) . ' class="button-secondary submit-add-to-menu right" value="' . esc_attr(__('Add to Menu', 'snowbotica-case-study')) . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
        echo '<span class="spinner"></span>';
        echo '</span>';
        echo '</p>';

    endif;
    }
}