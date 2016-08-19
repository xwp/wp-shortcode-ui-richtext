<?php
/**
 * Test_shortcode_ui_richtext
 *
 * @package ShortcodeUiRichtext
 */

namespace ShortcodeUiRichtext;

/**
 * Class Test_shortcode_ui_richtext
 *
 * @package ShortcodeUiRichtext
 */
class Test_shortcode_ui_richtext extends \WP_UnitTestCase {

	/**
	 * Test _shortcode_ui_richtext_php_version_error().
	 *
	 * @see _shortcode_ui_richtext_php_version_error()
	 */
	public function test_shortcode_ui_richtext_php_version_error() {
		ob_start();
		_shortcode_ui_richtext_php_version_error();
		$buffer = ob_get_clean();
		$this->assertContains( '<div class="error">', $buffer );
	}

	/**
	 * Test _shortcode_ui_richtext_php_version_text().
	 *
	 * @see _shortcode_ui_richtext_php_version_text()
	 */
	public function test_shortcode_ui_richtext_php_version_text() {
		$this->assertContains( 'Shortcake Richtext plugin error:', _shortcode_ui_richtext_php_version_text() );
	}
}
