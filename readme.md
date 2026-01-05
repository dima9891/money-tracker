# Money Tracker

Очередной трекер расходов для того чтобы научиться работать с Laravel.

[Документация по API](docs/api.md)

Поднять dev сборку для локальной разработки

```
docker compose -f compose.dev.yaml up -d
```
Установить зависимости

```
docker compose -f compose.dev.yaml exec workspace bash
composer install
npm install
npm run dev
```

Запустить миграции

```
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```
