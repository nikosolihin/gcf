<?php
/*=============================================*/
/* Change the default template name
/*=============================================*/
add_filter('default_page_template_title', function() {
  $screen = get_current_screen();
  if( $screen->post_type == 'page' ) {
    return __('With Sidebar', 'gcf');
  }
});

/*=============================================*/
/* Change "Enter title here" based on CPT
/*=============================================*/
function post_type_change_title_text( $title ){
  $screen = get_current_screen();
  if( 'page' == $screen->post_type) {
    $title = "Enter page title";
  }
  if( 'person' == $screen->post_type) {
    $title = "Enter person full name";
  }
  if( 'resource' == $screen->post_type) {
    $title = "Enter resource title";
  }
  if( 'block' == $screen->post_type) {
    $title = "Enter block title";
  }
  return $title;
}
add_filter( 'enter_title_here', 'post_type_change_title_text' );
