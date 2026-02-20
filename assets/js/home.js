/**
 * BookingKoro Homepage – carousel arrow scroll
 *
 * @package BookingKoro
 */

(function () {
	'use strict';

	function initCarouselArrows() {
		var arrows = document.querySelectorAll('.bkor-carousel-arrow');
		if (!arrows.length) return;

		arrows.forEach(function (arrow) {
			arrow.addEventListener('click', function () {
				var section = arrow.closest('.bkor-hero, .bkor-stream, .bkor-section');
				if (!section) return;
				var track = section.querySelector('.bkor-cards--scroll, .bkor-hero__track');
				if (!track) return;
				var isPrev = arrow.classList.contains('bkor-carousel-arrow--prev');
				var step = track.offsetWidth * 0.6;
				track.scrollBy({ left: isPrev ? -step : step, behavior: 'smooth' });
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initCarouselArrows);
	} else {
		initCarouselArrows();
	}
})();
