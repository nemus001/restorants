"use strict";
let Global = require('./global');
module.exports = {
	/*-------------------------------------------------------------------------------
		# Cache dom and strings
	-------------------------------------------------------------------------------*/
	$dom: {
		wpAdminBar: $('#wpadminbar'),
		siteHeader: $('.site-header'),
	},

	/*-------------------------------------------------------------------------------
		# Initialize
	-------------------------------------------------------------------------------*/
	init: function () {
		let $dom = this.$dom;

		function moveIfAdminBar() {
			$dom.siteHeader.css('top', $dom.wpAdminBar.height());
			$dom.wpAdminBar.css('position', 'fixed');
		};

		function addGlobalContentOffset(admBarH = 0) {
			$('.global-margin-top').css('margin-top', $dom.siteHeader[0].getBoundingClientRect().bottom + 'px');
			$('.global-padding-top').css('padding-top', $dom.siteHeader[0].getBoundingClientRect().bottom + 'px');
			$('.global-admin-margin').css('margin-top', admBarH + 'px');
		}

		if ($dom.wpAdminBar.length > 0) {
			moveIfAdminBar();
			addGlobalContentOffset($dom.wpAdminBar.height());
		} else {
			addGlobalContentOffset();
		}

		Global.$dom.window.on('resize', function () {			
			clearTimeout(window.resizedFinished);
			window.resizedFinished = setTimeout(function () {
				if ($dom.wpAdminBar.length > 0) {
					moveIfAdminBar();
					addGlobalContentOffset($dom.wpAdminBar.height());
				} else {
					addGlobalContentOffset();
				}
			}, 250);
		});
	}
};