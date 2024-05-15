<?php

require_once __DIR__ . '/hooks.php';





function bfsBlockConstructionUpdateListingRenderCallback ( $attributes = [ ], $content = '' ) {

	if ( ! class_exists( '\BFS\CMS' ) )
		return '';

	$posts = get_posts( [
		'post_type' => 'update',
		'post_parent' => \BFS\CMS::$currentQueriedPostId,
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => 'date'
	] );
	wp_reset_postdata();

	// Backup the existing value of the current ACF post data
	$currentQueriedPostACF = \BFS\CMS::$currentQueriedPostACF;

	foreach ( $posts as &$post ) {
		\BFS\CMS::$currentQueriedPostACF = [ ];
		$post->post_content = apply_filters( 'the_content', $post->post_content );
		$post = [
			'update_group_title' => date( 'F Y', strtotime( $post->post_date_gmt ) ),
			'update_group' => \BFS\CMS::$currentQueriedPostACF[ 'update_group' ]
		];
	}
	unset( $post );

	// Restore the value of the current ACF post data
	\BFS\CMS::$currentQueriedPostACF = $currentQueriedPostACF;
	// Now, append to the existing current ACF post data
	\BFS\CMS::$currentQueriedPostACF = array_merge( \BFS\CMS::$currentQueriedPostACF, [ 'updates' => $posts ] );

	return '';

}

add_action( 'bfs/backend/on-editing-posts', function ( $postType ) {

	/*
	 *
	 * Gutenberg
	 *
	 */
	wp_enqueue_style( 'bfs-gutenberg-editor',
		get_template_directory_uri() . '/css/gutenberg-editor.css',
		false,
		filemtime( get_template_directory() . '/css/gutenberg-editor.css' )
	);

	// Add a block that lists Construction Updates that are associated with a Project
	if ( $postType === 'projects' ) {

		wp_register_script( 'bfs-script-construction-update-listing',
			get_template_directory_uri() . '/js/blocks/construction-update-listing.js',
			[ 'wp-blocks', 'wp-components' ],
			filemtime( get_template_directory() . '/js/blocks/construction-update-listing.js' )
		);

		register_block_type( 'bfs/construction-update-listing', [
			'name' => 'Construction Update Listing',
			'editor_script' => 'bfs-script-construction-update-listing',
			'render_callback' => 'bfsBlockConstructionUpdateListingRenderCallback'
		] );

		add_editor_style( 'css/project-post-gutenberg-editor.css' );

	}


	// Add a sidebar panel that allows you to associate a construction update with a project
	if ( $postType === 'update' ) {
		wp_enqueue_script(
			'bfs-associate-post-with-project',
			get_template_directory_uri() . '/js/associate-post-with-project.js',
			[ 'wp-i18n', 'wp-data', 'wp-components', 'wp-blocks', 'wp-edit-post', 'wp-plugins' ],
			filemtime( get_template_directory() . '/js/associate-post-with-project.js' )
		);
		add_editor_style( 'css/construction-update-post-gutenberg-editor.css' );
	}


	if ( $postType === 'post' or $postType === 'page' ) {

		$colors = [
			'light' => '#FFFFFF',
			'neutral-1' => '#D3D7DD',
			'neutral-2' => '#A8AFBC',
			'neutral-3' => '#7C869B',
			'neutral-4' => '#606879',
			'neutral-5' => '#434957',
			'dark' => '#262B35',
			'black' => '#1C2028',
			'red-1' => '#D9858A',
			'red-2' => '#C0343C',
			'red-3' => '#601A1E'
		];
		$colorEntries = [ ];
		foreach ( $colors as $name => $hexNumber ) {
			$humanReadableName = ucwords( preg_replace( '/-/', ' ', $name ) );
			$colorEntries[ ] = [
				'name' => $humanReadableName,
				'slug' => $name,
				'color' => $hexNumber
			];
		}

		// Replace the default color palette with these ones
		add_theme_support( 'editor-color-palette', $colorEntries );
		// Disable custom color picker
		add_theme_support( 'disable-custom-colors' );

		// Only allow access to certain types of blocks (for general posts and pages and the like)
		wp_enqueue_script(
			'bfs-block-access',
			get_template_directory_uri() . '/js/block-access.js',
			[ 'wp-data', 'wp-edit-post' ],
			filemtime( get_template_directory() . '/js/block-access.js' )
		);

	}

	// Block Visibility
	wp_enqueue_script(
		'bfs-block-visibility',
		get_template_directory_uri() . '/js/block-visibility.js',
		[ 'wp-data', 'wp-edit-post' ],
		filemtime( get_template_directory() . '/js/block-visibility.js' )
	);

} );




/*
 *
 * Load the Gutenberg on the frontend as well
 *
 */
add_action( 'bfs/init/frontend', function () {

	register_block_type( 'bfs/construction-update-listing', [
		'name' => 'Construction Update Listing',
		'render_callback' => 'bfsBlockConstructionUpdateListingRenderCallback'
	] );

} );



/*
 *
 * ----- Custom ACF Gutenberg blocks
 *
 */
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_register_block_type' ) )
		return;

	// Project Essentials block
	acf_register_block_type( [
		'name' => 'bfs-project-essentials',
		'title' => __( 'Project Essentials' ),
		'description' => __( 'Project Essentials' ),
		'category' => 'common',
		'icon' => 'building',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Project Engineering block
	acf_register_block_type( [
		'name' => 'bfs-project-engineering',
		'title' => __( 'Project Engineering' ),
		'description' => __( 'Project Engineering' ),
		'category' => 'common',
		'icon' => 'building',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Project Spotlights block
	acf_register_block_type( [
		'name' => 'bfs-project-spotlights',
		'title' => __( 'Project Spotlights' ),
		'description' => __( 'Project Spotlights' ),
		'category' => 'common',
		'icon' => 'building',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Project Events block
	acf_register_block_type( [
		'name' => 'bfs-project-events',
		'title' => __( 'Project Events' ),
		'description' => __( 'Project Events' ),
		'category' => 'common',
		'icon' => 'building',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Project Construction Updates block
	acf_register_block_type( [
		'name' => 'bfs-project-construction-updates',
		'title' => __( 'Project Construction Updates' ),
		'description' => __( 'Project Construction Updates' ),
		'category' => 'common',
		'icon' => 'building',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Social Media Links block
	acf_register_block_type( [
		'name' => 'bfs-social-media-links',
		'title' => __( 'Social Media Links' ),
		'description' => __( 'Social Media Links' ),
		'category' => 'common',
		'icon' => 'wordpress',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Meta block
	acf_register_block_type( [
		'name' => 'bfs-meta',
		'title' => __( 'Meta' ),
		'description' => __( 'Meta' ),
		'category' => 'common',
		'icon' => 'wordpress',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Project Pricing block
	acf_register_block_type( [
		'name' => 'bfs-project-pricing',
		'title' => __( 'Project Pricing' ),
		'description' => __( 'Project Pricing' ),
		'category' => 'common',
		'icon' => 'building',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// Linked Project block
	acf_register_block_type( [
		'name' => 'bfs-linked-project',
		'title' => __( 'Linked Project' ),
		'description' => __( 'Linked Project' ),
		'category' => 'common',
		'icon' => 'building',
		'align' => 'wide',
		'mode' => 'edit',
		'supports' => [
			'multiple' => false,
			'align' => [ 'wide' ]
		],
		'render_callback' => 'acf_render_callback'
	] );

	// For the Geek in You block
	acf_register_block_type( [
		'name' => 'bfs-for-the-geek-in-you',
		'title' => __( 'For the Geek in You' ),
		'description' => __( 'Link to associated article' ),
		'category' => 'common',
		'icon' => 'wordpress',
		'align' => '',
		'mode' => 'auto',
		'supports' => [
			'multiple' => true,
			'align' => true,
			'align_text' => true,
			'align_content' => true
		],
		'render_template' => __DIR__ . '/../template-parts/for-the-geek-in-you.php'
	] );



	function acf_render_callback ( $block, $content, $is_preview, $post_id ) {
		if ( ! class_exists( '\BFS\CMS' ) )
			return;

		\BFS\CMS::$currentQueriedPostACF = array_merge( \BFS\CMS::$currentQueriedPostACF, get_fields() ?: [ ] );

	}

} );

/*
 *
 * Change the REST API base URL to match the WordPress URL instead of the Site URL
 * 	This is because things break on the admin dashboard; you can't create/edit posts.
 *
 */
// add_filter( 'rest_url_prefix', function ( $prefix ) {
// 	return '?rest_route=';
// } );



/*
 *
 * Prevent auto-"correction" of URLs
 * 	Based on `https://core.trac.wordpress.org/ticket/16557`
 *
 */
add_filter( 'redirect_canonical', function ( $redirectUrl ) {
	if ( is_404() && ! isset( $_GET[ 'p' ] ) )
		return false;
	else
		return $redirectUrl;
} );



function bfs_theme_setup () {

	/*
	 * Theme Supports
	 *
	 * Register support for certain features
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
	 */
	// Enable support for Post Thumbnails on posts and pages.
	// @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	add_theme_support( 'editor-style' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'dark-editor-style' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );



	/*
	 *
	 * Media Settings
	 *
	 */
	add_image_size( 'small', 400, 400, false );



	/*
	 *
	 * Templates for the various Post Types
	 *
	 */
	add_filter( 'register_post_type_args', function ( $args, $postType ) {

		if ( $postType === 'projects' ) {
			$args[ 'template' ] = [
				[ 'acf/bfs-project-essentials' ],
				[ 'acf/bfs-project-spotlights' ],
				[ 'acf/bfs-project-pricing' ],
				[ 'acf/bfs-project-events' ],
				[ 'acf/bfs-project-engineering' ],
				[ 'bfs/construction-update-listing' ],
				[ 'acf/bfs-linked-project' ],
				[ 'acf/bfs-social-media-links' ],
				[ 'acf/bfs-meta' ]
			];
			$args[ 'template_lock' ] = 'all';
		}

		if ( $postType === 'update' ) {
			$args[ 'template' ] = [
				[ 'acf/bfs-project-construction-updates' ]
			];
			$args[ 'template_lock' ] = 'all';
		}

		return $args;

	}, 20, 2 );



	/*
	 *
	 * Show the Meta-data page if ACF is enabled
	 *
	 */
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( [
			'page_title' => 'Metadata',
			'menu_title' => 'Metadata',
			'menu_slug' => 'metadata',
			'capability' => 'edit_posts',
			'parent_slug' => '',
			'position' => false,
			'icon_url' => 'dashicons-info'
		] );
	}

}

add_action( 'after_setup_theme', 'bfs_theme_setup' );



/*
 |
 | Tile Map Viewer
 | 	Do not load the admin bar as it conflicts with other code
 |
 |
 */
add_action( 'wp', function () {
	if ( $_SERVER[ 'REQUEST_URI' ] !== '/tmv' ) {
		return;
	}
	add_filter( 'show_admin_bar', '__return_false' );
} );
