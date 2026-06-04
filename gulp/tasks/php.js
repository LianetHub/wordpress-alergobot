export const php = () => {
	if (!app.path.src.php) {
		return app.gulp.dest('.', { cwd: process.cwd() });
	}
	return app.gulp
		.src(app.path.src.php, { base: 'src/theme-php' })
		.pipe(app.gulp.dest(app.path.build.php))
		.pipe(app.plugins.browsersync.stream());
};
