Инструкция по запуску
========================

1. `git clone https://github.com/VitEzerskyy/books.git`

    или

    `download zip file`
2. Перейти в директорию проекта и:

    `composer install`
    
    в процессе ввести свои параметры для подключения к БД
    
3. Создать БД:

    `mysql -u USER -pPASSWORD -e "create database booksdb"`
    
    
4. В консоли symfony:
    
   `php bin/console doctrine:schema:update --force`
   
   `php bin/console assets:install `
   
5. Залить дамп (находится в корне проекта) или создать несколько авторов самостоятельно:
    
    `mysql -u USER -pPASSWORD booksdb < /path/to/book.sql`
    
6. Запустить проект, например:

    `php bin/console server:run`