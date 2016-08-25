<?php
/**
 * Tests for Plugin_Base.
 *
 * @package ShortcodeUiRichtext
 */

namespace ShortcodeUiRichtext;

/**
 * Tests for Plugin_Base.
 *
 * @package ShortcodeUiRichtext
 */
class Test_Plugin_Base extends \WP_UnitTestCase {

	/**
	 * Plugin instance.
	 *
	 * @var Plugin
	 */
	public $plugin;

	/**
	 * Setup.
	 *
	 * @inheritdoc
	 */
	public function setUp() {
		parent::setUp();
		$this->plugin = get_plugin_instance();
	}

	/**
	 * Test locate_plugin.
	 *
	 * @see Plugin_Base::locate_plugin()
	 */
	public function test_locate_plugin() {
		$location = $this->plugin->locate_plugin();
		$this->assertEquals( 'shortcode-ui-richtext', $location['dir_basename'] );
		$this->assertContains( 'shortcode-ui-richtext', $location['dir_path'] );
		$this->assertContains( 'shortcode-ui-richtext', $location['dir_url'] );
	}

	/**
	 * Tests for trigger_warning().
	 *
	 * @see Plugin_Base::trigger_warning()
	 */
	public function test_trigger_warning() {
		$obj = $this;
		set_error_handler( function ( $errno, $errstr ) use ( $obj ) {
			$obj->assertEquals( 'ShortcodeUiRichtext\Plugin: Param is 0!', $errstr );
			$obj->assertEquals( \E_USER_WARNING, $errno );
		} );
		$this->plugin->trigger_warning( 'Param is 0!', \E_USER_WARNING );
		restore_error_handler();
	}
}
