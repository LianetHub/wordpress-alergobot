# Тема WordPress: alergobot-theme

Исходники темы в репозитории. На OSPanel скопируйте папку `alergobot-theme` в:

```
C:\OSPanel\domains\<ваш-домен>\wp-content\themes\alergobot-theme\
```

Либо укажите этот путь в `.env` как `THEME_PATH`.

## Установка WordPress

1. Создайте домен в OSPanel (например `wordpress-alergobot.local`).
2. Установите WordPress.
3. Активируйте тему **Alergobot**.
4. Установите плагины: ACF Pro, Contact Form 7, Cyr-To-Lat, SVG Support, Classic Editor, SEO-плагин, SMTP, один кэш-плагин; для разработки — Password Protected, Query Monitor.
5. Импортируйте группы полей из `acf-json/` (ACF → Tools → Sync).

## Сборка ассетов

Из корня репозитория alergobot:

```bash
cp .env.example .env
# отредактируйте THEME_PATH и WP_PROXY_URL

npm run build:theme
npm run watch:theme
```

Ассеты попадают в `alergobot-theme/assets/`.
