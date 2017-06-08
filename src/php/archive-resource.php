<?php
/**
 * The template for resource archive
 */
$context = Timber::get_context();

$context['title'] = get_field('resource_title', 'option');
$context['subtitle'] = get_field('resource_subtitle', 'option');
$context['teaser'] = get_field('resource_teaser', 'option');
$context['wp_title'] = __('Resource Library', 'gcf');
$context['body_class'] = 'archive';
$context['on_word'] = __('on', 'gcf');
$context['by_word'] = __('By', 'gcf');
$context['published_word'] = __('Published', 'gcf');
$context['empty_msg'] = __('No resources found using the search criterias you defined. Please try again.', 'gcf');
$context['ppp'] = get_field('resource_listing_ppp', 'option');

// Get all types to be passed to resource.js
$context['all_types'] = array();
foreach (Timber::get_terms('resource_type') as $type) {
  $context['all_types'][$type->id] = array(
    'name' => $type->name,
    'slug' => $type->slug,
    'color' => $type->type_color
  );
}
$context['types_json'] = json_encode($context['all_types']);

// Get all topics to be passed to resource.js
$context['all_topics'] = array();
foreach (Timber::get_terms('resource_topic') as $topic) {
  $context['all_topics'][$topic->id] = array(
    'name' => $topic->name,
    'slug' => $topic->slug
  );
}
$context['topics_json'] = json_encode($context['all_topics']);

// Get all authors to be passed to resource.js
$context['all_authors'] = array();
$author_args = array(
  'post_type' => 'person',
  'tax_query' => array(
    array(
      'taxonomy' => 'role',
      'field' => 'slug',
      'terms' => array('author')
    )
  )
);
foreach (Timber::get_posts($author_args) as $author) {
  $context['all_authors'][$author->id] = array(
    'id' => $author->id,
    'name' => $author->name,
    'slug' => $author->slug,
    'photo' => serveSquareImage($author->get_field('photo'), true)['xs']
  );
}
$context['authors_json'] = json_encode($context['all_authors']);

// Get year boundaries
$oldest_args = 'post_type=resource&numberposts=1&order=asc';
$newest_args = 'post_type=resource&numberposts=1&order=desc';
$oldest = (int)Timber::get_post($oldest_args)->date('Y');
$newest = (int)Timber::get_post($newest_args)->date('Y');
$context['years'] = array();
if ($oldest != $newest) {
  for ($year = $oldest; $year <= $newest; $year++) {
    array_push($context['years'], $year);
  }
} else {
  array_push($context['years'], $newest);
}

Timber::render( 'resource/archive-resource.twig' , $context, 600 );
