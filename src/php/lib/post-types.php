<?php
/**
 * Register Resource Post Type
 */
function resources_post_type() {
	$labels = array(
		'name'                  => _x( 'Resources', 'Post Type General Name', 'gcf' ),
		'singular_name'         => _x( 'Resource', 'Post Type Singular Name', 'gcf' ),
		'menu_name'             => __( 'Resources', 'gcf' ),
		'name_admin_bar'        => __( 'Resource', 'gcf' ),
		'archives'              => __( 'Resource Archives', 'gcf' ),
		'parent_item_colon'     => __( 'Parent Resource:', 'gcf' ),
		'all_items'             => __( 'All Resources', 'gcf' ),
		'add_new_item'          => __( 'Add New Resource', 'gcf' ),
		'add_new'               => __( 'New Resource', 'gcf' ),
		'new_item'              => __( 'New Resource', 'gcf' ),
		'edit_item'             => __( 'Edit Resource', 'gcf' ),
		'update_item'           => __( 'Update Resource', 'gcf' ),
		'view_item'             => __( 'View Resource', 'gcf' ),
		'search_items'          => __( 'Search Resources', 'gcf' ),
		'not_found'             => __( 'No event found', 'gcf' ),
		'not_found_in_trash'    => __( 'No event found in trash', 'gcf' ),
		'attributes'						=> __( 'Layout Settings', 'gcf' ),
		'featured_image'        => __( 'Featured Image', 'gcf' ),
		'set_featured_image'    => __( 'Set featured image', 'gcf' ),
		'remove_featured_image' => __( 'Remove featured image', 'gcf' ),
		'use_featured_image'    => __( 'Use as featured image', 'gcf' ),
		'insert_into_item'      => __( 'Insert into item', 'gcf' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'gcf' ),
		'items_list'            => __( 'Items list', 'gcf' ),
		'items_list_navigation' => __( 'Items list navigation', 'gcf' ),
		'filter_items_list'     => __( 'Filter items list', 'gcf' )
	);
	$rewrite = array(
		'slug'                  => 'resources/%resource_type%',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => false
	);
	$args = array(
		'description'           => __( 'Custom post type for resource', 'gcf' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'taxonomies'            => array( 'resource_type','resource_topic' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 100,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'     	=> 'page',
    'map_meta_cap'        	=> true,
		'show_in_rest'       		=> true,
		'rest_base'          		=> 'resources',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'show_in_graphql'     	=> true,
		'graphql_single_name' 	=> 'resource',
		'graphql_plural_name' 	=> 'resources'
	);
	register_post_type( 'resource', $args );
}
add_action( 'init', 'resources_post_type', 0 );


/**
 * Register Person Post Type
 */
function person_post_type() {
	$labels = array(
		'name'                  => _x( 'People', 'Post Type General Name', 'gcf' ),
		'singular_name'         => _x( 'Person', 'Post Type Singular Name', 'gcf' ),
		'menu_name'             => __( 'People', 'gcf' ),
		'name_admin_bar'        => __( 'Person', 'gcf' ),
		'archives'              => __( 'People Archives', 'gcf' ),
		'parent_item_colon'     => __( 'Parent Person:', 'gcf' ),
		'all_items'             => __( 'All People', 'gcf' ),
		'add_new_item'          => __( 'Add New Person', 'gcf' ),
		'add_new'               => __( 'New Person', 'gcf' ),
		'new_item'              => __( 'New Person', 'gcf' ),
		'edit_item'             => __( 'Edit Person', 'gcf' ),
		'update_item'           => __( 'Update Person', 'gcf' ),
		'view_item'             => __( 'View Person', 'gcf' ),
		'search_items'          => __( 'Search Person', 'gcf' ),
		'not_found'             => __( 'No person found', 'gcf' ),
		'not_found_in_trash'    => __( 'No person found in trash', 'gcf' ),
		'featured_image'        => __( 'Featured Image', 'gcf' ),
		'set_featured_image'    => __( 'Set featured image', 'gcf' ),
		'remove_featured_image' => __( 'Remove featured image', 'gcf' ),
		'use_featured_image'    => __( 'Use as featured image', 'gcf' ),
		'insert_into_item'      => __( 'Insert into item', 'gcf' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'gcf' ),
		'items_list'            => __( 'Items list', 'gcf' ),
		'items_list_navigation' => __( 'Items list navigation', 'gcf' ),
		'filter_items_list'     => __( 'Filter items list', 'gcf' ),
	);
	$args = array(
		'label'                 => __( 'Person', 'gcf' ),
		'description'           => __( 'Custom post type for people', 'gcf' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 101,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false, //Disable single page viewing
		'rewrite'               => false,
		'capability_type'       => 'page',
		'show_in_rest'       		=> false,
	);
	register_post_type( 'person', $args );
}
add_action( 'init', 'person_post_type', 0 );


/**
 * Filters to enable %custom-taxonomy% in rewrites
 * http://wordpress.stackexchange.com/questions/108642/permalinks-custom-post-type-custom-taxonomy-post
 */
function resource_type_permalinks( $post_link, $post ){
	if ( is_object( $post ) && $post->post_type == 'resource' ){
		$terms = wp_get_object_terms( $post->ID, 'resource_type' );
		if( $terms ){
			return str_replace( '%resource_type%' , $terms[0]->slug , $post_link );
		}
	}
	return $post_link;
}
add_filter( 'post_type_link', 'resource_type_permalinks', 1, 2 );
