# BO Bank — Test Task

Мини-API для управления пользователями и денежными операциями (депозит, перевод между счетами).  
Стек: **Laravel 10**, **PostgreSQL**, **Docker (php-fpm + nginx)**.

---

## 1. Запуск в Docker

```bash
git clone https://github.com/<your-username>/<repo>.git
cd <repo>

# Создать папку для бд
mkdir db_data

# Собрать и поднять контейнеры
docker compose up -d --build

# Установка зависимостей
composer install
cp .env.example .env
php artisan key:generate

## 2. Миграции,сиды,тесты
# Накатить схему + наполнить данными
php artisan migrate --seed

# Накатить миграции (+ сиды)
php artisan migrate:fresh --seed

#Запустить тесты
php artisan test