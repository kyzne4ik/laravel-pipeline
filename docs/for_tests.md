
## Для запуска тестов через XDebug

```bash
    XDEBUG_MODE=coverage /usr/bin/php8.4 artisan test --coverage --min=60.3
```

## На будущее я сделал так, чтобы не нужно было делать экспорт-переменной (`export XDEBUG_MODE=coverage`)

### Отредачил вот здесь: 
```bash
    sudo vim /etc/php/8.4/cli/conf.d/20-xdebug.ini
```

#### вписал туда:
```
...
xdebug.mode=develop,coverage
```

