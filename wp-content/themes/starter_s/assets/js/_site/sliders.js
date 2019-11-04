"use strict";
module.exports = {
	/*-------------------------------------------------------------------------------
		# Cache dom and strings
	-------------------------------------------------------------------------------*/
	$dom: {
		slider: $('.js-slider')
	},

	/*-------------------------------------------------------------------------------
		# Initialize
	-------------------------------------------------------------------------------*/
	init: function () {
		// get dom and strings
		var $dom = this.$dom;

		// slider
		$dom.slider.slick({
			infinite: true,
			slidesToShow: 4,
			slidesToScroll: 1,
			speed: 1000,
			arrows: false,
			responsive: [
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 3
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 2
					}
				}
			]
		});
	}
};