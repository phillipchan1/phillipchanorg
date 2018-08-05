// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function ($) {
	var themepiles = {
		loadVals : function () {
			var shortcode = $('#_themepile_shortcode').text(),
					uShortcode = shortcode;

			// fill in the gaps eg {{param}}
			$('.themepile-input').each(function () {
				var input = $(this),
						id = input.attr('id'),
						id = id.replace('themepile_', ''),		// gets rid of the themepile_ prefix
						re = new RegExp("{{" + id + "}}", "g");

				uShortcode = uShortcode.replace(re, input.val());
			});

			// adds the filled-in shortcode as hidden input
			$('#_themepile_ushortcode').remove();
			$('#themepile-sc-form-table').prepend('<div id="_themepile_ushortcode" class="hidden">' + uShortcode + '</div>');
		},
		cLoadVals: function () {
			var shortcode = $('#_themepile_cshortcode').text(),
					pShortcode = '';
			shortcodes = '';

			// fill in the gaps eg {{param}}
			$('.child-clone-row').each(function () {
				var row = $(this),
						rShortcode = shortcode;

				$('.themepile-cinput', this).each(function () {
					var input = $(this),
							id = input.attr('id'),
							id = id.replace('themepile_', '')		// gets rid of the themepile_ prefix
					re = new RegExp("{{" + id + "}}", "g");

					rShortcode = rShortcode.replace(re, input.val());
				});

				shortcodes = shortcodes + rShortcode + "\n";
			});

			// adds the filled-in shortcode as hidden input
			$('#_themepile_cshortcodes').remove();
			$('.child-clone-rows').prepend('<div id="_themepile_cshortcodes" class="hidden">' + shortcodes + '</div>');

			// add to parent shortcode
			this.loadVals();
			pShortcode = $('#_themepile_ushortcode').text().replace('{{child_shortcode}}', shortcodes);

			// add updated parent shortcode
			$('#_themepile_ushortcode').remove();
			$('#themepile-sc-form-table').prepend('<div id="_themepile_ushortcode" class="hidden">' + pShortcode + '</div>');
		},
		children : function () {
			// assign the cloning plugin
			$('.child-clone-rows').appendo({
				subSelect  : '> div.child-clone-row:last-child',
				allowDelete: false,
				focusFirst : false
			});

			// remove button
			$('.child-clone-row-remove').live('click', function () {
				var btn = $(this),
						row = btn.parent();

				if ($('.child-clone-row').size() > 1) {
					row.remove();
				}
				else {
					alert('You need a minimum of one row');
				}

				return false;
			});

			// assign jUI sortable
			$(".child-clone-rows").sortable({
				placeholder: "sortable-placeholder",
				items      : '.child-clone-row'

			});
		},
		resizeTB : function () {
			var ajaxCont = $('#TB_ajaxContent'),
					tbWindow = $('#TB_window'),
					themepilePopup = $('#themepile-popup');

			tbWindow.css({
				height    : themepilePopup.outerHeight() + 50,
				width     : themepilePopup.outerWidth(),
				marginLeft: -(themepilePopup.outerWidth() / 2)
			});

			ajaxCont.css({
				paddingTop  : 0,
				paddingLeft : 0,
				paddingRight: 0,
				height      : (tbWindow.outerHeight() - 47),
				overflow    : 'auto', // IMPORTANT
				width       : themepilePopup.outerWidth()
			});

			$('#themepile-popup').addClass('no_preview');
		},
		load     : function () {
			var themepiles = this,
					popup = $('#themepile-popup'),
					form = $('#themepile-sc-form', popup),
					shortcode = $('#_themepile_shortcode', form).text(),
					popupType = $('#_themepile_popup', form).text(),
					uShortcode = '';

			// resize TB
			themepiles.resizeTB();
			$(window).resize(function () {
				themepiles.resizeTB()
			});

			// initialise
			themepiles.loadVals();
			themepiles.children();
			themepiles.cLoadVals();

			// update on children value change
			$('.themepile-cinput', form).live('change', function () {
				themepiles.cLoadVals();
			});

			// update on value change
			$('.themepile-input', form).change(function () {
				themepiles.loadVals();
			});

			// when insert is clicked
			$('.themepile-insert', form).click(function () {
				if (window.tinyMCE) {
					window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $('#_themepile_ushortcode', form).html());
					tb_remove();
				}
			});
		}
	};

	// run
	$('#themepile-popup').livequery(function () {
		themepiles.load();
	});
});