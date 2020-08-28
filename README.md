# Установка

Склонировать текущий репозиторий. Не забыть добавить `symfony.localhost` в файл `/etc/hosts`.

Далее запустить:

```bash
$ docker-compose up
```

Перейти в контейнер:

```bash
$ docker-compose exec php sh
```

Установить зависимости:

```bash
$ composer install
```

Накатить миграции:

```bash
$ php bin/console doctrine:mirations:migrate
```

Накатить фикстуры:

```bash
$ php bin/console doctrine:fixtures:load
```

Теперь все готово! Перейти по адресу [http://symfony.localhost](http://symfony.localhost)