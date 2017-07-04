<?php
/**
 * Description: Page template for default pages
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['acf'] = get_fields();
$context['sections'] = $context['acf']['sections'];
$context['toc'] = $post->get_field('toc');

// Get Sidebar
$inherit = ($context['acf']['inherit']);
$sidebar = $post->get_field('sidebar_sections');
if ($inherit) {
	$order = $context['acf']['order'];
	$parent = $post->get_parent();
	$parents_sidebar = $parent->get_field('sidebar_sections');
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

// Generate breadcrumb. Must be last.
// $context['breadcrumb'] = array();
// while( $post->get_parent ) {
// 	$post = $post->get_parent();
// 	array_push( $context['breadcrumb'], array(
//     'title' => $post->title,
//     'link' => $post->link
//   ));
// }
// $context['breadcrumb'] = array_reverse( $context['breadcrumb'] );
//
// if(isset($context['breadcrumb'][0]) && is_array($context['breadcrumb'][0])) {
// 	if($context['breadcrumb'][0]['title'] == 'Stories') {
// 		$context['is_stories'] = true;
// 	}
// }

Timber::render( 'page/single-page.twig' , $context, 600);
