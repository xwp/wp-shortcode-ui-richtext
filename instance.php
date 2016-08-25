<?php
/**
 * Instantiates the Shortcake Richtext plugin
 *
 * @package ShortcodeUiRichtext
 */

namespace ShortcodeUiRichtext;

global $scui_richtext_plugin;

require_once __DIR__ . '/php/class-plugin-base.php';
require_once __DIR__ . '/php/class-plugin.php';

$scui_richtext_plugin = new Plugin();

/**
 * Shortcake Richtext Plugin Instance
 *
 * @return Plugin
 */
function get_plugin_instance() {
	global $scui_richtext_plugin;
	return $scui_richtext_plugin;
}
