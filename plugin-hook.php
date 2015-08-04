<?php
/*
Plugin Name: TCBD Modals
Plugin URI: http://demos.tcoderbd.com/wordpress_plugins/tcbd-modals-wordpress-awesome-plugins/
Description: This plugin will enable Awesome Modals box in your Wordpress theme.
Author: Md Touhidul Sadeek
Version: 1.0
Author URI: http://tcoderbd.com
*/

/*  Copyright 2015 tCoderBD (email: info@tcoderbd.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Define Plugin Directory
define('TCBD_MODALS_PLUGIN_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

// Hooks TCBD functions into the correct filters
function tcbd_modals_add_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'tcbd_modals_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'tcmd_modals_register_mce_button' );
	}
}
add_action('admin_head', 'tcbd_modals_add_mce_button');

// Declare script for new button
function tcbd_modals_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['tcbd_modals_mce_button'] = TCBD_MODALS_PLUGIN_URL.'js/tinymce.js';
	return $plugin_array;
}

// Register new button in the editor
function tcmd_modals_register_mce_button( $buttons ) {
	array_push( $buttons, 'tcbd_modals_mce_button' );
	return $buttons;
}


function tcbd_modals_scripts(){
	// Latest jQuery WordPress
	wp_enqueue_script('jquery');

	// TCBD Modals JS
	wp_enqueue_script('tcbd-modals-js', TCBD_MODALS_PLUGIN_URL.'js/tcbd-modals.js', array('jquery'), '1.0', true);

	// TCBD Modals CSS
	wp_register_style('tcbd-modals', TCBD_MODALS_PLUGIN_URL.'css/tcbd-modals.css', array(), '1.0');
	wp_enqueue_style('tcbd-modals');
}
add_action('wp_enqueue_scripts', 'tcbd_modals_scripts');



// TCBD Modals Shortcode
function tcbd_modals_text( $atts, $content = null  ) {
	extract( shortcode_atts( array(
		'title' => '',
		'text' => ''
	), $atts ) );
	return '
	<span class="tcbd-modals-title" data-toggle="modal" data-target=".modal">'.$content.'</span>
	<div class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">'.$title.'</h4>
				</div>
				<div class="modal-body">
					'.$text.'
				</div>
			</div>
		</div>
	</div>
	';
}	
add_shortcode('tcbd-modals', 'tcbd_modals_text');
