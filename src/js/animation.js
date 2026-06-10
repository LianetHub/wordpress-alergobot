"use strict";

const IMMEDIATE_ANIMATION_ROOTS = [".hero", ".heading", ".product-hero", ".not-found"];

let animItems = [];
let animTicking = false;
let scrollInitialized = false;

export function initAnimation() {
	initRipple();
	initScrollAnimation();
	initImmediateAnimation();
	initAudienceMolecules();
	initDecorParallax();
}

export function refreshScrollAnimations(root = document) {
	const scope = root instanceof Element ? root : document;
	const newItems = scope.querySelectorAll("._anim-items");

	newItems.forEach((item) => {
		if (!animItems.includes(item)) {
			animItems.push(item);
		}
	});

	animOnScroll();
}

function initRipple() {
	document.querySelectorAll(".a-ripple").forEach((el) => {
		el.addEventListener("mouseenter", (e) => {
			if (window.innerWidth < 1200) return;

			const point = e.touches ? e.touches[0] : e;
			const rect = el.getBoundingClientRect();
			const diameter = Math.sqrt(rect.width ** 2 + rect.height ** 2) * 2;

			el.style.cssText = "--s: 0; --o: 1;";
			el.offsetTop;
			el.style.cssText = `--t: 1; --o: 0; --d: ${diameter}; --x:${point.clientX - rect.left}; --y:${point.clientY - rect.top};`;
		});
	});
}

function initScrollAnimation() {
	animItems = [...document.querySelectorAll("._anim-items")];

	if (!animItems.length) return;

	if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
		animItems.forEach((item) => item.classList.add("_active"));
		return;
	}

	if (!scrollInitialized) {
		window.addEventListener("scroll", handleAnimScroll, { passive: true });
		scrollInitialized = true;
	}

	setTimeout(animOnScroll, 200);
}

function handleAnimScroll() {
	if (!animTicking) {
		requestAnimationFrame(() => {
			animOnScroll();
			animTicking = false;
		});
		animTicking = true;
	}
}

function animOnScroll() {
	animItems.forEach((item) => {
		const rect = item.getBoundingClientRect();
		const inView = rect.top < window.innerHeight * 0.95 && rect.bottom > 0;

		if (inView) {
			if (!item.classList.contains("_active")) {
				item.classList.add("_active");
				item.querySelectorAll("[data-counter], [data-num]").forEach((num) => {
					if (num.dataset.counter !== undefined) {
						startCounter(num);
					} else {
						animateNumber(num);
					}
				});
			}
		} else if (!item.classList.contains("_anim-no-hide")) {
			item.classList.remove("_active");
			resetItemAnimations(item);
		}
	});
}

function resetItemAnimations(container) {
	container.querySelectorAll("[data-num]").forEach((num) => {
		num.textContent = "0";
	});
}

function animateNumber(el, duration = 700) {
	const end = parseInt(el.dataset.num, 10);
	if (Number.isNaN(end)) return;

	let startTime = null;

	const step = (timestamp) => {
		if (!startTime) startTime = timestamp;

		const progress = Math.min((timestamp - startTime) / duration, 1);
		el.textContent = String(Math.floor(end * progress));

		if (progress < 1) {
			requestAnimationFrame(step);
		} else {
			el.textContent = String(end);
		}
	};

	requestAnimationFrame(step);
}

function startCounter(el) {
	if (el.dataset.counterStarted === "true") return;
	el.dataset.counterStarted = "true";

	const originalText = el.textContent.trim();
	const targetNumber = parseInt(originalText.replace(/\D/g, ""), 10);
	const suffix = originalText.replace(/[0-9\s\u00A0\u202F]/g, "");
	const startNumber = Math.floor(targetNumber * 0.8);
	const startTime = performance.now();
	const animationDuration = 1500;

	const formatNumber = (num) => num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "\u00A0");

	const updateCounter = (currentTime) => {
		const elapsedTime = currentTime - startTime;
		const progress = Math.min(elapsedTime / animationDuration, 1);
		const currentCount = Math.floor(startNumber + progress * (targetNumber - startNumber));

		el.textContent = formatNumber(currentCount) + (suffix ? ` ${suffix}` : "");

		if (progress < 1) {
			requestAnimationFrame(updateCounter);
		} else {
			el.textContent = formatNumber(targetNumber) + (suffix ? ` ${suffix}` : "");
		}
	};

	requestAnimationFrame(updateCounter);
}

function initImmediateAnimation() {
	const selector = IMMEDIATE_ANIMATION_ROOTS.map((root) => `${root} ._anim-items`).join(", ");
	const items = document.querySelectorAll(selector);
	if (!items.length) return;

	const reveal = () => {
		items.forEach((el) => {
			el.classList.add("_active", "_anim-no-hide");
		});
	};

	if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
		reveal();
		return;
	}

	requestAnimationFrame(reveal);
}

function initDecorParallax() {
	const scenes = document.querySelectorAll("[data-decor-parallax]");
	if (!scenes.length) return;

	const motionQuery = window.matchMedia("(prefers-reduced-motion: reduce)");
	const activeScenes = new Set();

	const resetScene = (el) => {
		el.style.removeProperty("--decor-y");
		el.style.removeProperty("--decor-scale");
	};

	const resetAll = () => {
		scenes.forEach(resetScene);
	};

	if (motionQuery.matches) {
		resetAll();
		return;
	}

	const getScrollOffset = (el, factor) => {
		const rect = el.getBoundingClientRect();
		const viewportHeight = window.innerHeight;

		if (rect.bottom < 0 || rect.top > viewportHeight) return 0;

		const sectionCenter = rect.top + rect.height / 2;
		return (sectionCenter - viewportHeight / 2) * factor;
	};

	const updateMotion = () => {
		activeScenes.forEach((el) => {
			const factor = Number(el.dataset.decorParallax) || 0.24;
			const decorOffset = getScrollOffset(el, factor);
			const scale = 1 + Math.abs(decorOffset) * 0.0006;

			el.style.setProperty("--decor-y", `${decorOffset.toFixed(2)}px`);
			el.style.setProperty("--decor-scale", scale.toFixed(4));
		});
	};

	const loop = () => {
		if (activeScenes.size) updateMotion();
		requestAnimationFrame(loop);
	};

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					activeScenes.add(entry.target);
				} else {
					activeScenes.delete(entry.target);
					resetScene(entry.target);
				}
			});
		},
		{ threshold: 0.08 },
	);

	scenes.forEach((el) => observer.observe(el));

	motionQuery.addEventListener("change", (event) => {
		if (event.matches) {
			activeScenes.clear();
			resetAll();
		} else {
			scenes.forEach((el) => {
				const rect = el.getBoundingClientRect();

				if (rect.bottom > 0 && rect.top < window.innerHeight) {
					activeScenes.add(el);
				}
			});
		}
	});

	requestAnimationFrame(loop);
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
		requestAnimationFrame(loop);
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
	requestAnimationFrame(loop);
}
