/* globals jQuery, alert */
jQuery(function( $ ) {
	'use strict';

	var richTextSelector = 'textarea.shortcake-richtext',
		richText = {},
		escapeMarkup;

	/**
	 * Escapes shortcode special characters (",[,])
	 *
	 * @param {string} htmlCode
	 * @returns {string}
	*/
	richText.escapeMarkup = function( htmlCode ) {
		var escapedHtmlCode = htmlCode,
			tagsWithQuotesOrBrakets = /(<[^>]*[\[,\],"][^>]*>)/g,
			escapeQuotesBrachetsInsideTag,
			escapeQuotesBrachetsOutsideOfTags;

		escapeQuotesBrachetsInsideTag = function( match, tag ) {
			tag = tag.replace(/"/g, "'"); // replaces " by '
			tag = tag.replace(/[\[,\]]/g, ""); // removes [ and ]
			return tag;
		};

		escapeQuotesBrachetsOutsideOfTags = function( markup ) {
			var escapedMarkup = markup;
			escapedMarkup = escapedMarkup.replace(/"/g, "&quot;");
			escapedMarkup = escapedMarkup.replace(/\[/g, "&#91;");
			escapedMarkup = escapedMarkup.replace(/\]/g, "&#93;");
			return escapedMarkup;
		};

		escapedHtmlCode = htmlCode.replace(tagsWithQuotesOrBrakets, escapeQuotesBrachetsInsideTag);
		escapedHtmlCode = escapeQuotesBrachetsOutsideOfTags( escapedHtmlCode );

		return escapedHtmlCode;
	}

	/**
	 * Loads summernote rich text editor.
	 *
	 * @param {string} selector
	 * @returns {boolean}
	*/
	richText.load = function( selector ) {
		if ( ( 'undefined' !== $.fn.summernote ) && ( $( selector ).length ) ) {
			$( selector ).summernote();
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
				var htmlCode = richText.escapeMarkup( $( this ).summernote( 'code' ) );
				$( this )
					.text( htmlCode )
					.trigger( 'input' );
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
