<?php

/**
 * Registers the `test` post type.
 */
function test_init() {
	register_post_type(
		'test',
		[
			'labels'                => [
				'name'                  => __( 'Test', 'eb-test' ),
				'singular_name'         => __( 'Test', 'eb-test' ),
				'all_items'             => __( 'Tutti i test', 'eb-test' ),
				'archives'              => __( 'Test Archives', 'eb-test' ),
				'attributes'            => __( 'Test Attributes', 'eb-test' ),
				'insert_into_item'      => __( 'Insert into test', 'eb-test' ),
				'uploaded_to_this_item' => __( 'Uploaded to this test', 'eb-test' ),
				'featured_image'        => _x( 'Featured Image', 'test', 'eb-test' ),
				'set_featured_image'    => _x( 'Set featured image', 'test', 'eb-test' ),
				'remove_featured_image' => _x( 'Remove featured image', 'test', 'eb-test' ),
				'use_featured_image'    => _x( 'Use as featured image', 'test', 'eb-test' ),
				'filter_items_list'     => __( 'Filter tests list', 'eb-test' ),
				'items_list_navigation' => __( 'Tests list navigation', 'eb-test' ),
				'items_list'            => __( 'Tests list', 'eb-test' ),
				'new_item'              => __( 'New Test', 'eb-test' ),
				'add_new'               => __( 'Add New', 'eb-test' ),
				'add_new_item'          => __( 'Add New Test', 'eb-test' ),
				'edit_item'             => __( 'Edit Test', 'eb-test' ),
				'view_item'             => __( 'View Test', 'eb-test' ),
				'view_items'            => __( 'View Tests', 'eb-test' ),
				'search_items'          => __( 'Search tests', 'eb-test' ),
				'not_found'             => __( 'No tests found', 'eb-test' ),
				'not_found_in_trash'    => __( 'No tests found in trash', 'eb-test' ),
				'parent_item_colon'     => __( 'Parent Test:', 'eb-test' ),
				'menu_name'             => __( 'Test', 'eb-test' ),
			],
			'public'                => true,    
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title' ],
			'has_archive'           => false,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => false,
			'rest_base'             => 'test',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'test_init' );

/**
 * Sets the post updated messages for the `test` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `test` post type.
 */
function test_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['test'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Test updated. <a target="_blank" href="%s">View test</a>', 'eb-test' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'eb-test' ),
		3  => __( 'Custom field deleted.', 'eb-test' ),
		4  => __( 'Test updated.', 'eb-test' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Test restored to revision from %s', 'eb-test' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Test published. <a href="%s">View test</a>', 'eb-test' ), esc_url( $permalink ) ),
		7  => __( 'Test saved.', 'eb-test' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Test submitted. <a target="_blank" href="%s">Preview test</a>', 'eb-test' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Test scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview test</a>', 'eb-test' ), date_i18n( __( 'M j, Y @ G:i', 'eb-test' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Test draft updated. <a target="_blank" href="%s">Preview test</a>', 'eb-test' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'test_updated_messages' );

/**
 * Sets the bulk post updated messages for the `test` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `test` post type.
 */
function test_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['test'] = [
		/* translators: %s: Number of tests. */
		'updated'   => _n( '%s test updated.', '%s tests updated.', $bulk_counts['updated'], 'eb-test' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 test not updated, somebody is editing it.', 'eb-test' ) :
						/* translators: %s: Number of tests. */
						_n( '%s test not updated, somebody is editing it.', '%s tests not updated, somebody is editing them.', $bulk_counts['locked'], 'eb-test' ),
		/* translators: %s: Number of tests. */
		'deleted'   => _n( '%s test permanently deleted.', '%s tests permanently deleted.', $bulk_counts['deleted'], 'eb-test' ),
		/* translators: %s: Number of tests. */
		'trashed'   => _n( '%s test moved to the Trash.', '%s tests moved to the Trash.', $bulk_counts['trashed'], 'eb-test' ),
		/* translators: %s: Number of tests. */
		'untrashed' => _n( '%s test restored from the Trash.', '%s tests restored from the Trash.', $bulk_counts['untrashed'], 'eb-test' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'test_bulk_updated_messages', 10, 2 );
