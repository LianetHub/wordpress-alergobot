"use strict";

const COOKIE_NAME = "alergobot_cookie_notice";
const COOKIE_DAYS = 180;
const SHOW_DELAY_MS = 3000;
const HIDE_ANIMATION_MS = 500;

/**
 * @param {string} name
 * @param {string} value
 * @param {{ expires?: number; path?: string }} [options]
 */
function setCookie(name, value, options = {}) {
	const opts = { ...options };
	let expires = opts.expires;

	if (typeof expires === "number" && expires > 0) {
		const date = new Date();
		date.setTime(date.getTime() + expires * 1000);
		expires = date;
	}

	if (expires instanceof Date) {
		opts.expires = expires.toUTCString();
	}

	let cookie = `${encodeURIComponent(name)}=${encodeURIComponent(value)}`;

	Object.keys(opts).forEach((key) => {
		cookie += `; ${key}`;
		const propValue = opts[key];

		if (propValue !== true) {
			cookie += `=${propValue}`;
		}
	});

	document.cookie = cookie;
}

export function initCookieNotice() {
	const notice = document.getElementById("cookie-notice");

	if (!notice) return;

	const acceptBtn = notice.querySelector(".cookie__accept");

	if (!acceptBtn) return;

	const showTimer = window.setTimeout(() => {
		notice.classList.remove("cookie--hidden");
	}, SHOW_DELAY_MS);

	const hideNotice = () => {
		window.clearTimeout(showTimer);
		notice.classList.add("cookie--hidden");

		window.setTimeout(() => {
			notice.remove();
		}, HIDE_ANIMATION_MS);
	};

	acceptBtn.addEventListener("click", () => {
		setCookie(COOKIE_NAME, "1", {
			expires: COOKIE_DAYS * 24 * 60 * 60,
			path: "/",
			sameSite: "Lax",
		});
		hideNotice();
	});
}
