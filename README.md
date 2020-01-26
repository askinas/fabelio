## Installation

Run git Clone or Download to local host:

``` git clone https://github.com/askinas/fabelio.git . ```

Once you've cloned the project to your host we can now start the app. Navigate to the directory in which you cloned the project. Run the following commands from this directory to install project code

``` composer install ```


## Run App

Once, the app installed run the app, alternatively you can use artisan serve to test it:

``` php artisan serve ```

The app will run at port :8000, so to ccess it open ```http://127.0.0.1:8000``` in your browser.

## App Configuretion

Once app installed and running, you can configure the app:

- set database configuration to your mysql DB, Open .env file

```
DB_HOST=<db_host>
DB_PORT=<db_port>
DB_DATABASE=<db_name>
DB_USERNAME=<db_user>
DB_PASSWORD=<db_pass>
```

- run database migration, run this code in console

```
php artisan migrate
```
