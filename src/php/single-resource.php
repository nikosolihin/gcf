<?php

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['acf'] = get_fields();
$context['sections'] = $context['acf']['sections'];
$context['with_banner'] = $context['acf']['with_banner'];
$related_quantity = get_field('related_quantity', 'option');

// Get this resource's type
$type = $post->get_terms('resource_type')[0];
$type_slug = $type->slug;
if(isset($type) && is_object($type)) {
	// For Timber
	$context['type'] = $type->name;
	$context['type_slug'] = $type_slug;
	$context['type_color'] = $type->type_color;
}

// Get this resource's topics
$topics = $post->get_terms('resource_topic');
$topic_slugs = array();
if(isset($topics) && is_array($topics)) {
	// For Timber
	$context['topics'] = array();
	foreach ($topics as $topic) {
		array_push($context['topics'], array(
			'name' => $topic->name,
			'slug' => $topic->slug
		));
		array_push($topic_slugs, $topic->slug);
	}
}

// Every resource must be tagged
$context['related_resources'] = array(
	'related_carousel'	=> true,
	'quantity' 					=> (int)$related_quantity,
	'resource_type' 		=> $type_slug,
	'resource_topic' 		=> $topic_slugs,
	'exclude' 					=> $post->id
);

// Did user select some manual posts?
$manual = $context['acf']['manual_posts'];
if ( isset($manual) && is_array($manual) ) {
	$context['related_resources']['manual_posts'] = $manual;
}

// Author
$author = $context['acf']['author'];
if ( isset($author) && is_object($author) ) {
	$author = Timber::get_post($author);
	$context['author']['name'] = $author->post_title;
	$context['author']['id'] = $author->id;
	$context['author']['slug'] = $author->slug;
	$context['author']['photo'] = serveSquareImage( $author->get_field('photo'), true )['xs'];
}

// Get Sidebar
$inherit = $context['acf']['inherit'];
$sidebar = $post->get_field('sidebar_sections');
if ($inherit) {
	$order = $context['acf']['order'];
	// Get inherited sidebar based on resource type
	$parents_sidebar = $type->resource_sidebar['sidebar_sections'];
	// If parents sidebar is not empty
	if ($parents_sidebar) {
		if ($sidebar) {
			$context['sidebar_sections'] = $order == 'parent' ? array_merge($parents_sidebar, $sidebar) : array_merge($sidebar, $parents_sidebar);
		} else {
			$context['sidebar_sections'] = $parents_sidebar;
		}
	} else {
		$context['sidebar_sections'] = $sidebar;
	}
} else {
	$context['sidebar_sections'] = $sidebar;
}

// TODO:
// If type is gallery or video, grab og:image

Timber::render( 'resource/single-resource.twig' , $context, 600 );
