<img src="./cover.png" />

# 🤖 Suber

## Crawler download subtitles

This system is an intelligent crawler! Allows you to navigate the subtitle sites. For example, we started with "worldsubtitle" site
We use imdb for film or serial name and thumbnail , year of production and also an interesting folder system has been implemented which provides you with the ability to easily search and find subtitles.

### installation

This system is based on Laravel! You need to install php8 and composer on your system ,The system is based on the sqlite database (jobs driver is also a database)

first Clone repo on your system and go to the root folder 
Open the command line and :


```php
$ composer install
$ cp .env.sample .env 
$ php artisan key:generate 
$ touch databases/database.sqlite
$ php artisan migrate:refresh --seed
$ php artisan schedule:work 
$ php artisan queue:work // run this command on the new tab
```

after execution, all subtitles are placed in the following path

```php
./storage/app/public/uploads
```





