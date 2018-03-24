<?php
/**
 * Plugin Name: Shortcake (Shortcode UI) Richtext
 * Plugin URI: https://github.com/xwp/wp-shortcode-ui-richtext
 * Description: Adds richtext capabilities to Shortcake textareas with shortcake-richtext class.
 * Version: 1.3
 * Author:  XWP
 * Author URI: https://xwp.co/
 * License: GPLv2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: scui_richtext
 * Domain Path: /languages
 *
 * Copyright (c) 2016 XWP (https://xwp.co/)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package ShortcodeUiRichtext
 */

if ( version_compare( phpversion(), '5.3', '>=' ) ) {
	require_once __DIR__ . '/instance.php';
} else {
	if ( defined( 'WP_CLI' ) ) {
		WP_CLI::warning( scui_richtext_php_version_text() );
	} else {
		add_action( 'admin_notices', 'scui_richtext_php_version_error' );
	}
}

/**
 * Admin notice for incompatible versions of PHP.
 */
function scui_richtext_php_version_error() {
	printf( '<div class="error"><p>%s</p></div>', esc_html( scui_richtext_php_version_text() ) );
}

/**
 * String describing the minimum PHP version.
 *
 * @return string
 */
function scui_richtext_php_version_text() {
	return __( 'Shortcake Richtext plugin error: Your version of PHP is too old to run this plugin. You must be running PHP 5.3 or higher.', 'scui_richtext' );
}
