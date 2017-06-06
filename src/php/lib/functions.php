<?php
//=============================================
// Add user role class to body tag.
// Used to hide zoneboard blocks for campus_manager role
//=============================================
// if ( is_user_logged_in() ) {
//   add_filter('body_class','add_role_to_body');
//   add_filter('admin_body_class','add_role_to_body');
// }
// function add_role_to_body($classes) {
//   $current_user = new WP_User(get_current_user_id());
//   $user_role = array_shift($current_user->roles);
//   if (is_admin()) {
//     $classes .= 'role-'. $user_role;
//   } else {
//     $classes[] = 'role-'. $user_role;
//   }
//   return $classes;
// }

//=============================================
// Remove classes from wp_list_pages
//=============================================
//  function remove_page_class($wp_list_pages) {
// 	$pattern = '/current_page_[a-z]+/';
// 	$replace_with = 'is-Active';
//   $first_phase = preg_replace($pattern, $replace_with, $wp_list_pages);
//
//   $pattern = '/\<li class="page_item[^>]*(?=is-Active)/';
// 	$replace_with = '<li class="';
//   $second_phase = preg_replace($pattern, $replace_with, $first_phase);
//
//   $pattern = '/\<li class="page_item[^>]*>/';
// 	$replace_with = '<li>';
//   $third_phase = preg_replace($pattern, $replace_with, $second_phase);
//
//   $pattern = "/\<ul class='children[^>]*>/";
// 	$replace_with = '<ul class="List">';
// 	return preg_replace($pattern, $replace_with, $third_phase);
// }
// add_filter('wp_list_pages', 'remove_page_class');

//=============================================
// Get posts
//=============================================
function getPosts($options) {
  $posts = array();
  $type = '';

  // Sets some defaults
  if (!array_key_exists('mode',$options)) {
    $options['mode'] = true;
  }
  if (!array_key_exists('quantity',$options)) {
    $options['quantity'] = -1;
  }

  // Which mode are we on?
  if ($options['mode']) {  // Automatic

    // Are we excluding any posts?
    $exclude = array();
    if (isset($options['exclude'])) {
      array_push($exclude, $options['exclude']);
    }

    // Set up basic wp_query args
    $args = array(
      'posts_per_page'=> $options['quantity'],
      'post_type'		  => 'resource',
      'post__not_in'  => $exclude
    );

    // Tax Query
    if ( isset($options['resource_type']) ||              isset($options['resource_topic']) ) {

      // both type + topics?
      if ( isset($options['resource_type']) && isset($options['resource_topic']) ) {
        $type_slug = $options['resource_type'];
        $topic_slugs = $options['resource_topic'];

        $type_query = array( 'relation'  => 'OR' );
        foreach ($topic_slugs as $topic) {
          array_push($topic_query, array(
            'taxonomy'       => 'resource_topic',
            'field'          => 'slug',
            'terms'          => $topic
          ));
        }

        $topic_query = array( 'relation'  => 'OR' );
        foreach ($topic_slugs as $topic) {
          array_push($topic_query, array(
            'taxonomy'       => 'resource_topic',
            'field'          => 'slug',
            'terms'          => $topic
          ));
        }

        $args['tax_query'] = array(
          'relation'         => 'AND',
          array(
            'taxonomy'       => 'resource_type',
            'field'          => 'slug',
            'terms'          => $type_slug
          ),
          $topic_query
        );

      } else {
        // only type
        if ( isset($options['resource_type']) ) {
          $type_slug = $options['resource_type'];
          $args['tax_query'] = array();
          array_push($args['tax_query'], array(
            'taxonomy'       => 'resource_type',
            'field'          => 'slug',
            'terms'          => $type_slug
          ));
        }
        // only topic
        if ( isset($options['resource_topic']) ) {
          $topic_slugs = $options['resource_topic'];
          $args['tax_query'] = array();
          array_push($args['tax_query'], array(
            'taxonomy'       => 'resource_topic',
            'field'          => 'slug',
            'terms'          => $topic_slugs,
            'operator' 		   => 'IN'
          ));
        }
      }
    }

    // Get the posts
    $posts = Timber::get_posts($args);

  } else { // Manual

    // Get the posts and post type based of first element
    $posts = Timber::get_posts($options['manual_posts']);
    $type = $posts[0]->type->slug;

    // Check the rest of the posts for junks
    foreach ($posts as $key => $post) {
      if( $post->type->slug != $type ) {
        unset($posts[$key]);
      }
    }
  }

  // Populate metadata
  $filtered_posts = array();
  foreach ($posts as $post) {
    array_push($filtered_posts, array(
      'title'       => $post->title,
      'link'        => $post->link,
      'date'        => $post->post_date,
      'type'        => $post->get_terms('resource_type')[0]->name,
      'topics'      => $post->get_terms('resource_topic'),
      'author'      => $post->get_field('author')->post_title,
      'author_id'   => $post->get_field('author')->ID,
      'teaser'      => $post->get_field('teaser'),
      'image'       => serveImage($post->get_field('image')),
      'square'      => serveSquareImage($post->get_field('image'))
    ));
  }
  return $filtered_posts;
}

//=============================================
// Get Posts for related resources carousel
//=============================================
function getRelatedResources($options) {
  $auto = array();
  $manual = array();
  $type_slug = $options['resource_type'];
  $topic_slugs = $options['resource_topic'];

  if (!array_key_exists('quantity',$options)) {
    $options['quantity'] = -1;
  }

  // Are we excluding any posts?
  $exclude = array();
  if (isset($options['exclude'])) {
    array_push($exclude, $options['exclude']);
  }

  // Get manual posts if set and create an exclusion list
  if (isset($options['manual_posts'])) {
    $posts = Timber::get_posts($options['manual_posts']);
    foreach ($options['manual_posts'] as $id) {
      array_push($exclude, $id);
    }
    foreach ($posts as $post) {
      array_push($manual, array(
        'title'       => $post->title,
        'link'        => $post->link,
        'date'        => $post->post_date,
        'type'        => $post->get_terms('resource_type')[0]->name,
        'type_slug'   => $post->get_terms('resource_type')[0]->slug,
        'type_color'   => $post->get_terms('resource_type')[0]->type_color,
        'topics'      => $post->get_terms('resource_topic'),
        'author'      => $post->get_field('author')->post_title,
        'author_id'   => $post->get_field('author')->ID,
        'teaser'      => $post->get_field('teaser'),
        'image'       => serveImage($post->get_field('image')),
        'square'      => serveSquareImage($post->get_field('image'))
      ));
    }
  }

  // Set up basic wp_query args
  $args = array(
    'posts_per_page'=> $options['quantity'],
    'post_type'		  => 'resource',
    'post__not_in'  => $exclude
  );

  // Tax Query
  $args['tax_query'] = array( 'relation'  => 'OR' );

  // Find posts that are tagged with any one of the tags.
  foreach ($topic_slugs as $topic) {
    array_push($args['tax_query'], array(
      'taxonomy'       => 'resource_topic',
      'field'          => 'slug',
      'terms'          => $topic
    ));
  }

  // Get the automatic posts
  $auto = Timber::get_posts($args);

  // Sorted results by resource types
  $same_type = array();
  $different_type = array();
  foreach ($auto as $post) {
    $type = $post->get_terms('resource_type')[0]->slug;
    $context = array(
      'title'       => $post->title,
      'link'        => $post->link,
      'date'        => $post->post_date,
      'type'        => $post->get_terms('resource_type')[0]->name,
      'type_slug'   => $post->get_terms('resource_type')[0]->slug,
      'type_color'   => $post->get_terms('resource_type')[0]->type_color,
      'topics'      => $post->get_terms('resource_topic'),
      'author'      => $post->get_field('author')->post_title,
      'author_id'   => $post->get_field('author')->ID,
      'teaser'      => $post->get_field('teaser'),
      'image'       => serveImage($post->get_field('image')),
      'square'      => serveSquareImage($post->get_field('image'))
    );
    if ($type == $type_slug) {
      array_push($same_type, $context);
    } else {
      array_push($different_type, $context);
    }
  }

  // Return results
  return array_merge($manual, $same_type, $different_type);
}

//=============================================
// Serve Image
//=============================================
function serveImage($image) {
  if(isset($image) && is_array($image)) {
    $base = $image['base']."s";
    $name = "/".$image['title'];
    $xs = $base . '576' . $name;
    $sm = $base . '800' . $name;
    $md = $base . '1024' . $name;
    $lg = $base . '1280' . $name;
    $xl = $base . '1440' . $name;
    $xxl = $base . '1600' . $name;
    return array(
      'xs' => $xs,
      'sm' => $sm,
      'md' => $md,
      'lg' => $lg,
      'xl' => $xl,
      'xxl' => $xxl,
    );
  } else {
    return serveImage(get_field('fallback_image', 'option'));
  }
}
function serveSquareImage($image, $isProfile = false) {
  if(isset($image) && is_array($image)) {
    $base = $image['base']."s";
    $name = "-c/".$image['title'];
    $xs = $base . '160' . $name;
    $sm = $base . '400' . $name;
    $md = $base . '640' . $name;
    $lg = $base . '800' . $name;
    return array(
      'xs' => $xs,
      'sm' => $sm,
      'md' => $md,
      'lg' => $lg,
    );
  } else {
    if ($isProfile) {
      return serveSquareImage(get_field('fallback_photo', 'option'));
    } else {
      return serveSquareImage(get_field('fallback_image', 'option'));
    }
  }
}

//=============================================
// Remove the meta tag showing WP version
// Source: https://kinsta.com/blog/wordpress-security/
//=============================================
function wpversion_remove_version() {
  return '';
}
add_filter('the_generator', 'wpversion_remove_version');

//=============================================
// Localization
//=============================================
load_theme_textdomain( 'gcf', get_template_directory().'/languages' );

//=============================================
// Popular Posts Counter
// https://digwp.com/2016/03/diy-popular-posts/
//=============================================
function popular_resource_posts($post_id) {
	$count_key = 'popular_posts';
	$count = get_post_meta($post_id, $count_key, true);
	if ($count == '') {
		$count = 0;
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
	} else {
		$count++;
		update_post_meta($post_id, $count_key, $count);
	}
}
function track_resource_posts($post_id) {
	if (!is_singular( 'resource' )) return;
	if (empty($post_id)) {
		global $post;
		$post_id = $post->ID;
	}
	popular_resource_posts($post_id);
}
add_action('wp_head', 'track_resource_posts');
