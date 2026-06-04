"use strict";

export function initAnimation() {
	const counters = document.querySelectorAll("[data-counter]");
	const animationSections = document.querySelectorAll("[data-animate]");

	if (counters.length > 0) {
		const animationDuration = 2000;

		const counterObserver = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting && !entry.target.classList.contains("animated")) {
						entry.target.classList.add("animated");
						startCounter(entry.target);
					}
				});
			},
			{ threshold: 0.1 },
		);

		counters.forEach((el) => counterObserver.observe(el));

		function startCounter(el) {
			const originalText = el.textContent.trim();
			const targetNumber = parseInt(originalText.replace(/\D/g, ""), 10);
			const suffix = originalText.replace(/[0-9\s\u00A0\u202F]/g, "");

			const startNumber = Math.floor(targetNumber * 0.8);
			const startTime = performance.now();
			const animationDuration = 1500;

			const formatNumber = (num) => {
				return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "\u00A0");
			};

			const updateCounter = (currentTime) => {
				const elapsedTime = currentTime - startTime;
				const progress = Math.min(elapsedTime / animationDuration, 1);

				const currentCount = Math.floor(startNumber + progress * (targetNumber - startNumber));

				el.textContent = formatNumber(currentCount) + (suffix ? " " + suffix : "");

				if (progress < 1) {
					requestAnimationFrame(updateCounter);
				} else {
					el.textContent = formatNumber(targetNumber) + (suffix ? " " + suffix : "");
				}
			};

			requestAnimationFrame(updateCounter);
		}
	}

	if (animationSections.length > 0) {
		const sectionObserver = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						entry.target.classList.add("animated");
					}
				});
			},
			{ threshold: 0.1 },
		);

		animationSections.forEach((section) => sectionObserver.observe(section));
	}
}
