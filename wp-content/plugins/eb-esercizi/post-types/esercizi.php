<?php

/**
 * Registers the `esercizi` post type.
 */
function esercizi_init() {
	register_post_type(
		'esercizi',
		[
			'labels'                => [
				'name'                  => __( 'Esercizi', 'eb-esercizi' ),
				'singular_name'         => __( 'Esercizi', 'eb-esercizi' ),
				'all_items'             => __( 'All Esercizi', 'eb-esercizi' ),
				'archives'              => __( 'Esercizi Archives', 'eb-esercizi' ),
				'attributes'            => __( 'Esercizi Attributes', 'eb-esercizi' ),
				'insert_into_item'      => __( 'Insert into esercizi', 'eb-esercizi' ),
				'uploaded_to_this_item' => __( 'Uploaded to this esercizi', 'eb-esercizi' ),
				'featured_image'        => _x( 'Featured Image', 'esercizi', 'eb-esercizi' ),
				'set_featured_image'    => _x( 'Set featured image', 'esercizi', 'eb-esercizi' ),
				'remove_featured_image' => _x( 'Remove featured image', 'esercizi', 'eb-esercizi' ),
				'use_featured_image'    => _x( 'Use as featured image', 'esercizi', 'eb-esercizi' ),
				'filter_items_list'     => __( 'Filter esercizis list', 'eb-esercizi' ),
				'items_list_navigation' => __( 'Esercizis list navigation', 'eb-esercizi' ),
				'items_list'            => __( 'Esercizis list', 'eb-esercizi' ),
				'new_item'              => __( 'New Esercizi', 'eb-esercizi' ),
				'add_new'               => __( 'Add New', 'eb-esercizi' ),
				'add_new_item'          => __( 'Add New Esercizi', 'eb-esercizi' ),
				'edit_item'             => __( 'Edit Esercizi', 'eb-esercizi' ),
				'view_item'             => __( 'View Esercizi', 'eb-esercizi' ),
				'view_items'            => __( 'View Esercizis', 'eb-esercizi' ),
				'search_items'          => __( 'Search esercizis', 'eb-esercizi' ),
				'not_found'             => __( 'No esercizis found', 'eb-esercizi' ),
				'not_found_in_trash'    => __( 'No esercizis found in trash', 'eb-esercizi' ),
				'parent_item_colon'     => __( 'Parent Esercizi:', 'eb-esercizi' ),
				'menu_name'             => __( 'Esercizi', 'eb-esercizi' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title','editor' ],
			'has_archive'           => false,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => false,
			'rest_base'             => 'esercizi',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'esercizi_init' );

/**
 * Sets the post updated messages for the `esercizi` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `esercizi` post type.
 */
function esercizi_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['esercizi'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Esercizi updated. <a target="_blank" href="%s">View esercizi</a>', 'eb-esercizi' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'eb-esercizi' ),
		3  => __( 'Custom field deleted.', 'eb-esercizi' ),
		4  => __( 'Esercizi updated.', 'eb-esercizi' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Esercizi restored to revision from %s', 'eb-esercizi' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Esercizi published. <a href="%s">View esercizi</a>', 'eb-esercizi' ), esc_url( $permalink ) ),
		7  => __( 'Esercizi saved.', 'eb-esercizi' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Esercizi submitted. <a target="_blank" href="%s">Preview esercizi</a>', 'eb-esercizi' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Esercizi scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview esercizi</a>', 'eb-esercizi' ), date_i18n( __( 'M j, Y @ G:i', 'eb-esercizi' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Esercizi draft updated. <a target="_blank" href="%s">Preview esercizi</a>', 'eb-esercizi' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'esercizi_updated_messages' );

/**
 * Sets the bulk post updated messages for the `esercizi` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `esercizi` post type.
 */
function esercizi_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['esercizi'] = [
		/* translators: %s: Number of esercizis. */
		'updated'   => _n( '%s esercizi updated.', '%s esercizis updated.', $bulk_counts['updated'], 'eb-esercizi' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 esercizi not updated, somebody is editing it.', 'eb-esercizi' ) :
						/* translators: %s: Number of esercizis. */
						_n( '%s esercizi not updated, somebody is editing it.', '%s esercizis not updated, somebody is editing them.', $bulk_counts['locked'], 'eb-esercizi' ),
		/* translators: %s: Number of esercizis. */
		'deleted'   => _n( '%s esercizi permanently deleted.', '%s esercizis permanently deleted.', $bulk_counts['deleted'], 'eb-esercizi' ),
		/* translators: %s: Number of esercizis. */
		'trashed'   => _n( '%s esercizi moved to the Trash.', '%s esercizis moved to the Trash.', $bulk_counts['trashed'], 'eb-esercizi' ),
		/* translators: %s: Number of esercizis. */
		'untrashed' => _n( '%s esercizi restored from the Trash.', '%s esercizis restored from the Trash.', $bulk_counts['untrashed'], 'eb-esercizi' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'esercizi_bulk_updated_messages', 10, 2 );
