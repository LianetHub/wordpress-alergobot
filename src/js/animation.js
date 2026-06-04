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

	initAudienceMolecules();
	initContactsParallax();
}

function initContactsParallax() {
	const box = document.querySelector("[data-contacts]");
	if (!box) return;

	const motionQuery = window.matchMedia("(prefers-reduced-motion: reduce)");

	const resetMotion = () => {
		box.style.removeProperty("--decor-y");
		box.style.removeProperty("--photo-y");
	};

	if (motionQuery.matches) {
		resetMotion();
		return;
	}

	let isActive = false;
	let rafId = null;

	const getScrollOffset = (factor) => {
		const rect = box.getBoundingClientRect();
		const viewportHeight = window.innerHeight;

		if (rect.bottom < 0 || rect.top > viewportHeight) return 0;

		const sectionCenter = rect.top + rect.height / 2;
		return (sectionCenter - viewportHeight / 2) * factor;
	};

	const updateMotion = () => {
		const decorOffset = getScrollOffset(0.06);
		const photoOffset = getScrollOffset(0.045);

		box.style.setProperty("--decor-y", `${decorOffset.toFixed(2)}px`);
		box.style.setProperty("--photo-y", `${photoOffset.toFixed(2)}px`);
	};

	const loop = () => {
		if (isActive) updateMotion();
		rafId = requestAnimationFrame(loop);
	};

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				isActive = entry.isIntersecting;
			});
		},
		{ threshold: 0.08 },
	);

	motionQuery.addEventListener("change", (event) => {
		if (event.matches) {
			isActive = false;
			resetMotion();
		} else {
			isActive = box.getBoundingClientRect().bottom > 0 && box.getBoundingClientRect().top < window.innerHeight;
		}
	});

	observer.observe(box);
	rafId = requestAnimationFrame(loop);
}

function initAudienceMolecules() {
	const scene = document.querySelector("[data-audience]");
	const molecules = scene?.querySelector(".audience__molecules");
	if (!scene || !molecules) return;

	const motionQuery = window.matchMedia("(prefers-reduced-motion: reduce)");

	const showStatic = () => {
		molecules.classList.add("is-visible");
		molecules.style.removeProperty("--mx");
		molecules.style.removeProperty("--my");
		molecules.style.removeProperty("--mrotate");
	};

	if (motionQuery.matches) {
		showStatic();
		return;
	}

	let isActive = false;
	let rafId = null;
	let pointerX = 0;
	let pointerY = 0;
	let targetPointerX = 0;
	let targetPointerY = 0;

	const getScrollOffset = () => {
		const rect = scene.getBoundingClientRect();
		const viewportHeight = window.innerHeight;

		if (rect.bottom < 0 || rect.top > viewportHeight) return 0;

		const sectionCenter = rect.top + rect.height / 2;
		return (sectionCenter - viewportHeight / 2) * 0.07;
	};

	const updateMotion = () => {
		pointerX += (targetPointerX - pointerX) * 0.08;
		pointerY += (targetPointerY - pointerY) * 0.08;

		const time = performance.now() * 0.001;
		const floatY = Math.sin(time * 0.85) * 7;
		const floatRotate = Math.sin(time * 0.55) * 1.1;
		const scrollOffset = getScrollOffset();

		molecules.style.setProperty("--mx", `${pointerX.toFixed(2)}px`);
		molecules.style.setProperty("--my", `${(scrollOffset + pointerY + floatY).toFixed(2)}px`);
		molecules.style.setProperty("--mrotate", `${floatRotate.toFixed(2)}deg`);
	};

	const loop = () => {
		if (isActive) updateMotion();
		rafId = requestAnimationFrame(loop);
	};

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				isActive = entry.isIntersecting;

				if (entry.isIntersecting) {
					molecules.classList.add("is-visible");
				}
			});
		},
		{ threshold: 0.08 },
	);

	scene.addEventListener(
		"mousemove",
		(event) => {
			const rect = scene.getBoundingClientRect();
			const x = (event.clientX - rect.left) / rect.width - 0.5;
			const y = (event.clientY - rect.top) / rect.height - 0.5;

			targetPointerX = x * 16;
			targetPointerY = y * 10;
		},
		{ passive: true },
	);

	scene.addEventListener("mouseleave", () => {
		targetPointerX = 0;
		targetPointerY = 0;
	});

	motionQuery.addEventListener("change", (event) => {
		if (event.matches) {
			isActive = false;
			showStatic();
		} else {
			molecules.classList.add("is-visible");
			isActive = scene.getBoundingClientRect().bottom > 0 && scene.getBoundingClientRect().top < window.innerHeight;
		}
	});

	observer.observe(scene);
	rafId = requestAnimationFrame(loop);
}
