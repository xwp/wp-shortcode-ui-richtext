<?php
/**
 * Class Plugin_Base
 *
 * @package ShortcodeUiRichtext
 */

namespace ShortcodeUiRichtext;

/**
 * Class Plugin_Base
 *
 * @package ShortcodeUiRichtext
 */
abstract class Plugin_Base {

	/**
	 * Plugin config.
	 *
	 * @var array
	 */
	public $config = array();

	/**
	 * Plugin slug.
	 *
	 * @var string
	 */
	public $slug;

	/**
	 * Plugin directory path.
	 *
	 * @var string
	 */
	public $dir_path;

	/**
	 * Plugin directory URL.
	 *
	 * @var string
	 */
	public $dir_url;

	/**
	 * Directory in plugin containing autoloaded classes.
	 *
	 * @var string
	 */
	protected $autoload_class_dir = 'php';

	/**
	 * Plugin_Base constructor.
	 */
	public function __construct() {
		$location = $this->locate_plugin();
		$this->slug = $location['dir_basename'];
		$this->dir_path = $location['dir_path'];
		$this->dir_url = $location['dir_url'];
		spl_autoload_register( array( $this, 'autoload' ) );
	}

	/**
	 * Get reflection object for this class.
	 *
	 * @return \ReflectionObject
	 */
	public function get_object_reflection() {
		static $reflection;
		if ( empty( $reflection ) ) {
			$reflection = new \ReflectionObject( $this );
		}
		return $reflection;
	}

	/**
	 * Autoload matches cache.
	 *
	 * @var array
	 */
	protected $autoload_matches_cache = array();

	/**
	 * Autoload for classes that are in the same namespace as $this.
	 *
	 * @param string $class Class name.
	 * @return void
	 */
	public function autoload( $class ) {
		if ( ! isset( $this->autoload_matches_cache[ $class ] ) ) {
			if ( ! preg_match( '/^(?P<namespace>.+)\\\\(?P<class>[^\\\\]+)$/', $class, $matches ) ) {
				$matches = false;
			}
			$this->autoload_matches_cache[ $class ] = $matches;
		} else {
			$matches = $this->autoload_matches_cache[ $class ];
		}
		if ( empty( $matches ) ) {
			return;
		}

		if ( false === strpos( $matches['namespace'], $this->get_object_reflection()->getNamespaceName() ) ) {
			return;
		}
		$class_name = $matches['class'];

		$class_path = \trailingslashit( $this->dir_path );
		if ( $this->autoload_class_dir ) {
			$class_path .= \trailingslashit( $this->autoload_class_dir );
		}

		if ( $this->get_object_reflection()->getNamespaceName() !== $matches['namespace'] ) {
			$sub_namespace = str_replace($this->get_object_reflection()->getNamespaceName() . '\\', '', $matches['namespace']);
			$namespace_path = str_replace('\\', \DIRECTORY_SEPARATOR, strtolower($sub_namespace));
			$class_path .= \trailingslashit( $namespace_path );
		}

		$class_path .= sprintf( 'class-%s.php', strtolower( str_replace( '_', '-', $class_name ) ) );
		if ( is_readable( $class_path ) ) {
			require_once $class_path;
		}
	}

	/**
	 * Obtain plugin's location.
	 *
	 * Note that this will not work for plugins bundled with themes on WordPress.com.
	 *
	 * @throws \Exception If the plugin is not located in the expected location.
	 * @return array
	 */
	public function locate_plugin() {
		$dir_path = plugin_dir_path( __DIR__ );
		$dir_basename = basename( $dir_path );
		$dir_url = plugin_dir_url( __DIR__ );
		return compact( 'dir_url', 'dir_path', 'dir_basename' );
	}
}
