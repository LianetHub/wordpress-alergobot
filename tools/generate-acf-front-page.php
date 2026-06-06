<?php
/**
 * One-off generator for front page ACF JSON files.
 * Run: php tools/generate-acf-front-page.php
 */

$out_dir = dirname(__DIR__) . '/acf-json';

function acf_key(string $prefix): string {
	static $n = 0;
	return $prefix . '_' . substr(md5((string) (++$n) . microtime()), 0, 13);
}

function field_text(string $name, string $label, array $extra = []): array {
	return array_merge([
		'key' => acf_key('field'),
		'label' => $label,
		'name' => $name,
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'wrapper' => ['width' => '', 'class' => '', 'id' => ''],
	], $extra);
}

function field_textarea(string $name, string $label, array $extra = []): array {
	return array_merge(field_text($name, $label), ['type' => 'textarea', 'rows' => 3, 'new_lines' => ''], $extra);
}

function field_wysiwyg(string $name, string $label, array $extra = []): array {
	return array_merge([
		'key' => acf_key('field'),
		'label' => $label,
		'name' => $name,
		'type' => 'wysiwyg',
		'tabs' => 'all',
		'toolbar' => 'basic',
		'media_upload' => 0,
		'delay' => 0,
	], $extra);
}

function field_link(string $name, string $label): array {
	return [
		'key' => acf_key('field'),
		'label' => $label,
		'name' => $name,
		'type' => 'link',
		'return_format' => 'array',
	];
}

function field_true_false(string $name, string $label): array {
	return [
		'key' => acf_key('field'),
		'label' => $label,
		'name' => $name,
		'type' => 'true_false',
		'ui' => 1,
		'default_value' => 0,
	];
}

function field_date(string $name, string $label): array {
	return [
		'key' => acf_key('field'),
		'label' => $label,
		'name' => $name,
		'type' => 'date_picker',
		'display_format' => 'd.m.Y',
		'return_format' => 'Y-m-d',
		'first_day' => 1,
	];
}

function field_select(string $name, string $label, array $choices): array {
	return [
		'key' => acf_key('field'),
		'label' => $label,
		'name' => $name,
		'type' => 'select',
		'choices' => $choices,
		'return_format' => 'value',
	];
}

function field_repeater(string $name, string $label, array $sub_fields, array $extra = []): array {
	return array_merge([
		'key' => acf_key('field'),
		'label' => $label,
		'name' => $name,
		'type' => 'repeater',
		'layout' => 'block',
		'button_label' => 'Добавить',
		'sub_fields' => $sub_fields,
		'min' => 0,
		'max' => 0,
	], $extra);
}

function layout(string $name, string $label, array $sub_fields): array {
	return [
		'key' => acf_key('layout'),
		'name' => $name,
		'label' => $label,
		'display' => 'block',
		'sub_fields' => $sub_fields,
		'min' => '',
		'max' => '',
	];
}

$hero_icons = [
	'icon-hero-chemistry' => 'Химия',
	'icon-hero-panels' => 'Панели',
	'icon-hero-microscope' => 'Микроскоп',
	'icon-hero-doc' => 'Документ',
];

$layouts = [
	layout('hero', 'Hero', [
		field_textarea('title', 'Заголовок'),
		field_textarea('note_text', 'Текст под кнопками'),
		field_link('btn_catalog', 'Кнопка «Каталог»'),
		field_text('btn_presentation_label', 'Кнопка «Презентация»', ['default_value' => 'Запросить презентацию']),
		field_text('flag_image_path', 'Флаг (путь assets)'),
		field_text('flag_image_alt', 'Флаг alt'),
		field_repeater('cards', 'Карточки', [
			field_select('icon', 'Иконка', $hero_icons),
			field_textarea('text', 'Текст'),
		]),
	]),
	layout('audience', 'Аудитория', [
		field_textarea('title', 'Заголовок'),
		field_textarea('text', 'Текст'),
		field_text('tag', 'Тег'),
		field_text('photo_path', 'Фото (путь assets)'),
		field_text('photo_alt', 'Фото alt'),
		field_repeater('cards', 'Карточки', [
			field_text('title', 'Заголовок'),
			field_textarea('text', 'Текст'),
			field_true_false('is_active', 'Активна по умолчанию'),
		]),
	]),
	layout('catalog_teaser', 'Каталог (тизер)', [
		field_textarea('title', 'Заголовок'),
		field_text('tag', 'Тег'),
		field_textarea('text', 'Текст'),
		field_link('btn_analyzers', 'Кнопка «Анализаторы»'),
		field_link('btn_panels', 'Кнопка «Панели»'),
		field_repeater('gallery', 'Галерея', [
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
			field_text('image_title', 'Title'),
		]),
	]),
	layout('pick', 'Иммуноблоттинг', [
		field_textarea('title', 'Заголовок'),
		field_textarea('text', 'Текст'),
		field_repeater('tags', 'Теги', [field_text('text', 'Текст')]),
		field_text('benefits_title', 'Заголовок преимуществ'),
		field_repeater('benefits_list', 'Список преимуществ', [field_text('text', 'Пункт')]),
		field_repeater('videos', 'Видео', [
			field_text('poster_path', 'Постер (путь assets)'),
			field_text('video_url', 'URL видео'),
			field_text('aria_label', 'Aria-label'),
			field_repeater('captions', 'Подписи', [field_textarea('text', 'Текст')]),
		]),
	]),
	layout('panels', 'Панели', [
		field_textarea('title', 'Заголовок'),
		field_textarea('lead', 'Лид'),
		field_text('tag', 'Тег'),
		field_repeater('items', 'Панели', [
			field_text('name', 'Название'),
			field_wysiwyg('description', 'Описание'),
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
			field_link('link', 'Ссылка'),
			field_true_false('is_open', 'Открыта по умолчанию'),
		]),
		field_link('footer_btn_desktop', 'Кнопка (desktop)'),
		field_link('footer_btn_mobile', 'Кнопка (mobile)'),
	]),
	layout('choose', 'Выбор панели', [
		field_text('tag', 'Тег'),
		field_textarea('title', 'Заголовок'),
		field_textarea('lead', 'Лид'),
		field_textarea('note', 'Примечание'),
		field_repeater('slides', 'Слайды', [
			field_text('title', 'Заголовок'),
			field_textarea('desc', 'Описание'),
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
		]),
		field_text('consult_btn_label', 'Кнопка консультации', ['default_value' => 'Получить консультацию']),
	]),
	layout('equipment', 'Оборудование', [
		field_textarea('title', 'Заголовок'),
		field_textarea('lead', 'Лид'),
		field_text('tag', 'Тег'),
		field_repeater('items', 'Карточки', [
			field_text('name', 'Название'),
			field_text('name_class', 'CSS-модификатор названия'),
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
			field_textarea('text', 'Текст'),
			field_link('link', 'Ссылка'),
			field_text('aria_label', 'Aria-label'),
		]),
		field_link('footer_btn', 'Кнопка внизу'),
	]),
	layout('process', 'Процесс', [
		field_text('tag', 'Тег'),
		field_textarea('title', 'Заголовок'),
		field_repeater('steps', 'Шаги', [
			field_text('step_label', 'Метка шага'),
			field_text('title', 'Заголовок'),
			field_textarea('desc', 'Описание'),
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
		]),
	]),
	layout('partners', 'Партнёры', [
		field_textarea('title', 'Заголовок'),
		field_text('tag', 'Тег'),
		field_repeater('paragraphs', 'Абзацы', [field_textarea('text', 'Текст')]),
		field_textarea('note', 'Примечание'),
		field_repeater('logos', 'Логотипы', [
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
			field_link('link', 'Ссылка'),
			field_text('aria_label', 'Aria-label'),
		]),
	]),
	layout('docs', 'Документы', [
		field_textarea('title', 'Заголовок'),
		field_textarea('text', 'Текст'),
		field_repeater('items', 'Документы', [
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
			field_text('caption', 'Подпись'),
		]),
	]),
	layout('request', 'Заявка', [
		field_textarea('title', 'Заголовок'),
		field_textarea('note', 'Примечание'),
		field_textarea('lead', 'Текст над формой'),
	]),
	layout('about', 'О компании', [
		field_text('tag', 'Тег'),
		field_textarea('title', 'Заголовок'),
		field_text('logo_path', 'Логотип (путь assets)'),
		field_text('logo_alt', 'Логотип alt'),
		field_repeater('photos', 'Фото', [
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
		]),
		field_text('concept_title', 'Заголовок концепции'),
		field_textarea('concept_lead', 'Лид концепции'),
		field_repeater('concept_list', 'Список концепции', [field_text('text', 'Пункт')]),
		field_textarea('concept_footer', 'Подвал концепции'),
		field_textarea('lead', 'Лид (боковая колонка)'),
		field_repeater('body_paragraphs', 'Абзацы', [field_textarea('text', 'Текст')]),
	]),
	layout('benefits', 'Преимущества PROTIA', [
		field_textarea('title', 'Заголовок'),
		field_text('tag', 'Тег'),
		field_repeater('cards', 'Карточки', [
			field_text('num', 'Номер'),
			field_text('title', 'Заголовок'),
			field_textarea('tooltip', 'Тултип'),
		]),
		field_text('brand_logo_path', 'Логотип бренда (путь assets)'),
		field_textarea('brand_text', 'Текст о бренде'),
	]),
	layout('news', 'Новости', [
		field_textarea('title', 'Заголовок'),
		field_textarea('text', 'Текст'),
		field_text('tag', 'Тег'),
		field_repeater('items', 'Материалы', [
			field_date('date', 'Дата'),
			field_text('title', 'Заголовок'),
			field_textarea('excerpt', 'Анонс'),
			field_text('image_path', 'Изображение (путь assets)'),
			field_text('image_alt', 'Alt'),
			field_link('link', 'Ссылка'),
		]),
		field_link('footer_btn', 'Кнопка «Смотреть все»'),
	]),
	layout('advantages', 'FAQ', [
		field_text('tag', 'Тег'),
		field_textarea('title', 'Заголовок'),
		field_repeater('items', 'Вопросы', [
			field_text('question', 'Вопрос'),
			field_textarea('answer', 'Ответ'),
			field_true_false('is_open', 'Открыт по умолчанию'),
		]),
	]),
	layout('contacts', 'Контакты', [
		field_text('tag', 'Тег'),
		field_textarea('title', 'Заголовок'),
		field_textarea('text', 'Текст'),
		field_text('photo_path', 'Фото (путь assets)'),
		field_text('photo_alt', 'Фото alt'),
	]),
];

$group = [
	'key' => 'group_alergobot_front_page',
	'title' => 'Главная страница',
	'fields' => [[
		'key' => 'field_page_content',
		'label' => 'Контент страницы',
		'name' => 'page_content',
		'type' => 'flexible_content',
		'button_label' => 'Добавить секцию',
		'layouts' => $layouts,
	]],
	'location' => [[[
		'param' => 'page_type',
		'operator' => '==',
		'value' => 'front_page',
	]]],
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	'modified' => time(),
];

file_put_contents(
	$out_dir . '/group_front_page.json',
	json_encode($group, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n"
);

echo "Generated group_front_page.json\n";
