<?php
/*
Plugin Name: E-magazine
Description: Publish an online magazine.
Author: Eric Andrew Lewis
Version: 0.1
*/

class EMagazine {
	/**
	 * Insures that only one instance of the plugin exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 0.1.0
	 *
	 * @return EMagazine
	 */
	public static function instance() {

		// Store the instance locally to avoid private static replication
		static $instance = null;

		// Only run these methods if they haven't been ran previously
		if ( null === $instance ) {
			$instance = new EMagazine;
			$instance->include_dependencies();
			$instance->setup_action_callbacks();
		}

		// Always return the instance
		return $instance;
	}

	/** Magic Methods *********************************************************/

	/**
	 * A dummy constructor to prevent class from being loaded more than once.
	 *
	 * @since 0.1.0
	 */
	private function __construct() { /* Do nothing here */ }

	/**
	 * Include dependenceis.
	 *
	 * @since 0.1.0
	 */
	private function include_dependencies() {
		require( 'assets/dependencies/posts-to-posts/posts-to-posts.php' );
	}

	/**
	 * Setup callback functions to WordPress actions.
	 *
	 * @since 0.1.0
	 */
	private function setup_action_callbacks() {
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'wp_loaded', array( $this, 'register_p2p_connection_types' ) );
	}

	/**
	 * Register custom post types `issue` and `article`.
	 *
	 * @since 0.1.0
	 */
	public function register_post_types() {
		register_post_type( 'issue', array(
			'labels' => array(
				'name'               => 'Issues',
				'singular_name'      => 'Issue',
				'add_new'            => 'Add New',
				'add_new_item'       => 'Add New Issue',
				'edit_item'          => 'Edit Issue',
				'new_item'           => 'New Issue',
				'all_items'          => 'All Issues',
				'view_item'          => 'View Issue',
				'search_items'       => 'Search Issues',
				'not_found'          =>	'No Issues found',
				'not_found_in_trash' => 'No Issues found in Trash',
				'parent_item_colon'  => '',
				'menu_name'          => 'Issues'
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'issue' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor' )
		) );

		register_post_type( 'article', array(
			'labels' => array(
				'name'               => 'Articles',
				'singular_name'      => 'Article',
				'add_new'            => 'Add New',
				'add_new_item'       => 'Add New Article',
				'edit_item'          => 'Edit Article',
				'new_item'           => 'New Article',
				'all_items'          => 'All Articles',
				'view_item'          => 'View Article',
				'search_items'       => 'Search Articles',
				'not_found'          =>	'No Articles found',
				'not_found_in_trash' => 'No Articles found in Trash',
				'parent_item_colon'  => '',
				'menu_name'          => 'Articles'
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'article' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor' )
		) );
	}
	public function register_p2p_connection_types() {
		// return;
		p2p_register_connection_type( array(
				'name'       => 'articles_to_issues',
				'from'       => 'article',
				'to'         => 'issue',
				'sortable'   =>'any',
				'reciprocal' => true
		) );
	}
}

/**
 * The main function responsible for returning the EMagazine Instance.
 *
 * @return BuddyPress The one true EMagazine Instance
 */
function emagazine() {
	return EMagazine::instance();
}

// Boom
emagazine();