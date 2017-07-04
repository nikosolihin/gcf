<?php
//=============================================
// Uncomment to hide ACF from client
//=============================================
// add_filter('acf/settings/show_admin', '__return_false');

//=============================================
// Change local JSON path for load and save
// to /src folder. Turn this on only in dev.
//=============================================
// add_filter('acf/settings/save_json', 'acf_json_save_point');
function acf_json_save_point( $path ) {
  $path = dirname(get_stylesheet_directory(), 4) . '/src/acf-json';
  return $path;
}
// add_filter('acf/settings/load_json', 'acf_json_load_point');
function acf_json_load_point( $paths ) {
  unset($paths[0]);
  $paths[] = dirname(get_stylesheet_directory(), 4) . '/src/acf-json';
  return $paths;
}

//=============================================
// Add google maps api key
//=============================================
function my_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyDW7g4UuMum00xC2pm6kPgAyWckSxa6xd8');
}
add_action('acf/init', 'my_acf_init');

//=============================================
// Remove wp_meta_box. New in acf 5.5.13
//=============================================
add_filter('acf/settings/remove_wp_meta_box', '__return_true');

//=============================================
// Add Post Taxonomy Ancestor Rule
// https://github.com/Hube2/acf-filters-and-functions/blob/master/acf-post-category-ancestor-location-rule.php
//=============================================
add_filter('acf/location/rule_types', 'acf_location_types_category_ancestor');
function acf_location_types_category_ancestor($choices) {
  if (!isset($choices['Post']['post_taxonomy_ancestor'])) {
    $choices['Post']['post_taxonomy_ancestor'] = 'Post Taxonomy Ancestor';
  }
  return $choices;
}

add_filter('acf/location/rule_values/post_taxonomy_ancestor', 'acf_location_rules_values_post_taxonomy_ancestor');
function acf_location_rules_values_post_taxonomy_ancestor($choices) {
	$terms = acf_get_taxonomy_terms( 'resource_type' );
	if(!empty($terms)) {
		$choices = array_pop($terms);
	}
	return $choices;
}

add_filter('acf/location/rule_match/post_taxonomy_ancestor', 'acf_location_rules_match_post_taxonomy_ancestor', 10, 3);
function acf_location_rules_match_post_taxonomy_ancestor($match, $rule, $options) {
  // bail early if not a post
  if( !$options['post_id'] ) return false;

  $terms = $options['post_taxonomy'];
  $data = acf_decode_taxonomy_term($rule['value']);
  $term = get_term_by('slug', $data['term'], $data['taxonomy']);

  if (!$term && is_numeric($data['term'])) {
    $term = get_term_by('id', $data['term'], $data['taxonomy']);
  }
  // this is where it's different than ACf
  // get terms so we can look at the parents
  if (is_array($terms)) {
    foreach ($terms as $index => $term_id) {
      $terms[$index] = get_term_by('id', intval($term_id), $term->taxonomy);
    }
  }
  if (!is_array($terms) && $options['post_id']) {
    $terms = wp_get_post_terms(intval($options['post_id']), $term->taxonomy);
  }
  if (!is_array($terms)) {
    $terms = array($terms);
  }
  $terms = array_filter($terms);
  $match = false;
  // collect a list of ancestors
  $ancestors = array();
  if (count($terms)) {
    foreach ($terms as $term_to_check) {
      $ancestors = array_merge(get_ancestors($term_to_check->term_id, $term->taxonomy));
    } // end foreach terms
  } // end if
  // see if the rule matches any term ancetor
  if ($term && in_array($term->term_id, $ancestors)) {
    $match = true;
  }

  if ($rule['operator'] == '!=') {
    // reverse the result
    $match = !$match;
  }
  return $match;
}


//=============================================
// Options Page
//=============================================

// Site Settings //////////////////////////////
if( function_exists('acf_add_options_page') ) {

  // Menu //////////////////////////////
	acf_add_options_page(array(
		'page_title' 	=> '', // No page title since acf already has
		'menu_title'	=> 'Header & Footer',
		'menu_slug' 	=> 'header-footer',
		'position' 		=> '200',
		'icon_url' 		=> 'dashicons-menu'
	));

  // Home Page //////////////////////////////
	acf_add_options_page(array(
		'page_title' 	=> '', // No page title since acf already has
		'menu_title'	=> 'Home Page',
		'menu_slug' 	=> 'homepage',
		'position' 		=> '201',
		'icon_url' 		=> 'dashicons-admin-home'
	));

  // Site Settings //////////////////////////////
  acf_add_options_page(array(
    'page_title' 	=> '', // No page title since acf already has
    'menu_title'	=> 'Settings',
    'menu_slug' 	=> 'settings',
    'position' 		=> '202',
    'icon_url' 		=> 'dashicons-admin-generic',
    'redirect' 		=> false
  ));

  // Announcement Sub Page //////////////////////
  acf_add_options_sub_page(array(
    'page_title' 	=> '', // No page title since acf already has
    'menu_title'	=> 'Site Announcement',
    'parent_slug'	=> 'settings',
  ));

  // // Call to Action Sub Page //////////////////////
  // acf_add_options_sub_page(array(
  //   'page_title' 	=> '', // No page title since acf already has
  //   'menu_title'	=> 'Call To Action',
  //   'parent_slug'	=> 'settings',
  // ));

  // Google OAuth2 Sub Page //////////////////////
  acf_add_options_sub_page(array(
    'page_title' 	=> '', // No page title since acf already has
    'menu_title'	=> 'Authenticate Google',
    'parent_slug'	=> 'settings',
  ));

  // Resource Settings //////////////////////
  acf_add_options_sub_page(array(
		'page_title' 	=> 'Resource Settings',
		'menu_title'	=> 'Settings',
		'parent_slug'	=> 'edit.php?post_type=resource',
	));

  // Services //////////////////////////////
  acf_add_options_page(array(
    'page_title' 	=> '', // No page title since acf already has
    'menu_title'	=> 'Services',
    'menu_slug' 	=> 'service-details',
    'position' 		=> '203',
    'icon_url' 		=> 'dashicons-admin-network'
  ));
}


// //=============================================
// // Only list resources for the French
// // multisite relationship field
// //=============================================
// // function french_relationship_query( $args, $field, $post_id ) {
// //   $args['post_type'] = 'resource';
// //   return $args;
// // }
// // add_filter('acf/fields/relationship/query/name=french', 'french_relationship_query', 10, 3);
//
// //=============================================
// // Only list resources for the Spanish
// // multisite relationship field
// //=============================================
// // function spanish_relationship_query( $args, $field, $post_id ) {
// //   $args['post_type'] = 'resource';
// //   return $args;
// // }
// // add_filter('acf/fields/relationship/query/name=spanish', 'spanish_relationship_query', 10, 3);

//=============================================
// Only list parent pages for the menu relationship
// field
//=============================================
// function menu_relationship_query( $args, $field, $post_id ) {
//   $args['post_parent'] = 0;
//   return $args;
// }
// add_filter('acf/fields/post_object/query/name=parent', 'menu_relationship_query', 10, 3);
// add_filter('acf/fields/relationship/query/name=footer', 'menu_relationship_query', 10, 3);

//=============================================
// Only list children pages for landing page
// exception list
//=============================================
function landing_exception_query( $args, $field, $post_id ) {
  $args['post_parent'] = $post_id;
  return $args;
}
add_filter('acf/fields/post_object/query/name=landing_layout_exception', 'landing_exception_query', 10, 3);
