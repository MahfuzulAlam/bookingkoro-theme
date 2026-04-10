/**
 * BookingKoro homepage interactions.
 *
 * Lightweight hero carousel and mobile navigation drawer.
 *
 * @package BookingKoro
 */

(function () {
	'use strict';

	function initHeroCarousel() {
		var carousel = document.getElementById('bkor-hero-carousel');
		if (!carousel) {
			return;
		}

		var list = carousel.querySelector('.bkor-hero__list');
		var items = carousel.querySelectorAll('.bkor-hero__item');
		var dots = carousel.querySelectorAll('.bkor-hero__dot');
		var prevButton = carousel.querySelector('.bkor-hero__arrow--prev');
		var nextButton = carousel.querySelector('.bkor-hero__arrow--next');

		if (!list || items.length < 2) {
			return;
		}

		var activeIndex = 0;
		var autoplayDelay = 5000;
		var autoplayTimer = null;
		var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

		function render() {
			list.style.transform = 'translateX(' + String(activeIndex * -100) + '%)';

			items.forEach(function (item, index) {
				item.classList.toggle('is-active', index === activeIndex);
			});

			dots.forEach(function (dot, index) {
				var isActive = index === activeIndex;
				dot.classList.toggle('is-active', isActive);
				dot.setAttribute('aria-current', isActive ? 'true' : 'false');
			});
		}

		function stopAutoplay() {
			if (autoplayTimer) {
				window.clearInterval(autoplayTimer);
				autoplayTimer = null;
			}
		}

		function startAutoplay() {
			if (reducedMotion.matches || document.hidden) {
				stopAutoplay();
				return;
			}

			stopAutoplay();
			autoplayTimer = window.setInterval(function () {
				goToSlide(activeIndex + 1);
			}, autoplayDelay);
		}

		function goToSlide(index) {
			var total = items.length;

			if (index < 0) {
				activeIndex = total - 1;
			} else if (index >= total) {
				activeIndex = 0;
			} else {
				activeIndex = index;
			}

			render();
		}

		if (prevButton) {
			prevButton.addEventListener('click', function () {
				goToSlide(activeIndex - 1);
				startAutoplay();
			});
		}

		if (nextButton) {
			nextButton.addEventListener('click', function () {
				goToSlide(activeIndex + 1);
				startAutoplay();
			});
		}

		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				var slideIndex = Number(dot.getAttribute('data-slide-index'));

				if (Number.isNaN(slideIndex)) {
					return;
				}

				goToSlide(slideIndex);
				startAutoplay();
			});
		});

		carousel.addEventListener('mouseenter', stopAutoplay);
		carousel.addEventListener('mouseleave', startAutoplay);
		carousel.addEventListener('focusin', stopAutoplay);
		carousel.addEventListener('focusout', function () {
			window.setTimeout(function () {
				if (!carousel.contains(document.activeElement)) {
					startAutoplay();
				}
			}, 0);
		});

		document.addEventListener('visibilitychange', function () {
			if (document.hidden) {
				stopAutoplay();
				return;
			}

			startAutoplay();
		});

		if (typeof reducedMotion.addEventListener === 'function') {
			reducedMotion.addEventListener('change', startAutoplay);
		} else if (typeof reducedMotion.addListener === 'function') {
			reducedMotion.addListener(startAutoplay);
		}

		render();
		startAutoplay();
	}

	function initMobileNavDrawer() {
		var toggle = document.querySelector('.bkor-nav-toggle');
		var nav = document.getElementById('bkor-nav-sec');
		var overlay = document.querySelector('.bkor-nav-overlay');
		var closeButton = nav ? nav.querySelector('.bkor-nav-sec__close') : null;

		if (!toggle || !nav || !overlay || !closeButton) {
			return;
		}

		function setOpen(isOpen) {
			nav.classList.toggle('is-open', isOpen);
			overlay.classList.toggle('is-open', isOpen);
			document.body.classList.toggle('bkor-nav-open', isOpen);
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

			if (isOpen) {
				var firstLink = nav.querySelector('.bkor-nav-sec__list a');
				(firstLink || closeButton).focus();
				return;
			}

			toggle.focus();
		}

		toggle.addEventListener('click', function () {
			setOpen(!nav.classList.contains('is-open'));
		});

		closeButton.addEventListener('click', function () {
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

		window.addEventListener('resize', function () {
			if (window.innerWidth > 768 && nav.classList.contains('is-open')) {
				setOpen(false);
			}
		});
	}

	function init() {
		initHeroCarousel();
		initMobileNavDrawer();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
