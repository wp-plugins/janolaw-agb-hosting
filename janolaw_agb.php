<?php
/*
Plugin Name: Janolaw AGB Hosting
Plugin URI: http://www.janolaw.de/internetrecht/agb/agb-hosting-service/
Description: This Plugin get hosted legal documents provided by Janolaw AG for Web-Shops and Pages.
Version: 1.0
Author: Jan Giebels
Author URI: http://code-worx.de
License: GPL2
*/
?>
<?php
/*  Copyright 2010  Code-WorX, Jan Giebels  (email : wordpress@code-worx.de)

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
}

function janolaw_plugin_options() {

  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }

?><div class="wrap">
  			<h2>Janolaw AGB Hosting</h2>
  			<form method="post" action="options.php">
  				<?php settings_fields( 'janolaw-settings-group' ); ?>
  				<table class="form-table">
  					<tr valign="top">
						<th scope="row">Janolaw User ID</th>
						<td><input type="text" name="janolaw_user_id" value="<?= get_option('janolaw_user_id'); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row">Janolaw Shop ID</th>
						<td><input type="text" name="janolaw_shop_id" value="<?= get_option('janolaw_shop_id'); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Cache Path'); ?></th>
						<td><input type="text" name="janolaw_cache_path" value="<?= get_option('janolaw_cache_path'); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><h3><?php _e('Howto'); ?></h3></th>
						<td><i><?php _e('Insert one of the following Tags into any Page to display the refering Janolaw document:<blockquote>
										[janolaw_agb]<br />
										[janolaw_impressum]<br />
										[janolaw_widerrufsbelehrung]<br />
										[janolaw_datenschutzerklaerung]</blockquote>'); ?></i></td>
					</tr>
  				</table>
  				
  				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
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