<?php

/**
 * Registers the `area_rischio` taxonomy,
 * for use with 'test'.
 */
function area_rischio_init() {
	register_taxonomy( 'area-rischio', [ 'test','esercizi' ], [
		'hierarchical'          => false,
		'public'                => true,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'query_var'             => true,
		'rewrite'               => true,
		'capabilities'          => [
			'manage_terms' => 'edit_posts',
			'edit_terms'   => 'edit_posts',
			'delete_terms' => 'edit_posts',
			'assign_terms' => 'edit_posts',
		],
		'labels'                => [
			'name'                       => __( 'Area rischio', 'eb-test' ),
			'singular_name'              => _x( 'Area rischio', 'taxonomy general name', 'eb-test' ),
			'search_items'               => __( 'Search Area rischio', 'eb-test' ),
			'popular_items'              => __( 'Popular Area rischio', 'eb-test' ),
			'all_items'                  => __( 'All Area rischio', 'eb-test' ),
			'parent_item'                => __( 'Parent Area rischio', 'eb-test' ),
			'parent_item_colon'          => __( 'Parent Area rischio:', 'eb-test' ),
			'edit_item'                  => __( 'Edit Area rischio', 'eb-test' ),
			'update_item'                => __( 'Update Area rischio', 'eb-test' ),
			'view_item'                  => __( 'View Area rischio', 'eb-test' ),
			'add_new_item'               => __( 'Add New Area rischio', 'eb-test' ),
			'new_item_name'              => __( 'New Area rischio', 'eb-test' ),
			'separate_items_with_commas' => __( 'Separate area rischio with commas', 'eb-test' ),
			'add_or_remove_items'        => __( 'Add or remove area rischio', 'eb-test' ),
			'choose_from_most_used'      => __( 'Choose from the most used area rischio', 'eb-test' ),
			'not_found'                  => __( 'No area rischio found.', 'eb-test' ),
			'no_terms'                   => __( 'No area rischio', 'eb-test' ),
			'menu_name'                  => __( 'Area rischio', 'eb-test' ),
			'items_list_navigation'      => __( 'Area rischio list navigation', 'eb-test' ),
			'items_list'                 => __( 'Area rischio list', 'eb-test' ),
			'most_used'                  => _x( 'Most Used', 'area-rischio', 'eb-test' ),
			'back_to_items'              => __( '&larr; Back to Area rischio', 'eb-test' ),
		],
		'show_in_rest'          => true,
		'rest_base'             => 'area-rischio',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'meta_box_cb'           => 'cb_taxonomy_select_meta_box',
	] );

}

add_action( 'init', 'area_rischio_init' );

/**
 * Sets the post updated messages for the `area_rischio` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `area_rischio` taxonomy.
 */
function area_rischio_updated_messages( $messages ) {

	$messages['area-rischio'] = [
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Area rischio added.', 'eb-test' ),
		2 => __( 'Area rischio deleted.', 'eb-test' ),
		3 => __( 'Area rischio updated.', 'eb-test' ),
		4 => __( 'Area rischio not added.', 'eb-test' ),
		5 => __( 'Area rischio not updated.', 'eb-test' ),
		6 => __( 'Area rischio deleted.', 'eb-test' ),
	];

	return $messages;
}

add_filter( 'term_updated_messages', 'area_rischio_updated_messages' );
