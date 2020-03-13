## About This Example

This example shows how to use jobs and events in Laravel.
This example is a simulation of a payment system using [Jobs](https://laravel.com/docs/6.x/queues), [Mails](https://laravel.com/docs/6.x/mail) and [Events](https://laravel.com/docs/6.x/events).

## Requirements

* [Laravel requirements](https://laravel.com/docs/6.x#server-requirements)
* A relational database such as [MySQL](https://www.mysql.com/) or [PostgreSQL](https://www.postgresql.org/)
* A Queue backend such as [Redis](https://redis.io/), [Beanstalk](https://beanstalkd.github.io/),[Amazon SQS](https://aws.amazon.com/sqs/) or even a relational database
* A Mail Server or [Mailtrap](https://mailtrap.io/) for testing.

## How to use it

### Endpoints

This project has 3 endpoints:

List clients:
```
GET /api/clients => [{
	"id": 1,
	"email": "admin@example.com",
	"join_date": "Y-m-d",
}]
```
List customer payments:
```
GET /api/payments?client={id} =>
[
	{
		"uuid": "4dc2aa90-744e-46da-aeea-952e211b719d",
		"payment_date": null,
		"expires_at": "2019-01-01"
		"status": "pending",
		"user_id": ?,
		"clp_usd": 810,
	},
	{
		"uuid": "4638609f-0b81-4d5d-a82a-456533e2d509",
		"payment_date": "2019-12-01",
		"expires_at": "2020-01-01"
		"status": "paid",
		"user_id": ?
		"clp_usd": 820,
	}
]
```
Create a payment (the request must contain the "client" attribute with the user id using x-www-form-urlencoded)
```
POST /api/payments => {
	"uuid": "1a59549c-0111-4411-86c3-8c3c0f9f0a99",
	"payment_date": null,
	"expires_at": "2020-02-26"
	"status": "pending",
	"user_id": ?,
	"clp_usd": null,
}
```
A Laravel Job is generated when you create a payment, which 1 minute later will add the value of the US dollar in CLP to the payment.
If no other payment has been made on the same day of the payment, then an API will be consulted to obtain this value, otherwise, the value is obtained from one of these payments.
When the previous process ends, the payment is updated with the value of the corresponding dollar and its status changes to "paid".
The last mission of this Job before finishing is to issue an event, which is heard by a listener who sends an email notifying that the payment was successful.

As you can see, updating the payment and use a service is what would come to be the simulation of a real payment process (a little concise but enough to exemplify Laravel's events, emails and jobs)

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
14. Now the project is running in 'http://localhost:8000'

## License

The Laravel framework (and this example) is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
