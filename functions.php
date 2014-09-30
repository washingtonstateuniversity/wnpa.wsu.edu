<?php

add_action( 'admin_menu', 'wnpa_alter_menu' );
/**
 * Remove unused Posts and Comments from the admin menu.
 */
function wnpa_alter_menu() {
	global $menu;

	if ( isset( $menu[26] ) && isset( $menu[27] ) ) {
		$menu[5] = $menu[26];
		$menu[6] = $menu[27];
		unset( $menu[27] );
		unset( $menu[26] );
		unset( $menu[25] );
	}
}

add_action( 'admin_bar_menu', 'wnpa_alter_content_menu', 71 );
/**
 * Remove the new post option from the default content menu in the admin bar
 *.
 * @param WP_Admin_Bar $wp_admin_bar
 */
function wnpa_alter_content_menu( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}

add_filter( 'excerpt_more', 'wnpa_excerpt_more' );
function wnpa_excerpt_more() {
	global $post;

	$link_url = get_post_meta( $post->ID, '_feed_item_link_url', true );

	return '<a class="moretag" href="' . esc_url( $link_url ) . '">More</a>';
}

// Allow WP authentication in addition to WSU Network ID auth.
add_filter( 'wsuwp_sso_allow_wp_auth', '__return_true' );

add_filter( 'login_message', 'wnpa_theme_login_message', 11, 1 );
function wnpa_theme_login_message( $login_message ) {

	$additional_text = '<div class="registration-guide" style="margin-top: 10px; margin-bottom: 10px;">An account with the WNPA News Service is required to login on this page. Please see instructions on the <a href="' . esc_url( home_url() ) . '">main page</a> for requesting an account.</div>';

	return $login_message . $additional_text;
}