<?php


/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Collection Taxonomy
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Provides the `collection` taxonomy used to create an archive of posts that are part of a series, theme, or similar.
 * Version:           1.1.2
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


namespace Kntnt\Collection;


defined( 'ABSPATH' ) && new Taxonomy;


class Taxonomy {

	public function __construct() {
		add_action( 'init', [ $this, 'run' ] );
	}

	public function run() {

		$slug = apply_filters( 'kntnt-taxonomy-collection-slug', 'collection' );
		$post_types = apply_filters( 'kntnt-taxonomy-collection-objects', [ 'post' ] );

		register_taxonomy( $slug, null, $this->taxonomy( $slug ) );

		foreach ( $post_types as $post_type ) {
			register_taxonomy_for_object_type( $slug, $post_type );
		}

		add_filter( 'term_updated_messages', [ $this, 'term_updated_messages' ] );

	}

	private function taxonomy() {
		return [

			// A short descriptive summary of what the taxonomy is for.
			'description' => _x( 'Collections is a taxonomy used as post metadata. Its terms denote a collection of posts, for instance an article serie. All posts that share a term form a collection.', 'Description', 'kntnt-taxonomy-collection' ),

			// Whether the taxonomy is hierarchical.
			'hierarchical' => false,

			// Whether a taxonomy is intended for use publicly either via
			// the admin interface or by front-end users.
			'public' => true,

			// Whether the taxonomy is publicly queryable.
			'publicly_queryable' => true,

			// Whether to generate and allow a UI for managing terms in this
			// taxonomy in the admin.
			'show_ui' => true,

			// Whether to show the taxonomy in the admin menu.
			'show_in_menu' => true,

			// Makes this taxonomy available for selection in navigation menus.
			'show_in_nav_menus' => true,

			// Whether to list the taxonomy in the Tag Cloud Widget controls.
			'show_tagcloud' => true,

			// Whether to show the taxonomy in the quick/bulk edit panel.
			'show_in_quick_edit' => true,

			// Whether to display a column for the taxonomy on its post
			// type listing screens.
			'show_admin_column' => true,

			// Array of capabilities for this taxonomy.
			'capabilities' => [
				'manage_terms' => 'edit_posts',
				'edit_terms' => 'edit_posts',
				'delete_terms' => 'edit_posts',
				'assign_terms' => 'edit_posts',
			],

			// Sets the query var key for this taxonomy. Default $taxonomy key.
			// If false, a taxonomy cannot be loaded
			// at ?{query_var}={term_slug}. If a string,
			// the query ?{query_var}={term_slug} will be valid.
			'query_var' => true,

			// Triggers the handling of rewrites for this taxonomy.
			// Replace the array with false to prevent handling of rewrites.
			'rewrite' => [

				// Customize the permastruct slug.
				'slug' => 'collection',

				// Whether the permastruct should be prepended
				// with WP_Rewrite::$front.
				'with_front' => true,

				// Either hierarchical rewrite tag or not.
				'hierarchical' => false,

				// Endpoint mask to assign. If null and permalink_epmask
				// is set inherits from $permalink_epmask. If null and
				// permalink_epmask is not set, defaults to EP_PERMALINK.
				'ep_mask' => null,

			],

			// Default term to be used for the taxonomy.
			'default_term' => null,

			// An array of labels for this taxonomy.
			'labels' => [
				'name' => _x( 'Collections', 'Plural name', 'kntnt-taxonomy-collection' ),
				'singular_name' => _x( 'Collection', 'Singular name', 'kntnt-taxonomy-collection' ),
				'search_items' => _x( 'Search collections', 'Search items', 'kntnt-taxonomy-collection' ),
				'popular_items' => _x( 'Search collections', 'Search items', 'kntnt-taxonomy-collection' ),
				'all_items' => _x( 'All collections', 'All items', 'kntnt-taxonomy-collection' ),
				'parent_item' => _x( 'Parent collection', 'Parent item', 'kntnt-taxonomy-collection' ),
				'parent_item_colon' => _x( 'Parent collection colon', 'Parent item colon', 'kntnt-taxonomy-collection' ),
				'edit_item' => _x( 'Edit collection', 'Edit item', 'kntnt-taxonomy-collection' ),
				'view_item' => _x( 'View collection', 'View item', 'kntnt-taxonomy-collection' ),
				'update_item' => _x( 'Update collection', 'Update item', 'kntnt-taxonomy-collection' ),
				'add_new_item' => _x( 'Add new collection', 'Add new item', 'kntnt-taxonomy-collection' ),
				'new_item_name' => _x( 'New collection name', 'New item name', 'kntnt-taxonomy-collection' ),
				'separate_items_with_commas' => _x( 'Separate collections with commas', 'Separate items with commas', 'kntnt-taxonomy-collection' ),
				'add_or_remove_items' => _x( 'Add or remove collections', 'Add or remove items', 'kntnt-taxonomy-collection' ),
				'choose_from_most_used' => _x( 'Choose from most used', 'Choose from most used', 'kntnt-taxonomy-collection' ),
				'not_found' => _x( 'Not found', 'Not found', 'kntnt-taxonomy-collection' ),
				'no_terms' => _x( 'No terms', 'No terms', 'kntnt-taxonomy-collection' ),
				'items_list_navigation' => _x( 'Collections list navigation', 'Items list navigation', 'kntnt-taxonomy-collection' ),
				'items_list' => _x( 'Items list', 'Collections list', 'kntnt-taxonomy-collection' ),
				'most_used' => _x( 'Most used', 'Most used', 'kntnt-taxonomy-collection' ),
				'back_to_items' => _x( 'Back to collections', 'Back to items', 'kntnt-taxonomy-collection' ),
			],

		];
	}

	public function term_updated_messages( $messages ) {
		$messages['collection'] = [
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Collection added.', 'kntnt-taxonomy-collection' ),
			2 => __( 'Collection deleted.', 'kntnt-taxonomy-collection' ),
			3 => __( 'Collection updated.', 'kntnt-taxonomy-collection' ),
			4 => __( 'Collection not added.', 'kntnt-taxonomy-collection' ),
			5 => __( 'Collection not updated.', 'kntnt-taxonomy-collection' ),
			6 => __( 'Collections deleted.', 'kntnt-taxonomy-collection' ),
		];
		return $messages;
	}

}
