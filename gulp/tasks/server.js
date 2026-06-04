import { env } from '../config/env.js';

export const server = (done) => {
	app.plugins.browsersync.init({
		server: {
			baseDir: `${app.path.build.html}`,
		},
		notify: false,
		port: 3000,
	});
	done();
};

export const serverTheme = (done) => {
	app.plugins.browsersync.init({
		proxy: env.WP_PROXY_URL,
		notify: false,
		port: 3000,
	});
	done();
};
