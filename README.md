# RegisterApp

## Requirements

PHP 7.2 or greater


## Setup

Run the following command

```
git clone git@github.com:am2umbrele/RegisterApp.git
```
Run
```
composer install
```
Add your database info to **`app\Config\Database.php`**
```
'hostname' => '',
'username' => '',
'password' => '',
'database' => '',
```
Run migrations
```
php spark migrate
```
Add your recaptcha keys to **`app\Config\Recaptcha.php`**
```
public $siteKey = '';
public $secretKey = '';
```
## Locale error
If the error `CLASS ‘LOCALE’ NOT FOUND` is thrown, you must enable **`php_intl.dll`** in `php.ini`
## Run tests
```
./vendor/bin/phpunit tests
```
