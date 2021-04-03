<?php
/*
Plugin Name: Jonas Streule CPT
Plugin URI: https://rueegger.dev
Description: Jonas Streule Custom Post Type and Taxonomies
Version: 1.0.0
Author: Samuel Rüegger
Author URI: https://rueegger.dev
*/

function cptui_register_my_cpts() {

	/**
	 * Post Type: Statements.
	 */

	$labels = [
		"name" => __( "Statements", "custom-post-type-ui" ),
		"singular_name" => __( "Statement", "custom-post-type-ui" ),
		"menu_name" => __( "Bingo Statements", "custom-post-type-ui" ),
		"all_items" => __( "Alle Statements", "custom-post-type-ui" ),
		"add_new" => __( "Hinzufügen", "custom-post-type-ui" ),
		"add_new_item" => __( "Statement hinzufügen", "custom-post-type-ui" ),
		"edit_item" => __( "Statement bearbeiten", "custom-post-type-ui" ),
		"new_item" => __( "New Statement", "custom-post-type-ui" ),
		"view_item" => __( "Statement anschauen", "custom-post-type-ui" ),
		"view_items" => __( "Statements ansehen", "custom-post-type-ui" ),
		"search_items" => __( "Statements suchen", "custom-post-type-ui" ),
		"not_found" => __( "Keine Statements gefunden", "custom-post-type-ui" ),
		"not_found_in_trash" => __( "Keine Statements im Papierkorb gefunden", "custom-post-type-ui" ),
		"parent" => __( "Übergeordnetes Statement", "custom-post-type-ui" ),
		"archives" => __( "Statement Archiv", "custom-post-type-ui" ),
		"insert_into_item" => __( "Insert into Statement", "custom-post-type-ui" ),
		"uploaded_to_this_item" => __( "Upload to this Statement", "custom-post-type-ui" ),
		"filter_items_list" => __( "Filter Statements list", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Statements list navigation", "custom-post-type-ui" ),
		"items_list" => __( "Statements list", "custom-post-type-ui" ),
		"attributes" => __( "Statements attributes", "custom-post-type-ui" ),
		"name_admin_bar" => __( "Statement", "custom-post-type-ui" ),
		"item_published" => __( "Statement published", "custom-post-type-ui" ),
		"item_published_privately" => __( "Statement published privately.", "custom-post-type-ui" ),
		"item_reverted_to_draft" => __( "Statement reverted to draft.", "custom-post-type-ui" ),
		"item_scheduled" => __( "Statement scheduled", "custom-post-type-ui" ),
		"item_updated" => __( "Statement updated.", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Übergeordnetes Statement", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Statements", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "Alle Bingo Statements von Jonas Streule",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "bingo_statements",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "statements", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-games",
		"supports" => [ "title", "custom-fields", "revisions", "author" ],
	];

	register_post_type( "js_bingo_statements", $args );

	/**
	 * Post Type: Highscore.
	 */

	$labels = [
		"name" => __( "Highscore", "custom-post-type-ui" ),
		"singular_name" => __( "Highscore", "custom-post-type-ui" ),
		"menu_name" => __( "Bingo Highscore", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Highscore", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "bingo_highscore",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "js_bingo_highscore", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "custom-fields" ],
	];

	register_post_type( "js_bingo_highscore", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );