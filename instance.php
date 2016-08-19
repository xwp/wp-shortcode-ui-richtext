<?php
/**
 * Instantiates the Shortcake Richtext plugin
 *
 * @package ShortcodeUiRichtext
 */

namespace ShortcodeUiRichtext;

global $shortcode_ui_richtext_plugin;

require_once __DIR__ . '/php/class-plugin-base.php';
require_once __DIR__ . '/php/class-plugin.php';

$shortcode_ui_richtext_plugin = new Plugin();

/**
 * Shortcake Richtext Plugin Instance
 *
 * @return Plugin
 */
function get_plugin_instance() {
	global $shortcode_ui_richtext_plugin;
	return $shortcode_ui_richtext_plugin;
}
