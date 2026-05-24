# Запуск миграций

```bash
    php artisan migrate
    php artisan migrate --seed
```

# Создание миграции

```bash
    php artisan make:migration create_resumes_table
```

php artisan migrate:rollback — откатить последнюю миграцию (выполнит метод down())

php artisan migrate:refresh — откатить и заново применить все миграции

php artisan migrate:fresh — удалить все таблицы и заново выполнить миграции

#

## Создать файл миграции для сессий:

```bash
php artisan session:table
```

## Чтобы создать таблицу jobs:

```bash
php artisan queue:table
```

## Создаем миграцию для кэша:

```bash
php artisan cache:table
```
