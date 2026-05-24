# Команды для composer`а

## Использовать для обновления автозагрузки классов

```bash
    composer dump-autoload
```

## Использовать для проверки кода линтером

```bash
    vendor/bin/phpstan analyse
```
```bash
    vendor/bin/phpstan analyse --memory-limit=1G
```

## Использовать для создания errors-pages в директории *resources/views/errors/*

```bash
php artisan vendor:publish --tag=laravel-errors
```

