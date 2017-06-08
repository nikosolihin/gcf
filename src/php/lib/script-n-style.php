<?php
//=============================================
// Register dashboard style
//=============================================
function gcf_admin_styles() {
	wp_deregister_style( 'gcf-admin-style' );
	wp_register_style( 'gcf-admin-style', get_template_directory_uri() . '/dashboard/custom-style.css', false, '1.0.1' );
	wp_enqueue_style( 'gcf-admin-style' );
}
add_action( 'login_head', 'gcf_admin_styles' ); // For login logo
add_action( 'admin_enqueue_scripts', 'gcf_admin_styles' );

//=============================================
// Register dashboard script
//=============================================
function gcf_admin_scripts() {
	wp_deregister_script( 'gcf-admin-script' );
	wp_register_script( 'gcf-admin-script', get_template_directory_uri() . '/dashboard/custom-script.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'gcf-admin-script' );
}
add_action( 'admin_enqueue_scripts', 'gcf_admin_scripts' );
