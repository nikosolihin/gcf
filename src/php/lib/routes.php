<?php
// //=============================================
// // Search Page -
// // so /search doesn't lead to a page.
// //=============================================
// Routes::map('search', function($params){
//   Routes::load('search.php');
// });

//=============================================
// Event Archive
//=============================================
Routes::map('resources', function($params){
  Routes::load('archive-resource.php');
});
// Routes::map('resources/:type', function($params){
//   // Get all types
//   $routesCampuses = array();
//   foreach (Timber::get_terms('type') as $type) {
//     array_push($routesCampuses, $type->slug);
//   }
//
//   // If what comes after resources/ is a type,
//   // go to bookmarkable archive
//   if ( in_array($params['type'], $routesCampuses) ) {
//     $url = get_bloginfo('url').'/resources/?utf8=%E2%9C%93&type=' . $params['type'];
//     header("Location: $url");
//     exit();
//   } else {
//     // If what comes after resources/ is gibberish, 404
//     Routes::load('404.php');
//   }
// });

// //=============================================
// // News Archive
// //=============================================
// Routes::map('news', function($params){
//   Routes::load('archive-news.php');
// });
// Routes::map('news/:campus', function($params){
//   // Get all campuses
//   $routesCampuses = array();
//   foreach (Timber::get_terms('campus') as $campus) {
//     array_push($routesCampuses, $campus->slug);
//   }
//
//   // If what comes after news/ is a campus,
//   // go to bookmarkable archive
//   if ( in_array($params['campus'], $routesCampuses) ) {
//     $url = get_bloginfo('url').'/news/?utf8=%E2%9C%93&date=desc&pg=1&campus=' . $params['campus'];
//     header("Location: $url");
//     exit();
//   } else {
//     // If what comes after news/ is gibberish, 404
//     Routes::load('404.php');
//   }
// });
//
// //=============================================
// // Campus
// //=============================================
// Routes::map('campuses/:location/', function($params){
//   // Get all campuses
//   $routesCampuses = array();
//   foreach (Timber::get_terms('campus') as $campus) {
//     array_push($routesCampuses, $campus->slug);
//   }
//
//   // Check if we have a valid campus location
//   if ( in_array($params['location'], $routesCampuses) ) {
//     $params['section'] = 'welcome';
//     Routes::load('single-campus.php', $params);
//   } else {
//     Routes::load('404.php');
//   }
// });
// Routes::map('campuses/:location/:section', function($params){
//   $params['body_class'] = 'single-campus';
//
//   // Get all campus page sections
//   $routesSection = array('welcome', 'details', 'facilities');
//
//   // Get all campuses
//   $routesCampuses = array();
//   foreach (Timber::get_terms('campus') as $campus) {
//     array_push($routesCampuses, $campus->slug);
//   }
//
//   // Check if we have a valid campus location and section
//   if ( in_array($params['location'], $routesCampuses) && in_array($params['section'], $routesSection) ) {
//     Routes::load('single-campus.php', $params);
//   } else {
//     Routes::load('404.php');
//   }
// });
