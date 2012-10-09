<?php
/*
Plugin Name: Janolaw AGB Hosting
Plugin URI: http://www.janolaw.de/internetrecht/agb/agb-hosting-service/
Description: This Plugin get hosted legal documents provided by Janolaw AG for Web-Shops and Pages.
Version: 2.0
Author: Jan Giebels
Author URI: http://code-worx.de
License: GPL2
*/
?>
<?php
/*  Copyright 2012  Code-WorX, Jan Giebels  (email : wordpress@code-worx.de)

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
?>
<?php

function janolaw_agb_menu() {
	add_options_page('Janolaw AGB Hosting', 'Janolaw AGB Hosting', 9, basename(__FILE__), 'janolaw_plugin_options');
	add_action( 'admin_init', 'register_janolaw_settings' );
}

function register_janolaw_settings() {
	//register our settings
	register_setting( 'janolaw-settings-group', 'janolaw_user_id' );
	register_setting( 'janolaw-settings-group', 'janolaw_shop_id' );
	register_setting( 'janolaw-settings-group', 'janolaw_cache_path' );
	register_setting( 'janolaw-settings-group', 'janolaw_agb_page' );
	register_setting( 'janolaw-settings-group', 'janolaw_imprint_page' );
	register_setting( 'janolaw-settings-group', 'janolaw_widerruf_page' );
	register_setting( 'janolaw-settings-group', 'janolaw_privacy_page' );
	register_setting( 'janolaw-settings-group', 'janolaw_agb_page_id' );
	register_setting( 'janolaw-settings-group', 'janolaw_imprint_page_id' );
	register_setting( 'janolaw-settings-group', 'janolaw_widerruf_page_id' );
	register_setting( 'janolaw-settings-group', 'janolaw_privacy_page_id' );
}

function janolaw_plugin_options() {
	# check permission
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	# predefine cache path if not entered yet
	$cachepath = get_option('janolaw_cache_path');
	if (!$cachepath) {
		$cachepath = "/tmp";
	}
	
	# create pages if not exist and checked to create
	
	if (get_option('janolaw_agb_page')) {
		$post = array(
			'ID' => get_option('janolaw_agb_page_id'),
			'comment_status' => 'closed',
			'post_content' => '[janolaw_agb]',
			'post_name' => 'agb',
			'post_status' => 'publish',
			'post_title' => 'Allgemeine Gesch&auml;ftsbedingungen',
			'post_type' => 'page'
		);
		$id = wp_insert_post( $post );
		update_option( "janolaw_agb_page_id", $id );
	}
	if (get_option('janolaw_imprint_page')) {
		$post = array(
				'ID' => get_option('janolaw_imprint_page_id'),
				'comment_status' => 'closed',
				'post_content' => '[janolaw_impressum]',
				'post_name' => 'agb',
				'post_status' => 'publish',
				'post_title' => 'Impressum',
				'post_type' => 'page'
		);
		$id = wp_insert_post( $post );
		update_option( "janolaw_imprint_page_id", $id );
	}
	if (get_option('janolaw_widerruf_page')) {
		$post = array(
				'ID' => get_option('janolaw_widerruf_page_id'),
				'comment_status' => 'closed',
				'post_content' => '[janolaw_widerrufsbelehrung]',
				'post_name' => 'agb',
				'post_status' => 'publish',
				'post_title' => 'Widerrufsbelehrung',
				'post_type' => 'page'
		);
		$id = wp_insert_post( $post );
		update_option( "janolaw_widerruf_page_id", $id );
	}
	if (get_option('janolaw_privacy_page')) {
		$post = array(
				'ID' => get_option('janolaw_privacy_page_id'),
				'comment_status' => 'closed',
				'post_content' => '[janolaw_datenschutzerkl&auml;rung]',
				'post_name' => 'agb',
				'post_status' => 'publish',
				'post_title' => 'Datenschutzerkl&auml;rung',
				'post_type' => 'page'
		);
		$id = wp_insert_post( $post );
		update_option( "janolaw_privacy_page_id", $id );
	}

?>

<div class="wrap">
	<h2>Janolaw AGB Hosting</h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'janolaw-settings-group' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Janolaw User ID</th>
				<td><input type="text" name="janolaw_user_id"
					value="<?= get_option('janolaw_user_id'); ?>" /> <small><?php _e('Your Janolaw User ID is issued by Janolaw AG by registering at'); ?>
					<a href="http://www.janolaw.de/agb-service/#menu" target="_blank">Janolaw
						AGB Hosting Service</a></small></td>
			</tr>
			<tr valign="top">
				<th scope="row">Janolaw Shop ID</th>
				<td><input type="text" name="janolaw_shop_id"
					value="<?= get_option('janolaw_shop_id'); ?>" /> <small><?php _e('Your Janolaw Shop ID is issued by Janolaw AG by registering at'); ?>
					<a href="http://www.janolaw.de/agb-service/#menu" target="_blank">Janolaw
						AGB Hosting Service</a></small></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Cache Path'); ?></th>
				<td><input type="text" name="janolaw_cache_path"
					value="<?= $cachepath ?>" /> <small><?php _e('Path to store cached documents e.g. /tmp for Unix based systems like Linux'); ?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Create Page AGB'); ?></th>
				<td><input type="hidden" name="janolaw_agb_page_id" value ="<?= get_option('janolaw_agb_page_id'); ?>" />
				<input type="checkbox" name="janolaw_agb_page"
					value ="1" <?= checked( 1, get_option('janolaw_agb_page'), false ) ?> /> <small><?php _e('Create a static page with pagetag included'); ?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Create Page Imprint'); ?></th>
				<td><input type="hidden" name="janolaw_imprint_page_id" value ="<?= get_option('janolaw_imprint_page_id'); ?>" />
					<input type="checkbox" name="janolaw_imprint_page"
					value ="1" <?= checked( 1, get_option('janolaw_imprint_page'), false ) ?> /> <small><?php _e('Create a static page with pagetag included'); ?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Create Page Widerruf'); ?></th>
				<td><input type="hidden" name="janolaw_widerruf_page_id" value ="<?= get_option('janolaw_widerruf_page_id'); ?>" />
				<input type="checkbox" name="janolaw_widerruf_page"
					value ="1" <?= checked( 1, get_option('janolaw_widerruf_page'), false ) ?> /> <small><?php _e('Create a static page with pagetag included'); ?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Create Page Privacy'); ?></th>
				<td><input type="hidden" name="janolaw_privacy_page_id" value ="<?= get_option('janolaw_privacy_page_id'); ?>" />
				<input type="checkbox" name="janolaw_privacy_page"
					value ="1" <?= checked( 1, get_option('janolaw_privacy_page'), false ) ?> /> <small><?php _e('Create a static page with pagetag included'); ?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3><?php _e('Howto'); ?></h3></th>
				<td><?php _e('Check the Checkbox of the desired document to create automatically.'); ?>
				<br /><br />
					<i><?php _e('Alternative:'); ?></i><br />
					<?php _e('Insert one of the following Tags into any Page to display the refering Janolaw document:'); ?>
						<blockquote>
						[janolaw_agb]<br />
						[janolaw_impressum]<br />
						[janolaw_widerrufsbelehrung]<br />
						[janolaw_datenschutzerklaerung]
						</blockquote></td>
			</tr>
		</table>

		<p class="submit">
			<input type="submit" class="button-primary"
				value="<?php _e('Save Changes'); ?>" />
		</p>
	</form>
</div>
<?php
}

function janolaw_page($content) {
	if (preg_match("/\[janolaw_(.*)\]/", $content, $type)) {
		$content = _get_document($type[1]);
	}
	return $content;
}

function _get_document($type) {
	$user_id = get_option('janolaw_user_id');
	$shop_id = get_option('janolaw_shop_id');
	$cache_path = get_option('janolaw_cache_path');
	$cache_time = 7200;
	$base_url = 'http://www.janolaw.de/agb-service/shops/';

	if (file_exists($cache_path.'/'.$user_id.$shop_id.'janolaw_'.$type.'.html')) {
		if (filectime($cache_path.'/'.$user_id.$shop_id.'janolaw_'.$type.'.html')+$cache_time<=time()) {
			#get fresh version from server 
			if ($file = file_get_contents($base_url.'/'.$user_id.'/'.$shop_id.'/'.$type.'_include.html')) {
				unlink ($cache_path.'/'.$user_id.$shop_id.'janolaw_'.$type.'.html');
				$fp = fopen($cache_path.'/'.$user_id.$shop_id.'janolaw_'.$type.'.html', 'w');
				fwrite($fp, $file);
				fclose($fp);
			}
		}
	} else {
		$file = file_get_contents($base_url.'/'.$user_id.'/'.$shop_id.'/'.$type.'_include.html');
		$fp = fopen($cache_path.'/'.$user_id.$shop_id.'janolaw_'.$type.'.html', 'w');
		fwrite($fp, $file);
		fclose($fp);
	}
	# extract text
	if ($file = file_get_contents($cache_path.'/'.$user_id.$shop_id.'janolaw_'.$type.'.html')) {
		return $file;
	} else {
		return "Ein Fehler ist aufgetreten! Bitte &uuml;berpr&uuml;fen Sie ihre Janolaw UserID und ShopID in Ihrer Konfigurationsdatei und ob der Cache Pfad beschreibbar ist!";
	}
}

add_action('admin_menu', 'janolaw_agb_menu');
add_filter('the_content','janolaw_page');

?>