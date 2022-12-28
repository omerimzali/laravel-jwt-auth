# Laravel Auth JWT Example
## Installation
- Clone the repository with git clone 'repositoryname'
- Run `composer install` command
- Create an .env file according to .env.example. You should have fill database connection credentials.
- Run `php artisan jwt:secret` and change JWT_SECRET= in .env file
- Run `php artisan migrate`
- Run `php artisan serve`


After installation steps you can use the app with `php artisan serve` command