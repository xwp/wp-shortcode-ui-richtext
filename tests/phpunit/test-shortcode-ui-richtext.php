<?php
/**
 * Test_scui_richtext
 *
 * @package ShortcodeUiRichtext
 */

namespace ShortcodeUiRichtext;

/**
 * Class Test_scui_richtext
 *
 * @package ShortcodeUiRichtext
 */
class Test_scui_richtext extends \WP_UnitTestCase {

	/**
	 * Test _scui_richtext_php_version_error().
	 *
	 * @see _scui_richtext_php_version_error()
	 */
	public function test_scui_richtext_php_version_error() {
		ob_start();
		_scui_richtext_php_version_error();
		$buffer = ob_get_clean();
		$this->assertContains( '<div class="error">', $buffer );
	}

	/**
	 * Test _scui_richtext_php_version_text().
	 *
	 * @see _scui_richtext_php_version_text()
	 */
	public function test_scui_richtext_php_version_text() {
		$this->assertContains( 'Shortcake Richtext plugin error:', _scui_richtext_php_version_text() );
	}
}
