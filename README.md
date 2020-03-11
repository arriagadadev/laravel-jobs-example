## About This Example

This example shows how to use jobs and events in laravel.
This example is a simulation of a payment system using [Jobs](https://laravel.com/docs/6.x/queues), [Mails](https://laravel.com/docs/6.x/mail) and [Events](https://laravel.com/docs/6.x/events).

## Requirements

* [Laravel requirements](https://laravel.com/docs/6.x#server-requirements)
* A relational database such as [MySQL](https://www.mysql.com/) or [PostgreSQL](https://www.postgresql.org/)
* A Queue backend such as [Redis](https://redis.io/), [Beanstalk](https://beanstalkd.github.io/),[Amazon SQS](https://aws.amazon.com/sqs/) or even a relational database
* A Mail Server or [Mailtrap](https://mailtrap.io/) for testing.

## Installation

1. Install PHP (>=7.2.0)
2. Install Composer
3. Clone this repository (or just download the .zip file and unzip it)
4. Open the terminal and go to the project folder
5. Run `composer install` to install project dependencies
6. Install and/or create the relational database that you like to use in the project
7. Install a database such as Redis to use the Laravel queue system (the database can also be the same [database that you created in the previous step](https://laravel.com/docs/6.x/queues#driver-prerequisites))
8. Have a mail server to send emails from Laravel (you can also use [Mailtrap](https://mailtrap.io/))
9. Copy the file '.env.example' and paste it in the same folder with the name '.env'
10. Add the connection information to your database, your mail system and your queue system in the file '.env'
11. Run `php artisan key:generate`
12. Run `php artisan migrate --seed` to create the necessary tables
13. Run `php artisan serve`
14. Now the project is running in 'http://localhost: 8000'

## License

The Laravel framework (and this example) is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
