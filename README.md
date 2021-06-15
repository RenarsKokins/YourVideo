![YourVideo logo](https://github.com/RenarsKokins/YourVideo/blob/master/public/img/logo-orange.webp?raw=true)

## About YourVideo

YourVideo is a free video sharing platform made with Laravel framework. It is possible to store and watch videos which people have uploaded on this site. It is made using [Laravel](https://laravel.com/) framework and [MySQL](https://www.mysql.com/) database for information storage.

## Installation guide

### Pre-requisites
* Have [Composer](https://getcomposer.org/download/) installed,
* Have [Git](https://git-scm.com/downloads) installed,
* Have a virtual server installed ([XAMPP](https://www.apachefriends.org/download.html) for example).
* Have [FFMPEG](https://www.ffmpeg.org/) installed on your machine and make sure you have added it to your enviroment PATH!

### Installation
1. Open your console and go to web server root folder (cd "YourWebRootPath"),
2. Execute command in console: `git clone https://github.com/RenarsKokins/YourVideo.git YourVideo`,
3. Open that folder in console: `cd YourVideo`,
4. Run Composer to install the dependencies: `composer install`,
5. Run 2 commands of NPM to install the dependencies: `npm install` and after that `npm run dev`,
6. Rename `.env.example` to `.env`, which is loacted in the project folder,
6. Execute this command: `php artisan key:generate`.

You have installed the project! Now, you just need to create a new database, create tables using migrations and, optionally, seed them.

### Database setup
1. Make sure your MySQL and Apache service is running (in WAMP, LAMP or XAMPP),
2. Open this page in your desired browser `localhost/phpmyadmin`,
3. Now, click on "New" button on the left list,
4. Enter database name as `yourvideo` and click "Create", it should create a database with no errors,
5. Now, execute this command in your console `php artisan migrate`,
6. After that, execute this command in your console `php artisan db:seed`.

### Additional requirements
1. If you want to upload videos, you have to run `php artisan queue:work`. It is a process which will render videos continuously(if you dont close your console).

### Setup is done!
If you don't encounter any errors, you are done! To log in with a test user (don't use this in production!), use this email `admin@yourvideo.test` and password `secret`.