/**
 * BookingKoro Homepage – Splide hero and horizontal card rows
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
				var section = arrow.closest('.bkor-stream, .bkor-section');
				if (!section) return;
				var track = section.querySelector('.bkor-cards--scroll');
				if (!track) return;
				var isPrev = arrow.classList.contains('bkor-carousel-arrow--prev');
				var step = track.offsetWidth * 0.6;
				track.scrollBy({ left: isPrev ? -step : step, behavior: 'smooth' });
			});
		});
	}

	function initHeroSplide() {
		if (typeof Splide === 'undefined') return;

		var el = document.getElementById('bkor-hero-splide');
		if (!el) return;

		var slides = el.querySelectorAll('.splide__slide');
		var count = slides.length;
		if (count < 1) return;

		var multi = count > 1;

		new Splide(el, {
			type: multi ? 'loop' : 'slide',
			perPage: 1,
			gap: 0,
			speed: 500,
			arrows: multi,
			pagination: multi,
			drag: multi,
			keyboard: multi,
		}).mount();
	}

	function init() {
		initCarouselArrows();
		initHeroSplide();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
