import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import cheerio from 'cheerio';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.resolve(__dirname, '..');
const distDir = path.join(root, 'dist');
const outDir = path.join(root, 'wp-theme/alergobot-theme/inc/markup/pages');

const pages = [
	'katalog.html',
	'kontakty.html',
	'analizatory.html',
	'stati.html',
	'statya.html',
	'product.html',
	'404.html',
	'politika-konfidentsialnosti.html',
];

fs.mkdirSync(outDir, { recursive: true });

pages.forEach((file) => {
	const src = path.join(distDir, file);
	if (!fs.existsSync(src)) {
		console.warn('Skip missing', file);
		return;
	}
	const $ = cheerio.load(fs.readFileSync(src, 'utf8'), { decodeEntities: false });
	const main = $('main').first();
	if (!main.length) {
		console.warn('No main in', file);
		return;
	}
	const wrapper = $('<div></div>').append(main.clone());
	fs.writeFileSync(path.join(outDir, file), $.html(main), 'utf8');
	console.log('Exported page', file);
});

// Popups from index is not ideal - compile from src via separate file
const popupsSrc = path.join(root, 'dist/homepage.html');
if (fs.existsSync(popupsSrc)) {
	const $ = cheerio.load(fs.readFileSync(popupsSrc, 'utf8'), { decodeEntities: false });
	const popups = $('.popups').first();
	if (popups.length) {
		fs.writeFileSync(
			path.join(root, 'wp-theme/alergobot-theme/inc/markup/_popups.html'),
			$.html(popups),
			'utf8'
		);
		console.log('Exported _popups.html');
	}
}
