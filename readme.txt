=== Shortcake (Shortcode UI) Richtext ===
Contributors: xwp, mihai2u, bengreeley
Tags: shortcodes
Requires at least: 4.5
Tested up to: 4.9.4
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin for adding rich text editing capabilities to textareas in Shortcake.

== Description ==

This plug-in extends on the capabilities of [Shortcake (Shortcode UI)](https://en.wordpress.org/plugins/shortcode-ui/) by adding rich text editing capabilities to textarea inputs in the Shortcake interface, when the specific textarea constructors contain the shortcake-richtext class name.

It uses [TinyMCE](https://www.tinymce.com).

== Installation ==

You need the latest version of of [Shortcake (Shortcode UI)] installed and activated.

1. Upload the plugin files to the `/wp-content/plugins/shortcode-ui-richtext` directory.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Add the meta class option to the textarea input type of an existing shortcake register_for_shortcode call.
4. Due to the possibility of the user entered content to contain special characters like [, ] and ", it is highly recommended to turn on the encode flag as well.
```php
'encode' => true,
'meta'  => array(
	'class' => 'shortcake-richtext',
),
```

== Frequently Asked Questions ==

= How does an example rich textarea input element shortcake register code looks like? =

This is a default shortcode with a single textarea:

```php
shortcode_ui_register_for_shortcode( 'shortcode_name',
	array(
		'label'         => esc_html__( 'Shortcode Name', 'namespace' ),
		'listItemImage' => 'dashicons-text',
		'attrs'         => array(
			array(
				'label' => esc_html__( 'Text Element', 'namespace' ),
				'attr'  => 'text_element',
				'type'  => 'textarea',
			),
		),
	)
);
```

This is the same code with the richtext capability added in on the text_element:

```php
shortcode_ui_register_for_shortcode( 'shortcode_name',
	array(
		'label'         => esc_html__( 'Shortcode Name', 'namespace' ),
		'listItemImage' => 'dashicons-text',
		'attrs'         => array(
			array(
				'label' => esc_html__( 'Text Element', 'namespace' ),
				'attr'  => 'text_element',
				'type'  => 'textarea',
				'encode' => true,
				'meta'  => array(
						'class' => 'shortcake-richtext',
				),
			),
		),
	)
);
```

Outputting requires decoding, and since Shortcake uses url encoding, the attribute powered by the rich text editor needs to be urldecoded before rendering its contents, like in the following example using the `urldecode` [function](http://php.net/manual/ro/function.urldecode.php):

```php
function shortcode_name( $atts ) {
	extract( shortcode_atts(
		array(
			'text_element' => '',
		),
		$atts
	));
	return '<div>' . urldecode( $text_element ) . '</div>';
}
```

= This doesn't work although I added the class according to the instructions. Am I missing anything? =

Before submitting a report on the [GitHub Issue tracker](https://github.com/xwp/wp-shortcode-ui-richtext/issues), please ensure the issue you are experiencing does not exist with using the latest Shortcake (Shortcode UI) version downloaded from their own [GitHub repository](https://github.com/wp-shortcake/shortcake).

== Screenshots ==

1. This screenshot shows a rich text enabled textarea in the Shortcake interface.

== Changelog ==

= 0.1 (August 19, 2016) =
Initial release.

= 0.2 (October 3, 2016) =
Modified SummerNote default configuration to initialise a toolbar which is more Wordpress-friendly.
Added more examples to the readme.
Ads default rich text editing to the shortcode inner_content.

= 1.0 (April 25, 2017) =
Replaced SummerNote by highly requested TinyMCE for a familiar Wordpress experience.

= 1.1 (September 11, 2017) =
"Add Media" button is now present next to the TinyMCE editor.

= 1.2 (March 15, 2018) =
Fixes issues with multiple editors on page and timing issues with initialising and unloading TinyMCE.

= 1.3 (March 24, 2018) =
Fix active editor modal bug occurring when multiple fields had editors.

== Upgrade Notice ==

= 0.2 =
Added the rich text editor on the shortcode inner_content area.

= 1.0 =
Replaced SummerNote by TinyMCE editor. The HTML code editing is not available anymore for rich text elements.
