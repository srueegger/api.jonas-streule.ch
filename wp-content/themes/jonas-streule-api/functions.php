<?php
/* ACF Felder zur REST API hinzufügen */
function create_ACF_meta_in_REST() {
	$postypes_to_exclude = ['acf-field-group','acf-field'];
	$extra_postypes_to_include = ["page"];
	$post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);
	array_push($post_types, $extra_postypes_to_include);
	foreach ($post_types as $post_type) {
		register_rest_field( $post_type, 'ACF', [
			'get_callback'    => 'expose_ACF_fields',
			'schema'          => null,
	   ]
	 );
	}
}
function expose_ACF_fields( $object ) {
	$ID = $object['id'];
	return get_fields($ID);
}
add_action( 'rest_api_init', 'create_ACF_meta_in_REST' );

/* CORS Rules */
function sw_customize_rest_cors() {
	remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
	add_filter( 'rest_pre_serve_request', function( $value ) {
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS' );
		header( 'Access-Control-Allow-Credentials: true' );
		header( 'Access-Control-Expose-Headers: Link', false );
		return $value;
	} );
}
add_action( 'rest_api_init', 'sw_customize_rest_cors', 15 );

function wprc_manipulate_cache_headers( $headers, $request_uri ) {
	// manipulate the headers here, for example add a Access-Control-Allow-Headers header:
	$headers['Access-Control-Allow-Origin'] = '*';
	$headers['Access-Control-Allow-Methods'] = 'GET';
	$headers['Access-Control-Allow-Credentials'] = 'true';

	return $headers;
}
add_filter( 'wp_rest_cache/cache_headers', 'wprc_manipulate_cache_headers', 10, 2 );


/***************************************
 * 	Widget Ausgabe für Code überprüfung
 ***************************************/
function sw_check_code_widget_handler() {
	?>
	<div class="input-text-wrap">
		<label class="codechecklabel" for="checkinputcode">Code</label>
		<input class="codecheckinput" type="text" id="checkinputcode" autocomplete="off">
	</div>
	<div id="coderesult"></div>
	<p class="submit codecheck">
		<button id="startcodecheck" type="button" class="button button-primary">Code überprüfen</button>
	</p>
	<?php
}

/***************************************
 * 		Enqueue Admin scripts and styles.
 ***************************************/
function js_admin_startup_scripts() {
	$modificated_js = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/admin.js' ) );
	$modificated_css = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/admin.css' ) );
	wp_register_script( 'jonasstreule-admin-js', get_template_directory_uri() . '/admin.js', array('jquery'), $modificated_js, true );
	$global_vars = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'ajax_secure' => wp_create_nonce('jonasstreule-check-ajax-secure'),
	);
	wp_localize_script( 'jonasstreule-admin-js', 'global_vars', $global_vars );
	wp_enqueue_script( 'jonasstreule-admin-js' );
	wp_enqueue_style( 'jonasstreule-admin-style', get_template_directory_uri() . '/admin.css', null, $modificated_css );
}
add_action( 'admin_enqueue_scripts', 'js_admin_startup_scripts' );

function add_cors_http_header(){
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Credentials: true');
}
add_action('init','add_cors_http_header');

/* Backend aufräumen - Inhalte entfernen */
function remove_menu_items(){
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'tools.php' );
}
add_action( 'admin_menu', 'remove_menu_items', 999 );

/* ACF Menu ausblenden wenn Debug deaktiviert ist */
if( !WP_DEBUG ) {
	add_filter('acf/settings/show_admin', '__return_false');
}

/* Inhalte "zufällig" über die REST API ausgeben */
function add_rand_orderby_rest_post_collection_params( $query_params ) {
	$query_params['orderby']['enum'][] = 'rand';
	return $query_params;
}
add_filter( 'rest_js_bingo_statements_collection_params', 'add_rand_orderby_rest_post_collection_params' );

/* Highscore nach Punkte ausgeben */
function js_pre_get_posts( $query ) {
	// do not modify queries in the admin
	if( is_admin() ) {
		return $query;
	}
	if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'js_bingo_highscore' ) {
		$query->set('orderby', 'meta_value_num');	
		$query->set('meta_key', 'highscore_punkte');	 
		$query->set('order', 'DESC'); 
	}
	// return
	return $query;
}
add_action('pre_get_posts', 'js_pre_get_posts');