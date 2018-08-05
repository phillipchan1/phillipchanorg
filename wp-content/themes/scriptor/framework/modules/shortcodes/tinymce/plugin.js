(function () {

	// create ThemePileShortcodes plugin
	tinymce.create("tinymce.plugins.ThemePileShortcodes",
			{
				init         : function (ed, url) {

					ed.addCommand("themepilePopup", function (a, params) {
						var popup = params.identifier;
						tb_show("Insert ThemePile Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
					});
				},
				createControl: function (btn, e) {
					if (btn == "themepile_button") {
						var a = this;
						var btn = e.createSplitButton('themepile_button', {
							title: "Insert themepile Shortcode",
							image: ThemePileShortcodes.plugin_folder + "/tinymce/images/icon.png",
							icons: false
						});

						btn.onRenderMenu.add(function (c, b) {
							a.addWithPopup(b, "Alerts", "alert");
							a.addWithPopup(b, "Buttons", "button");
							a.addWithPopup(b, "Columns", "columns");
							a.addWithPopup(b, "Tabs", "tabs");
							a.addWithPopup(b, "Toggle", "toggle");
						});

						return btn;
					}

					return null;
				},
				addWithPopup : function (ed, title, id) {
					ed.add({
						title  : title,
						onclick: function () {
							tinyMCE.activeEditor.execCommand("themepilePopup", false, {
								title     : title,
								identifier: id
							})
						}
					})
				},
				addImmediate : function (ed, title, sc) {
					ed.add({
						title  : title,
						onclick: function () {
							tinyMCE.activeEditor.execCommand("mceInsertContent", false, sc)
						}
					})
				},
				getInfo      : function () {
					return {
						longname : 'ThemePile Shortcodes',
						author   : 'ThemePile',
						authorurl: 'http://themepile.co.uk',
						infourl  : 'http://wiki.moxiecode.com/',
						version  : "1.0"
					}
				}
			});

	// add ThemePileShortcodes plugin
	tinymce.PluginManager.add("ThemePileShortcodes", tinymce.plugins.ThemePileShortcodes);


})();