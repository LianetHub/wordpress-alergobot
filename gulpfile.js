import gulp from 'gulp';

import { path, resolveBuildPath, resolveCleanPath } from './gulp/config/path.js';
import { plugins } from './gulp/config/plugins.js';

function initApp(isTheme = false) {
	const build = resolveBuildPath(isTheme);
	global.app = {
		isBuild: process.argv.includes('--build'),
		isDev: !process.argv.includes('--build'),
		isTheme,
		path: {
			...path,
			build,
			clean: resolveCleanPath(isTheme),
			src: path.src,
			watch: path.watch,
			srcFolder: path.srcFolder,
			rootFolder: path.rootFolder,
			ftp: path.ftp,
		},
		gulp,
		plugins,
	};
}

initApp(false);

import { copy } from './gulp/tasks/copy.js';
import { reset } from './gulp/tasks/reset.js';
import { html } from './gulp/tasks/html.js';
import { server, serverTheme } from './gulp/tasks/server.js';
import { scss, scssEntries, copyCssLibs, normalize } from './gulp/tasks/scss.js';
import { js, copyJsLibs, jsChunks } from './gulp/tasks/js.js';
import { images, favicon } from './gulp/tasks/images.js';
import {
	otf2ttf,
	ttfToWoff,
	copyWoff,
	fontsStyle,
} from './gulp/tasks/fonts.js';
import { zip } from './gulp/tasks/zip.js';
import { json } from './gulp/tasks/json.js';

function watcherLayout() {
	gulp.watch(path.watch.files, copy);
	gulp.watch(path.watch.html, html);
	gulp.watch(path.watch.scss, gulp.parallel(scss, scssEntries));
	gulp.watch(path.watch.normalize, normalize);
	gulp.watch(path.watch.js, js);
	gulp.watch(path.watch.json, json);
	gulp.watch(path.watch.images, images);
	gulp.watch(path.watch.fonts, fonts);
}

function watcherTheme() {
	gulp.watch(path.watch.files, copy);
	gulp.watch(path.watch.scss, gulp.parallel(scss, scssEntries));
	gulp.watch(path.watch.normalize, normalize);
	gulp.watch(path.watch.js, js);
	gulp.watch(path.watch.json, json);
	gulp.watch(path.watch.images, images);
	gulp.watch(path.watch.fonts, fonts);
	gulp.watch(path.watch.php).on('change', app.plugins.browsersync.reload);
}

const fonts = gulp.series(otf2ttf, ttfToWoff, copyWoff, fontsStyle);

const assetsTasks = gulp.parallel(
	copy,
	normalize,
	scss,
	scssEntries,
	copyCssLibs,
	favicon,
	js,
	copyJsLibs,
	jsChunks,
	json,
	images
);

const mainTasksLayout = gulp.series(fonts, gulp.parallel(copy, html, assetsTasks));
const mainTasksTheme = gulp.series(fonts, assetsTasks);

const dev = gulp.series(reset, mainTasksLayout, gulp.parallel(watcherLayout, server));
const build = gulp.series(reset, mainTasksLayout);

const buildTheme = gulp.series(
	(done) => {
		initApp(true);
		done();
	},
	reset,
	mainTasksTheme
);

const watchTheme = gulp.series(
	(done) => {
		initApp(true);
		done();
	},
	reset,
	mainTasksTheme,
	gulp.parallel(watcherTheme, serverTheme)
);

const deployZIP = gulp.series(reset, mainTasksLayout, zip);

export { dev };
export { build };
export { buildTheme };
export { watchTheme };
export { deployZIP };

gulp.task('default', dev);
gulp.task('buildTheme', buildTheme);
gulp.task('watchTheme', watchTheme);
