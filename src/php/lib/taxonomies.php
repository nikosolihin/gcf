<?php
/**
 * Register Resource Type Taxonomy
 */
function resource_type_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Resource Types', 'Taxonomy General Name', 'gcf' ),
		'singular_name'              => _x( 'Resource Type', 'Taxonomy Singular Name', 'gcf' ),
		'menu_name'                  => __( 'Types', 'gcf' ),
		'all_items'                  => __( 'All Types', 'gcf' ),
		'parent_item'                => __( 'Parent Type', 'gcf' ),
		'parent_item_colon'          => __( 'Parent Type:', 'gcf' ),
		'new_item_name'              => __( 'New Type Name', 'gcf' ),
		'add_new_item'               => __( 'Add New Type', 'gcf' ),
		'edit_item'                  => __( 'Edit Type', 'gcf' ),
		'update_item'                => __( 'Update Type', 'gcf' ),
		'view_item'                  => __( 'View Type', 'gcf' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'gcf' ),
		'add_or_remove_items'        => __( 'Add or remove types', 'gcf' ),
		'choose_from_most_used'      => __( 'Choose from the most used types', 'gcf' ),
		'popular_items'              => __( 'Popular Types', 'gcf' ),
		'search_items'               => __( 'Search types', 'gcf' ),
		'not_found'                  => __( 'Not Found', 'gcf' ),
		'no_terms'                   => __( 'No items', 'gcf' ),
		'items_list'                 => __( 'Items list', 'gcf' ),
		'items_list_navigation'      => __( 'Items list navigation', 'gcf' ),
	);
	$rewrite = array(
		'with_front'                 => false,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'query_var'									 => true, // must be true if doing filter[xxx] api call
		'publicly_queryable'				 => true, // must be true if doing filter[xxx] api call
		'public'                     => true,
		'show_in_rest'               => true,
		'rest_base'                  => 'types',
		'rest_controller_class'      => 'WP_REST_Terms_Controller',
		// 'show_in_graphql'     			 => true,
		// 'graphql_single_name' 	     => 'resourceType',
		// 'graphql_plural_name' 	     => 'resourceTypes'
	);
	register_taxonomy( 'resource_type', array( 'resource' ), $args );
}
add_action( 'init', 'resource_type_taxonomy', 0 );


/**
 * Register Resource Topic Taxonomy
 */
function resource_topic_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Resource Topics', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Resource Topic', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Topics', 'text_domain' ),
		'all_items'                  => __( 'All Topics', 'text_domain' ),
		'parent_item'                => __( 'Parent Topic', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Topic:', 'text_domain' ),
		'new_item_name'              => __( 'New Topic Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Topic', 'text_domain' ),
		'edit_item'                  => __( 'Edit Topic', 'text_domain' ),
		'update_item'                => __( 'Update Topic', 'text_domain' ),
		'view_item'                  => __( 'View Topic', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate topics with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove topics', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used topics', 'text_domain' ),
		'popular_items'              => __( 'Popular Topics', 'text_domain' ),
		'search_items'               => __( 'Search topics', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$rewrite = array(
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'query_var'									 => true, // must be true if doing filter[xxx] api call
		'publicly_queryable'				 => true, // must be true if doing filter[xxx] api call
		'public'                     => true,
		'show_in_rest'               => true,
		'rest_base'                  => 'topics',
		'rest_controller_class'      => 'WP_REST_Terms_Controller',
		// 'show_in_graphql'     			 => true,
		// 'graphql_single_name' 	     => 'resourceTopic',
		// 'graphql_plural_name' 	     => 'resourceTopics'
	);
	register_taxonomy( 'resource_topic', array( 'resource' ), $args );
}
add_action( 'init', 'resource_topic_taxonomy', 0 );


/**
 * Register Role Taxonomy
 */
function role_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Roles', 'Taxonomy General Name', 'gcf' ),
		'singular_name'              => _x( 'Role', 'Taxonomy Singular Name', 'gcf' ),
		'menu_name'                  => __( 'Roles', 'gcf' ),
		'all_items'                  => __( 'All Roles', 'gcf' ),
		'parent_item'                => __( 'Parent Role', 'gcf' ),
		'parent_item_colon'          => __( 'Parent Role:', 'gcf' ),
		'new_item_name'              => __( 'New Role Name', 'gcf' ),
		'add_new_item'               => __( 'Add New Role', 'gcf' ),
		'edit_item'                  => __( 'Edit Role', 'gcf' ),
		'update_item'                => __( 'Update Role', 'gcf' ),
		'view_item'                  => __( 'View Role', 'gcf' ),
		'separate_items_with_commas' => __( 'Separate roles with commas', 'gcf' ),
		'add_or_remove_items'        => __( 'Add or remove roles', 'gcf' ),
		'choose_from_most_used'      => __( 'Choose from the most used roles', 'gcf' ),
		'popular_items'              => __( 'Popular Roles', 'gcf' ),
		'search_items'               => __( 'Search roles', 'gcf' ),
		'not_found'                  => __( 'Not Found', 'gcf' ),
		'no_terms'                   => __( 'No items', 'gcf' ),
		'items_list'                 => __( 'Items list', 'gcf' ),
		'items_list_navigation'      => __( 'Items list navigation', 'gcf' ),
	);
	$rewrite = array(
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
		'public'                     => true,
		'show_in_rest'               => false,
	);
	register_taxonomy( 'role', array( 'person' ), $args );
}
add_action( 'init', 'role_taxonomy', 0 );
