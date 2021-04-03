<?php
/* Rest Calls definieren */
add_action( 'rest_api_init', function () {
  register_rest_route( 'js/v1', '/savehighscore/(?P<player_name>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'rest_save_highscore',
    'permission_callback' => '__return_true',
  ) );
} );

function rest_save_highscore(WP_REST_Request $request) {
  $player_name = esc_attr( $request['player_name'] );
  $punkte = esc_attr( $request['points'] );
  $return_data = array(
    'player_name' => $player_name,
    'punkte' => $punkte
  );
  /* Ergebnis speichern */
  if( !empty($player_name) && !empty($punkte) ) {
    $new_post = array(
      'post_author' => 1,
      'post_title' => $player_name,
      'post_type' => 'js_bingo_highscore',
      'post_status' => 'publish'
    );
    $new_post_id = wp_insert_post( $new_post );
    /* Punkte in den neu generierten Post hinzufügen */
    update_field( 'highscore_punkte', $punkte, $new_post_id );
  }
  /* Ausgabe zurückgeben */
  $response = new WP_REST_Response( $return_data );
  $response->set_status( 201 );
  return $response;
}