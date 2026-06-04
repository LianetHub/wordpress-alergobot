# Интеграция alergobot → WordPress

## Структура

| Компонент | Путь |
|-----------|------|
| Вёрстка (Gulp) | репозиторий `alergobot`, папка `src/` |
| Сборка вёрстки | `dist/` (`npm run dev` / `npm run build`) |
| Тема WP | `wp-theme/alergobot-theme/` → OSPanel `wp-content/themes/alergobot-theme/` |
| Ассеты темы | `alergobot-theme/assets/` (`npm run build:theme`) |

## Установка

1. Скопировать тему на сервер разработки.
2. `cp .env.example .env` — указать `THEME_PATH` и `WP_PROXY_URL`.
3. `npm install && npm run build:theme:full` (вёрстка → экспорт markup → ассеты в тему).
   Либо по шагам: `npm run build`, `npm run export:markup`, `npm run build:theme`.
4. Активировать тему **Alergobot** в админке.
5. ACF → Sync — импортировать группы из `acf-json/`.
6. Создать страницы и назначить шаблоны (см. ниже).
7. Настройки → Чтение → статическая главная.

## Страницы WordPress

| Страница | Slug (рекомендуется) | Шаблон |
|----------|----------------------|--------|
| Главная | — | (статическая главная) |
| Каталог | `katalog` | Каталог |
| Контакты | `kontakty` | Контакты |
| Анализаторы | `analizatory` | Анализаторы |
| Политика | `politika-konfidentsialnosti` | Политика конфиденциальности |

## CPT и URL

- **product** — `/product/nazvanie/`; категории: `/catalog/equipment/`, `analyzers`, `reagents`, `panels`
- **blogs** — архив `/blog/`; запись `/blog/nazvanie/`

Термы каталога создаются при активации темы. При смене slug выполните «Настройки → Постоянные ссылки → Сохранить».

## ACF

- **Настройки сайта** — логотипы, телефоны, меню `glavnoe_menyu`, шорткоды CF7.
- **Главная** — Flexible Content `page_content` (если пусто — выводится полная вёрстка из `inc/markup/home/`).
- **Продукт** — `related_products`, флаг `use_custom_layout`.

## Contact Form 7

Создайте формы и вставьте шорткоды в ACF Options:

- `cf7_konsultaciya` — попап консультации
- `cf7_zakaz` — заказ
- `cf7_prezentaciya` — презентация

Подключите reCAPTCHA v3 в CF7 → Integration.

## Команды сборки

```bash
npm run dev          # вёрстка, dist + BrowserSync :3000
npm run build        # production dist
npm run build:theme  # assets в тему
npm run watch:theme  # watch + proxy WP
```

## Чеклист сдачи

- [ ] Адаптив 320, 375, 414, 768, 1024, 1366, 1920
- [ ] Все формы отправляются, письма доходят
- [ ] SEO: title/description, sitemap
- [ ] PageSpeed: mobile ≥ 75, desktop ≥ 94
- [ ] Метрики и Вебвизор
- [ ] Удалены dev-плагины, снят Password Protected после согласования
