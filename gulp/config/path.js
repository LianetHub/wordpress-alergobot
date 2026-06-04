import * as nodePath from 'path';
import { getThemeAssetsDir } from './env.js';

const rootFolder = nodePath.basename(nodePath.resolve());
const layoutBuildFolder = `./dist`;
const srcFolder = `./src`;

function buildPaths(buildRoot) {
	return {
		files: `${buildRoot}/files/`,
		html: buildRoot === layoutBuildFolder ? `${buildRoot}/` : null,
		css: `${buildRoot}/css/`,
		cssLibs: `${buildRoot}/css/libs/`,
		normalize: `${buildRoot}/css/`,
		js: `${buildRoot}/js/`,
		jsLibs: `${buildRoot}/js/libs/`,
		jsChunks: `${buildRoot}/js/`,
		images: `${buildRoot}/img/`,
		favicon: `${buildRoot}/`,
		fonts: `${buildRoot}/fonts/`,
		json: `${buildRoot}/json/`,
		php: null,
	};
}

const layoutBuild = buildPaths(layoutBuildFolder);
layoutBuild.html = `${layoutBuildFolder}/`;
layoutBuild.php = `${layoutBuildFolder}/`;

const themeAssets = getThemeAssetsDir().replace(/\\/g, '/');
const themeBuild = buildPaths(themeAssets);
themeBuild.php = `${nodePath.dirname(themeAssets).replace(/\\/g, '/')}/`;

export const path = {
	layout: {
		build: layoutBuild,
		clean: layoutBuildFolder,
	},
	theme: {
		build: themeBuild,
		clean: themeAssets,
		themeRoot: themeBuild.php,
	},
	src: {
		files: `${srcFolder}/files/**/*.*`,
		html: `${srcFolder}/*.html`,
		scss: `${srcFolder}/scss/style.scss`,
		scssEntries: `${srcFolder}/scss/entries/*.scss`,
		cssLibs: `${srcFolder}/scss/libs/**/*.*`,
		normalize: `${srcFolder}/scss/reset.scss`,
		favicon: `${srcFolder}/fav/**/*`,
		js: `${srcFolder}/js/app.js`,
		jsLibs: `${srcFolder}/js/libs/**/*.*`,
		jsChunks: `${srcFolder}/js/chunks/**/*.*`,
		images: `${srcFolder}/img/**/*.{jpg,jpeg,png,gif,webp}`,
		svg: `${srcFolder}/img/**/*.svg`,
		json: `${srcFolder}/json/*.*`,
		php: `${srcFolder}/theme-php/**/*.php`,
	},
	watch: {
		files: `${srcFolder}/files/**/*.*`,
		html: `${srcFolder}/**/*.html`,
		scss: `${srcFolder}/scss/**/*.scss`,
		normalize: `${srcFolder}/scss/reset.scss`,
		js: `${srcFolder}/js/**/*.js`,
		images: `${srcFolder}/img/**/*.{jpg,jpeg,png,svg,gif,ico,webp}`,
		json: `${srcFolder}/json/*.*`,
		fonts: `${srcFolder}/fonts/*.{ttf,otf,woff,woff2}`,
		php: `wp-theme/alergobot-theme/**/*.php`,
	},
	srcFolder,
	rootFolder,
	ftp: '',
};

export function resolveBuildPath(isTheme) {
	return isTheme ? path.theme.build : path.layout.build;
}

export function resolveCleanPath(isTheme) {
	return isTheme ? path.theme.clean : path.layout.clean;
}
