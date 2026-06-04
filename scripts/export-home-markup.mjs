import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import cheerio from 'cheerio';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.resolve(__dirname, '..');
const indexHtml = path.join(root, 'dist/index.html');
const outDir = path.join(root, 'wp-theme/alergobot-theme/inc/markup/home');

const sectionMap = {
	hero: '.hero',
	audience: '.audience',
	'catalog-teaser': '.catalog-teaser',
	pick: '.pick',
	panels: '.panels',
	choose: '.choose',
	equipment: '.equipment',
	process: '.process',
	partners: '.partners',
	docs: '.docs',
	request: '.request',
	about: '.about',
	benefits: '.benefits',
	news: '.news',
	advantages: '.faq',
	contacts: '.contacts',
};

if (!fs.existsSync(indexHtml)) {
	console.error('Run npm run build first to create dist/index.html');
	process.exit(1);
}

const html = fs.readFileSync(indexHtml, 'utf8');
const $ = cheerio.load(html, { decodeEntities: false });

fs.mkdirSync(outDir, { recursive: true });

Object.entries(sectionMap).forEach(([file, selector]) => {
	const el = $(selector).first();
	if (!el.length) {
		console.warn('Missing section:', selector);
		return;
	}
	const content = $.html(el);
	fs.writeFileSync(path.join(outDir, `${file}.html`), content, 'utf8');
	console.log('Exported', file);
});
