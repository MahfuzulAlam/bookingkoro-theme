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
			autoplay: true,
		}).mount();
	}

	function initMobileNavDrawer() {
		var toggle = document.querySelector('.bkor-nav-toggle');
		var nav = document.getElementById('bkor-nav-sec');
		var overlay = document.querySelector('.bkor-nav-overlay');
		var closeBtn = nav ? nav.querySelector('.bkor-nav-sec__close') : null;

		if (!toggle || !nav || !overlay || !closeBtn) return;

		function setOpen(isOpen) {
			nav.classList.toggle('is-open', isOpen);
			overlay.classList.toggle('is-open', isOpen);
			document.body.classList.toggle('bkor-nav-open', isOpen);
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		}

		toggle.addEventListener('click', function () {
			setOpen(!nav.classList.contains('is-open'));
		});

		closeBtn.addEventListener('click', function () {
			setOpen(false);
		});

		overlay.addEventListener('click', function () {
			setOpen(false);
		});

		nav.addEventListener('click', function (event) {
			if (event.target.closest('.bkor-nav-sec__list a')) {
				setOpen(false);
			}
		});

		document.addEventListener('keydown', function (event) {
			if ('Escape' === event.key && nav.classList.contains('is-open')) {
				setOpen(false);
			}
		});
	}

	function init() {
		initCarouselArrows();
		initHeroSplide();
		initMobileNavDrawer();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
