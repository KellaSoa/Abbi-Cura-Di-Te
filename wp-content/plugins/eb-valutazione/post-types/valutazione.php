<?php

/**
 * Registers the `valutazione` post type.
 */
function valutazione_init() {
	register_post_type(
		'valutazione',
		[
			'labels'                => [
				'name'                  => __( 'Valutazioni', 'eb-valutazione' ),
				'singular_name'         => __( 'Valutazione', 'eb-valutazione' ),
				'all_items'             => __( 'Tutte le valutazioni', 'eb-valutazione' ),
				'archives'              => __( 'Valutazione Archives', 'eb-valutazione' ),
				'attributes'            => __( 'Valutazione Attributes', 'eb-valutazione' ),
				'insert_into_item'      => __( 'Insert into valutazione', 'eb-valutazione' ),
				'uploaded_to_this_item' => __( 'Uploaded to this valutazione', 'eb-valutazione' ),
				'featured_image'        => _x( 'Featured Image', 'valutazione', 'eb-valutazione' ),
				'set_featured_image'    => _x( 'Set featured image', 'valutazione', 'eb-valutazione' ),
				'remove_featured_image' => _x( 'Remove featured image', 'valutazione', 'eb-valutazione' ),
				'use_featured_image'    => _x( 'Use as featured image', 'valutazione', 'eb-valutazione' ),
				'filter_items_list'     => __( 'Filter valutaziones list', 'eb-valutazione' ),
				'items_list_navigation' => __( 'Valutaziones list navigation', 'eb-valutazione' ),
				'items_list'            => __( 'Valutaziones list', 'eb-valutazione' ),
				'new_item'              => __( 'New Valutazione', 'eb-valutazione' ),
				'add_new'               => __( 'Add New', 'eb-valutazione' ),
				'add_new_item'          => __( 'Add New Valutazione', 'eb-valutazione' ),
				'edit_item'             => __( 'Edit Valutazione', 'eb-valutazione' ),
				'view_item'             => __( 'View Valutazione', 'eb-valutazione' ),
				'view_items'            => __( 'Vedi valutazione', 'eb-valutazione' ),
				'search_items'          => __( 'Cerca valutazione', 'eb-valutazione' ),
				'not_found'             => __( 'Non sono state trovate valutazioni', 'eb-valutazione' ),
				'not_found_in_trash'    => __( 'Non sono state trovate valutazioni nel cestino', 'eb-valutazione' ),
				'parent_item_colon'     => __( 'Parent Valutazione:', 'eb-valutazione' ),
				'menu_name'             => __( 'Valutazioni', 'eb-valutazione' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-media-default',
			'show_in_rest'          => false,
			'rest_base'             => 'valutazione',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'valutazione_init' );

/**
 * Sets the post updated messages for the `valutazione` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `valutazione` post type.
 */
function valutazione_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['valutazione'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Valutazione updated. <a target="_blank" href="%s">View valutazione</a>', 'eb-valutazione' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'eb-valutazione' ),
		3  => __( 'Custom field deleted.', 'eb-valutazione' ),
		4  => __( 'Valutazione updated.', 'eb-valutazione' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Valutazione restored to revision from %s', 'eb-valutazione' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Valutazione published. <a href="%s">View valutazione</a>', 'eb-valutazione' ), esc_url( $permalink ) ),
		7  => __( 'Valutazione saved.', 'eb-valutazione' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Valutazione submitted. <a target="_blank" href="%s">Preview valutazione</a>', 'eb-valutazione' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Valutazione scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview valutazione</a>', 'eb-valutazione' ), date_i18n( __( 'M j, Y @ G:i', 'eb-valutazione' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Valutazione draft updated. <a target="_blank" href="%s">Preview valutazione</a>', 'eb-valutazione' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'valutazione_updated_messages' );

/**
 * Sets the bulk post updated messages for the `valutazione` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `valutazione` post type.
 */
function valutazione_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['valutazione'] = [
		/* translators: %s: Number of valutaziones. */
		'updated'   => _n( '%s valutazione updated.', '%s valutaziones updated.', $bulk_counts['updated'], 'eb-valutazione' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 valutazione not updated, somebody is editing it.', 'eb-valutazione' ) :
						/* translators: %s: Number of valutaziones. */
						_n( '%s valutazione not updated, somebody is editing it.', '%s valutaziones not updated, somebody is editing them.', $bulk_counts['locked'], 'eb-valutazione' ),
		/* translators: %s: Number of valutaziones. */
		'deleted'   => _n( '%s valutazione permanently deleted.', '%s valutaziones permanently deleted.', $bulk_counts['deleted'], 'eb-valutazione' ),
		/* translators: %s: Number of valutaziones. */
		'trashed'   => _n( '%s valutazione moved to the Trash.', '%s valutaziones moved to the Trash.', $bulk_counts['trashed'], 'eb-valutazione' ),
		/* translators: %s: Number of valutaziones. */
		'untrashed' => _n( '%s valutazione restored from the Trash.', '%s valutaziones restored from the Trash.', $bulk_counts['untrashed'], 'eb-valutazione' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'valutazione_bulk_updated_messages', 10, 2 );
