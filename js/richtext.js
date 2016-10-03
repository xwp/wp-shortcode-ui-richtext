/* globals jQuery, alert */
jQuery(function( $ ) {
	'use strict';

	var richTextSelector = 'textarea.shortcake-richtext';
	var richText = {};

	/**
	 * Loads summernote rich text editor.
	 *
	 * @param {string} selector
	 * @returns {boolean}
	*/
	richText.load = function( selector ) {
		if ( ( 'undefined' !== $.fn.summernote ) && ( $( selector ).length ) ) {
			$( selector ).summernote({
				toolbar: [
					[ 'style', ['style'] ],
					[ 'para', [ 'ul', 'ol' ] ],
					[ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear' ] ],
					[ 'fontsize' , [ 'fontsize' ] ],
					[ 'color', [ 'color' ] ],
					[ 'table', [ 'table' ] ],
					[ 'insert', [ 'link', 'picture', 'video' ] ],
					[ 'view', [ 'codeview', 'help' ] ]
				]
			});
			return true;
		} else {
			return false;
		}
	};

	/**
	 * Unloads summernote rich text editor.
	 *
	 * @param {string} selector
	 * @returns {boolean}
	*/
	richText.unload = function( selector ) {
		if ( ( 'undefined' !== $.fn.summernote ) && ( $( selector ).length ) ) {
			$( selector ).each( function() {
				/* TODO: Handle ", [, ] */
				$( this )
					.text( $( this ).summernote( 'code' ) )
					.trigger( 'input' )
					.summernote( 'destroy' );
			});
			return true;
		} else {
			return false;
		}
	};

	wp.shortcake.hooks.addAction( 'shortcode-ui.render_edit', function() {
		richText.loaded = richText.load( richTextSelector );
	} );
	wp.shortcake.hooks.addAction( 'shortcode-ui.render_new', function() {
		richText.loaded = richText.load( richTextSelector );
	} );
	wp.shortcake.hooks.addAction( 'shortcode-ui.render_destroy', function() {
		if ( richText.loaded ) {
			richText.unload( richTextSelector );
		}
	} );

} );
