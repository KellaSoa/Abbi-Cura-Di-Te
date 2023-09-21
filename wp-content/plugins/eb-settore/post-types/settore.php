<?php

/**
 * Registers the `settore` post type.
 */
function settore_init() {
	register_post_type(
		'settore',
		[
			'labels'                => [
				'name'                  => __( 'Settori e Mansioni', 'eb-settore' ),
				'singular_name'         => __( 'Settore', 'eb-settore' ),
				'all_items'             => __( 'Tutti i settori e mansioni', 'eb-settore' ),
				'archives'              => __( 'Settore Archives', 'eb-settore' ),
				'attributes'            => __( 'Settore Attributes', 'eb-settore' ),
				'insert_into_item'      => __( 'Insert into settore', 'eb-settore' ),
				'uploaded_to_this_item' => __( 'Uploaded to this settore', 'eb-settore' ),
				'featured_image'        => _x( 'Featured Image', 'settore', 'eb-settore' ),
				'set_featured_image'    => _x( 'Set featured image', 'settore', 'eb-settore' ),
				'remove_featured_image' => _x( 'Remove featured image', 'settore', 'eb-settore' ),
				'use_featured_image'    => _x( 'Use as featured image', 'settore', 'eb-settore' ),
				'filter_items_list'     => __( 'Filter settores list', 'eb-settore' ),
				'items_list_navigation' => __( 'Settores list navigation', 'eb-settore' ),
				'items_list'            => __( 'Settores list', 'eb-settore' ),
				'new_item'              => __( 'New Settore', 'eb-settore' ),
				'add_new'               => __( 'Add New', 'eb-settore' ),
				'add_new_item'          => __( 'Add New Settore', 'eb-settore' ),
				'edit_item'             => __( 'Edit Settore', 'eb-settore' ),
				'view_item'             => __( 'View Settore', 'eb-settore' ),
				'view_items'            => __( 'View Settores', 'eb-settore' ),
				'search_items'          => __( 'Cerca Settore', 'eb-settore' ),
				'not_found'             => __( 'No settores found', 'eb-settore' ),
				'not_found_in_trash'    => __( 'No settores found in trash', 'eb-settore' ),
				'parent_item_colon'     => __( 'Parent Settore:', 'eb-settore' ),
				'menu_name'             => __( 'Settori e Mansioni', 'eb-settore' ),
			],
			'public'                => true,
			'hierarchical'          => true,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', "page-attributes" ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-groups',
			'show_in_rest'          => true,
			'rest_base'             => 'settore',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'settore_init' );

/**
 * Sets the post updated messages for the `settore` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `settore` post type.
 */
function settore_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['settore'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Settore updated. <a target="_blank" href="%s">View settore</a>', 'eb-settore' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'eb-settore' ),
		3  => __( 'Custom field deleted.', 'eb-settore' ),
		4  => __( 'Settore updated.', 'eb-settore' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Settore restored to revision from %s', 'eb-settore' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Settore published. <a href="%s">View settore</a>', 'eb-settore' ), esc_url( $permalink ) ),
		7  => __( 'Settore saved.', 'eb-settore' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Settore submitted. <a target="_blank" href="%s">Preview settore</a>', 'eb-settore' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Settore scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview settore</a>', 'eb-settore' ), date_i18n( __( 'M j, Y @ G:i', 'eb-settore' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Settore draft updated. <a target="_blank" href="%s">Preview settore</a>', 'eb-settore' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'settore_updated_messages' );

/**
 * Sets the bulk post updated messages for the `settore` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `settore` post type.
 */
function settore_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['settore'] = [
		/* translators: %s: Number of settores. */
		'updated'   => _n( '%s settore updated.', '%s settores updated.', $bulk_counts['updated'], 'eb-settore' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 settore not updated, somebody is editing it.', 'eb-settore' ) :
						/* translators: %s: Number of settores. */
						_n( '%s settore not updated, somebody is editing it.', '%s settores not updated, somebody is editing them.', $bulk_counts['locked'], 'eb-settore' ),
		/* translators: %s: Number of settores. */
		'deleted'   => _n( '%s settore permanently deleted.', '%s settores permanently deleted.', $bulk_counts['deleted'], 'eb-settore' ),
		/* translators: %s: Number of settores. */
		'trashed'   => _n( '%s settore moved to the Trash.', '%s settores moved to the Trash.', $bulk_counts['trashed'], 'eb-settore' ),
		/* translators: %s: Number of settores. */
		'untrashed' => _n( '%s settore restored from the Trash.', '%s settores restored from the Trash.', $bulk_counts['untrashed'], 'eb-settore' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'settore_bulk_updated_messages', 10, 2 );
