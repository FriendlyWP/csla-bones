<?php
/* 
 * Custom Post Types
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// Register Custom Post Type
function custom_post_type() {

	$labels = array(
		'name'                => _x( 'motions', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Motion', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Motion', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent motion:', 'text_domain' ),
		'all_items'           => __( 'All motions', 'text_domain' ),
		'view_item'           => __( 'View motion', 'text_domain' ),
		'add_new_item'        => __( 'Add New motion', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit motion', 'text_domain' ),
		'update_item'         => __( 'Update motion', 'text_domain' ),
		'search_items'        => __( 'Search motions', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'Motioncontent', 'text_domain' ),
		'description'         => __( 'Motion', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'Motioncontent', $args );

	$labels = array(
		'name'                => _x( 'People', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Person', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Person', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Person:', 'text_domain' ),
		'all_items'           => __( 'All People', 'text_domain' ),
		'view_item'           => __( 'View Person', 'text_domain' ),
		'add_new_item'        => __( 'Add New Person', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit Person', 'text_domain' ),
		'update_item'         => __( 'Update Person', 'text_domain' ),
		'search_items'        => __( 'Search People', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'People', 'text_domain' ),
		'description'         => __( 'People', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'people', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_type', 0 );