/* globals jQuery, alert */
jQuery(function( $ ) {
	'use strict';

  var activeEditor;
  var currentEditor;
	var loadedEditors = []; 
	var modalFrame;
	var richText = {};
	var richTextSelector = 'textarea.shortcake-richtext, #inner_content';


	$(document).on('click', '.shortcake-insert-media-modal', function(event){

		if ( ! modalFrame ) {
			modalFrame= wp.media( {
				multiple: false
			} );
			modalFrame.on( 'select', function(event) {
				// Get media attachment details from the frame state
				var attachment = modalFrame.state().get('selection').first().toJSON();

				var $img = $(
					'<img>',
					{
						src: attachment.url,
						alt: attachment.alt
					}
				);
				
				if (activeEditor) {
					tinymce
						.get(activeEditor)
						.insertContent($img.prop('outerHTML'));
        }
			} );
		}

		activeEditor = $( this ).data( 'editor' );
		modalFrame.open();

	});

	/**
	 * Loads tinyMCE rich text editor.
	 *
	 * @param {string} selector
	 * @returns {boolean}
	 */
	richText.load = function( selector ) {
		currentEditor = wpActiveEditor;
		if ( ( 'undefined' !== tinyMCE ) && ( $( selector ).length ) ) {
			$( selector ).each( function() {

				var textarea_id = $(this).attr('id');
				var $this = $(this);

				if( null === tinyMCE.get( textarea_id ) ) {

					// Add a slight delay to offset the loading of any elements on the page. Sometimes doesn't load correctly
					setTimeout(function () {
						var $button = $(
							'<button>',
							{
								type: 'button',
								"class": 'button shortcake-insert-media-modal',
								text: 'Add Media'
							}
						).data('editor', textarea_id);
						$this.before($button);
						// Bind tinyMCE to this field
						tinyMCE.execCommand('mceAddEditor', false, textarea_id );
						tinyMCE.execCommand('mceAddControl', false, textarea_id );
						loadedEditors.push(tinyMCE.get(textarea_id));
					}, 200);

				}

			});

			return true;
		} else {
			return false;
		}
	};

	/**
	 * Unloads tinyMCE rich text editor.
	 *
	 * @param {string} selector
	 * @returns {boolean}
	 */
	richText.unload = function( selector ) {
		var editor;
		while (editor = loadedEditors.pop()) {
			var $textarea = $('#' + editor.id);
			if ($textarea.length) {
				$textarea.text(editor.getContent())
					.trigger('input');
			}
			editor.remove();
		}

		// Switch the global active editor back to the WordPress editor
		wpActiveEditor = currentEditor;
	};

	if ( 'undefined' !== typeof( wp.shortcake ) ) {
		wp.shortcake.hooks.addAction( 'shortcode-ui.render_edit', function(shortcodeModel) {
			richText.loaded = richText.load( richTextSelector );
			$('.media-modal .media-modal-close').click(function() {
				wp.shortcake.hooks.doAction( 'shortcode-ui.render_closed', shortcodeModel );
			});
		} );
		wp.shortcake.hooks.addAction( 'shortcode-ui.render_new', function() {
			richText.loaded = richText.load( richTextSelector );
		} );
		wp.shortcake.hooks.addAction( 'shortcode-ui.render_destroy', function() {
			richText.unload( richTextSelector );
		} );

		wp.shortcake.hooks.addAction( 'shortcode-ui.render_closed', function() {
			richText.unload( richTextSelector );
		} );
	}

} );
