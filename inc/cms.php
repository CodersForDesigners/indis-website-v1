<?php

namespace BFS;

class CMS {

	public static $cache = [ ];

	/*
	 * ----- When a post is queried and the `the_content` filter is applied to it, this is the reference where it attaches its data to
	 */
	public static $currentQueriedPostACF = [ ];
	public static $currentQueriedPostId = null;


	public static function getPostsOf ( $type, $limit = -1, $exclude = [ ] ) {

		$limit = $limit ?: -1;
		if ( ! is_array( $exclude ) )
			if ( is_int( $exclude ) )
				$exclude = [ $exclude ];

		$postsFromDB = get_posts( [
		    'post_type' => $type,
		    'post_status' => 'publish',
		    'numberposts' => $limit,
		    // 'order' => 'ASC'
		    'orderby' => 'date',
		    'exclude' => $exclude
		] );


		foreach ( $postsFromDB as &$post ) {
			if ( isset( self::$cache[ $post->ID ] ) ) {
				$post = self::$cache[ $post->ID ];
				continue;
			}

			$post = get_object_vars( $post );
			// Reset the var where the ACF data will be stored
			self::$currentQueriedPostId = $post[ 'ID' ];
			self::$currentQueriedPostACF = get_fields( $post[ 'ID' ] ) ?: [ ];
			$post[ 'post_content' ] = apply_filters( 'the_content', $post[ 'post_content' ] );
			$post[ 'acf' ] = self::$currentQueriedPostACF;
			self::$currentQueriedPostId = null;
			// Cache the post
			self::$cache[ $post[ 'ID' ] ] = $post;
		}

		foreach ( $postsFromDB as &$post )
			$posts[ ] = new Content( $post[ 'ID' ] );

		return $posts;

	}

	public static function getPostById ( $id ) {

		if ( isset( self::$cache[ $id ] ) )
			return self::$cache[ $id ];

		$postFromDB = get_post( $id, ARRAY_A ) ?? null;

		if ( ! $postFromDB )
			return null;

		$post = $postFromDB;
		// Reset the var where the ACF data will be stored
		self::$currentQueriedPostId = $post[ 'ID' ];
			// 1. Fetch the ACF fields that are not blocks
		self::$currentQueriedPostACF = get_fields( $post[ 'ID' ] ) ?: [ ];
			// 2. Fetch the ACF fields that are blocks
		$post[ 'post_content' ] = apply_filters( 'the_content', $post[ 'post_content' ] );
		// Neatly store all the ACF fields in a sub-field
		$post[ 'acf' ] = self::$currentQueriedPostACF;
		self::$currentQueriedPostId = null;
		// Cache the post
		self::$cache[ $id ] = $post;

		return $post;

	}

	public static function getPostBySlug ( $slug ) {

		if ( isset( self::$cache[ $slug ] ) )
			return self::$cache[ $slug ];

		global $postType;

		$postFromDB = get_page_by_path( $slug, OBJECT, $postType ?: [ 'page', 'attachment' ] ) ?? null;

		if ( ! $postFromDB )
			return null;

		$post = get_object_vars( $postFromDB );
		// Reset the var where the ACF data will be stored
		self::$currentQueriedPostId = $post[ 'ID' ];
		self::$currentQueriedPostACF = get_fields( $post[ 'ID' ] ) ?: [ ];
		$post[ 'post_content' ] = apply_filters( 'the_content', $post[ 'post_content' ] );
		$post[ 'acf' ] = self::$currentQueriedPostACF;
		self::$currentQueriedPostId = null;
		// Cache the post
		self::$cache[ $post[ 'ID' ] ] = $post;
		self::$cache[ $slug ] = $post;

		return $post;

	}

}

class Content {

	private $postIdentifier;
	private $postId;
	private $postSlug;
	private $postType;

	// private $post;

	public function __construct ( $postIdOrSlug, $postType = null ) {
		if ( is_string( $postIdOrSlug ) ) {
			$this->postIdentifier = $postIdOrSlug;
			$this->postSlug = $postIdOrSlug;
			if ( ! empty( $postType ) ) {
				$this->postType = $postType;
				$this->postIdentifier = $postType . '/' . $this->postIdentifier;
			}
		}
		else {
			$this->postId = $postIdOrSlug;
			$this->postIdentifier = $postIdOrSlug;
		}
	}

	public function get ( $key ) {

		// Get a reference to the post's cache
		$postCache = CMS::$cache[ $this->postIdentifier ];

		// Get the value from the cache
		if ( isset( $postCache[ $key ] ) )
			return $postCache[ $key ];

		// If it wasn't in the cache.....

		if ( $this->postId )
			CMS::$cache[ $this->postIdentifier ] = get_post( $this->postId, ARRAY_A ) ?? null;
		else
			CMS::$cache[ $this->postIdentifier ] = get_page_by_path( $this->postSlug, OBJECT, $this->postType ?? [ 'post', 'page' ] ) ?? null;

		$post = &CMS::$cache[ $this->postIdentifier ];
		if ( empty( $post ) )
			throw new \Exception( 'Post not found.', 1 );

		// Store the post id
		$this->postId = $post[ 'ID' ];

		CMS::$cache[ $this->postId ] = &CMS::$cache[ $this->postIdentifier ];

		if ( isset( $post[ $key ] ) )
			return $post[ $key ];

		$post[ 'post_content' ] = apply_filters( 'the_content', $post[ 'post_content' ] );

		if ( isset( $post[ $key ] ) )
			return $post[ $key ];

		$post[ $key ] = get_field( $key, $this->postId ) ?? null;

		return $post[ $key ];

	}

}
