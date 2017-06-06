<?php
//=============================================
// Allow meta field to be queried in WP-API
// Based on https://1fix.io/blog/2015/07/20/query-vars-wp-api/
// Note: this function must be pair with
// https://github.com/WP-API/rest-filter
//=============================================
function allow_meta_query( $valid_vars ) {
  $valid_vars = array_merge( $valid_vars, array( 'meta_key', 'meta_value', 'meta_compare' ));
  return $valid_vars;
}
add_filter( 'rest_query_vars', 'allow_meta_query' );

//=============================================
// Add authors as a URL query param in the API
//=============================================
add_filter( 'rest_resource_query', function( $args ) {
  if (!empty($_GET['author'])) {
    $args['meta_query'] = array(
  		array(
  			'key'      => 'author',
  			'value'    => esc_sql( $_GET['author'] ),
        'compare'  => 'LIKE',
  		)
  	);
  }
  return $args;
});

//=============================================
// Add ACF fields to GraphQL
//=============================================
// function register_resource_acf_fields( $fields ) {
//   // $config = array(
//   //   'name'          => 'ACFFields',
//   //   'fields'        => array(
//   //     'fieldOne' => array(
//   //       'type'        => WPGraphQL\Types::string(),
//   //       'description' => __( 'The field of interest', 'gcf-graphql' ),
//   //       'resolve'     => function( $acf, array $args, $context, $info ) {
//   //         // $field = ( is_array( $fields ) && ! empty( $fields[0] ) ) ? $edit_lock[0] : null;
//   //         // return ! empty( $time ) ? date( 'Y-m-d H:i:s', $time ) : null;
//   //         return "This is a test";
//   //       }
//   //     )
//   //   )
//   // );
//   $fields['acf'] = array(
//     // 'type'          => new GraphQL\Type\Definition\ObjectType( $config ),
//     'type'          => \WPGraphQL\Types::string(),
//     'description'   => __( 'ACF fields registered to this post item', 'gcf-graphql' ),
//     'resolve'       => function( \WP_Post $post, array $args, $context, $info ) {
//       $acf =  json_encode( get_fields( $post->ID ) );
//       return ! empty( $acf ) ? $acf : null;
//     }
//   );
//   return $fields;
// }
// add_filter( 'graphql_resource_fields', 'register_resource_acf_fields' );
