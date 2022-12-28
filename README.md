# Laravel Auth JWT Example
## Installation
- Clone the repository with git clone 'repositoryname'
- Run `composer install` command
- Create an .env file according to .env.example. You should have fill database connection credentials.
- Run `php artisan jwt:secret` and change JWT_SECRET= in .env file
- Run `php artisan migrate` and you can run tests via `php artisan test`
- Run `php artisan serve`


After installation steps you can use the app with `php artisan serve` command

## Verification
 Once a user created, It has not email validation so you should run `php artisan update:email-verify email@email.com` command


## Endpoints

### /api/login
- {base_url}/api/login
```jsonBody:
{
"email":"omer@gmail.com",
"password":"password"
}
```


### /api/register
- {base_url}/api/register
```jsonBody:
{
"name":"name"
"email":"omer@,
"password":"password"
}
```


### api/me/
- {base_url}/api/
```jsonBody:
{
"name":"updated name"
}
```


### api/me/email
- {base_url}/api/me/email
- 
```jsonBody:
{
"name":"name"
"email":"omer@gmail.org",
"password":"password"
}
```
