# Project Setup

In order to run this project, make sure you have the following installed:

1. PHP 7.4.x
2. Composer
3. MySQL 5.x

### Local Installation Steps
1. Clone this repository
2. Install required dependencies with `composer install`
3. Install required node dependencies with `npm install`
4. Logon to your MySQL db using your client of choice
5. Import the db `.sql` file located in `database/raw/subscriber_manager.sql` of the project
6. Set you MailerLite API key in your .env file under the key `MAILER_LITE_API_KEY`
7. Run tests with `php artisan test`
7. Start application with `php artisan serve`