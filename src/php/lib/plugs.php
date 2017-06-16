<?php

//=============================================
// Radio Button for Taxonomies
//=============================================
// Disable the "No term" option on a the "resource_type" taxonomy
add_filter( "radio-buttons-for-taxonomies-no-term-resource_type", "__return_FALSE" );

//==========================================================
// Admin Columns Pro
// Use the following code so column settings
// apply to multisites
//
// Turn on only on prod (i.e. before pushing)
//==========================================================
add_action( 'init', 'ac_custom_column_settings_3628c532' );
function ac_custom_column_settings_3628c532() {
	if ( function_exists( 'ac_register_columns' ) ) {
		ac_register_columns( 'page', array(
			array(
				'columns' => array(
					'title' => array(
						'column-name' => 'title',
						'type' => 'title',
						'clone' => '',
						'label' => 'Title',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off',
						'sort' => 'on'
					),
			'column-acf_field' => array(
						'column-name' => 'column-acf_field',
						'type' => 'column-acf_field',
						'clone' => '',
						'label' => 'Note',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_5773959af7881',
						'excerpt_length' => '150',
						'edit' => 'on',
						'sort' => 'off'
					)
				),
				'layout' => array(
					'id' => '5943b7d9706c7',
					'name' => 'Display Notes',
					'roles' => '',
					'users' => ''
				)

			),
			array(
				'columns' => array(
					'column-order' => array(
						'column-name' => 'column-order',
						'type' => 'column-order',
						'clone' => '',
						'label' => 'Order',
						'width' => '5',
						'width_unit' => '%',
						'edit' => 'off',
						'sort' => 'on'
					),
			'title' => array(
						'column-name' => 'title',
						'type' => 'title',
						'clone' => '',
						'label' => 'Title',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off',
						'sort' => 'on'
					),
			'column-parent' => array(
						'column-name' => 'column-parent',
						'type' => 'column-parent',
						'clone' => '',
						'label' => 'Parent',
						'width' => '10',
						'width_unit' => '%',
						'edit' => 'off',
						'filter' => 'off',
						'sort' => 'on'
					),
			'column-acf_field' => array(
						'column-name' => 'column-acf_field',
						'type' => 'column-acf_field',
						'clone' => '',
						'label' => 'Overview',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_576ce022e631e',
						'excerpt_length' => '15',
						'edit' => 'off',
						'sort' => 'off'
					),
			'column-page_template' => array(
						'column-name' => 'column-page_template',
						'type' => 'column-page_template',
						'clone' => '',
						'label' => 'Template',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off',
						'filter' => 'off',
						'sort' => 'on'
					),
			'column-modified' => array(
						'column-name' => 'column-modified',
						'type' => 'column-modified',
						'clone' => '',
						'label' => 'Last Modified',
						'width' => '',
						'width_unit' => '%',
						'date_format' => 'M j, Y',
						'sort' => 'on'
					)
				),
				'layout' => array(
					'id' => '',
					'name' => 'Default View',
					'roles' => '',
					'users' => ''
				)
			)
		) );
		ac_register_columns( 'resource', array(
			array(
				'columns' => array(
					'title' => array(
						'column-name' => 'title',
						'type' => 'title',
						'clone' => '',
						'label' => 'Title',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off',
						'sort' => 'on'
					),
			'column-acf_field-1' => array(
						'column-name' => 'column-acf_field-1',
						'type' => 'column-acf_field',
						'clone' => '1',
						'label' => 'Note',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_5773959af7881',
						'excerpt_length' => '150',
						'edit' => 'on',
						'sort' => 'off'
					)
				),
				'layout' => array(
					'id' => '5943b902d9eb3',
					'name' => 'Display Notes',
					'roles' => '',
					'users' => ''
				)

			),
			array(
				'columns' => array(
					'title' => array(
						'column-name' => 'title',
						'type' => 'title',
						'clone' => '',
						'label' => 'Title',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off',
						'sort' => 'on'
					),
			'column-taxonomy' => array(
						'column-name' => 'column-taxonomy',
						'type' => 'column-taxonomy',
						'clone' => '',
						'label' => 'Type',
						'width' => '',
						'width_unit' => '%',
						'taxonomy' => 'resource_type',
						'edit' => 'off',
						'enable_term_creation' => 'off',
						'filter' => 'on',
						'sort' => 'on'
					),
			'column-taxonomy-1' => array(
						'column-name' => 'column-taxonomy-1',
						'type' => 'column-taxonomy',
						'clone' => '1',
						'label' => 'Topics',
						'width' => '',
						'width_unit' => '%',
						'taxonomy' => 'resource_topic',
						'edit' => 'off',
						'enable_term_creation' => 'off',
						'filter' => 'on',
						'sort' => 'on'
					),
			'column-acf_field' => array(
						'column-name' => 'column-acf_field',
						'type' => 'column-acf_field',
						'clone' => '',
						'label' => 'Author(s)',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_578898cbf1122',
						'edit' => 'off',
						'filter' => 'off',
						'sort' => 'on'
					),
			'column-acf_field-1' => array(
						'column-name' => 'column-acf_field-1',
						'type' => 'column-acf_field',
						'clone' => '1',
						'label' => 'Overview',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_576ce022e631e',
						'excerpt_length' => '7',
						'edit' => 'off',
						'sort' => 'off'
					),
			'column-date_published' => array(
						'column-name' => 'column-date_published',
						'type' => 'column-date_published',
						'clone' => '',
						'label' => 'Date Published',
						'width' => '',
						'width_unit' => '%',
						'date_format' => 'M j, Y',
						'edit' => 'off',
						'sort' => 'on'
					)
				),
				'layout' => array(
					'id' => '',
					'name' => 'Default View',
					'roles' => '',
					'users' => ''
				)
			)
		) );
		ac_register_columns( 'person', array(
			array(
				'columns' => array(
					'title' => array(
						'column-name' => 'title',
						'type' => 'title',
						'clone' => '',
						'label' => 'Name',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off',
						'sort' => 'on'
					),
			'column-acf_field' => array(
						'column-name' => 'column-acf_field',
						'type' => 'column-acf_field',
						'clone' => '',
						'label' => 'Email',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_575faa4800735',
						'edit' => 'off',
						'filter' => 'off',
						'sort' => 'on'
					),
			'column-acf_field-1' => array(
						'column-name' => 'column-acf_field-1',
						'type' => 'column-acf_field',
						'clone' => '1',
						'label' => 'Title',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_575faacb00736',
						'edit' => 'off',
						'filter' => 'off',
						'sort' => 'on'
					),
			'column-acf_field-2' => array(
						'column-name' => 'column-acf_field-2',
						'type' => 'column-acf_field',
						'clone' => '2',
						'label' => 'Location',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_575fac82597e1',
						'edit' => 'off',
						'filter' => 'off',
						'sort' => 'on'
					),
			'column-taxonomy' => array(
						'column-name' => 'column-taxonomy',
						'type' => 'column-taxonomy',
						'clone' => '',
						'label' => 'Role',
						'width' => '',
						'width_unit' => '%',
						'taxonomy' => 'role',
						'edit' => 'off',
						'enable_term_creation' => 'off',
						'filter' => 'on',
						'sort' => 'on'
					)
				),
			)
		) );
		ac_register_columns( 'block', array(
			array(
				'columns' => array(
					'title' => array(
						'column-name' => 'title',
						'type' => 'title',
						'clone' => '',
						'label' => 'Title',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off',
						'sort' => 'on'
					),
			'column-acf_field' => array(
						'column-name' => 'column-acf_field',
						'type' => 'column-acf_field',
						'clone' => '',
						'label' => 'Description',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_589c3344f996c',
						'edit' => 'off',
						'filter' => 'off',
						'sort' => 'off'
					)
				),
			)
		) );
		ac_register_columns( 'wp-taxonomy_resource_type', array(
			array(
				'columns' => array(
					'name' => array(
						'column-name' => 'name',
						'type' => 'name',
						'clone' => '',
						'label' => 'Name',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off'
					),
			'slug' => array(
						'column-name' => 'slug',
						'type' => 'slug',
						'clone' => '',
						'label' => 'Slug',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off'
					),
			'column-acf_field' => array(
						'column-name' => 'column-acf_field',
						'type' => 'column-acf_field',
						'clone' => '',
						'label' => 'Color',
						'width' => '',
						'width_unit' => '%',
						'field' => 'field_57d64fab2d7a8',
						'edit' => 'off'
					),
			'posts' => array(
						'column-name' => 'posts',
						'type' => 'posts',
						'clone' => '',
						'label' => 'Item Count',
						'width' => '',
						'width_unit' => '%'
					)
				),
			)
		) );
		ac_register_columns( 'wp-taxonomy_resource_topic', array(
			array(
				'columns' => array(
					'name' => array(
						'column-name' => 'name',
						'type' => 'name',
						'clone' => '',
						'label' => 'Name',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off'
					),
			'slug' => array(
						'column-name' => 'slug',
						'type' => 'slug',
						'clone' => '',
						'label' => 'Slug',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off'
					),
			'posts' => array(
						'column-name' => 'posts',
						'type' => 'posts',
						'clone' => '',
						'label' => 'Item Count',
						'width' => '',
						'width_unit' => '%'
					)
				),
			)
		) );
		ac_register_columns( 'wp-taxonomy_role', array(
			array(
				'columns' => array(
					'name' => array(
						'column-name' => 'name',
						'type' => 'name',
						'clone' => '',
						'label' => 'Name',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off'
					),
			'slug' => array(
						'column-name' => 'slug',
						'type' => 'slug',
						'clone' => '',
						'label' => 'Slug',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off'
					),
			'description' => array(
						'column-name' => 'description',
						'type' => 'description',
						'clone' => '',
						'label' => 'Description',
						'width' => '',
						'width_unit' => '%',
						'edit' => 'off'
					),
			'posts' => array(
						'column-name' => 'posts',
						'type' => 'posts',
						'clone' => '',
						'label' => 'People Count',
						'width' => '',
						'width_unit' => '%'
					)
				),
			)
		) );
	}
}
