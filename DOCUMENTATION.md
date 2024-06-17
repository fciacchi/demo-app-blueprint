# DOCUMENTATION

The following project is a demo application that has:
* User's management
* Donation page
* Admin backoffice

The idea is to build the following application using 
[LeafPHP Framework](https://leafphp.dev/). This Framework has been chosen 
over Laravel, because I already have working knowledge with it and due to 
the tight timeline of development, it's a better choice. However 
**LeafPHP** is very similar to Laravel, having both Inertia 
and Vite for working with JSX pages and Eloquent ORM for the database.

A Live version of the App is accessible at: https://demo.asplanned.app
## What is being left out

For the purpose of the test, it is being left out:

* User authentication
* Mailing system
* Content pages (terms, privacy, etc)
* Design is based upon template [XXXX]()

## Database Structure

![DB Structure](assets/images/ACME-DB-Structure.png)

Diagram built with: [DBDiagram.io](https://dbdiagram.io/)


### Implementation

Database entities have been implemented using the deafult LeafPHP 
functionalities. For each database table it has been created:

* `app/database/schema/[table].json`
* `app/database/migrations/[date_id_table].php`
* `app/models/[table].php`

That ensure consistency across the different tables, and the validity
of the foreign-keys and default timestamp values.

In addion, the framework allows to create 'Seeders' that pre-popoluate
the databse with test data. A seeder is created using two classes:

* `app/database/factories/[table]Factory.php`
* `app/database/seeds/[table]Seeder.php`

The first one defining the seeds data using the Faker library (and some
random IDs), and the second one deciding how many fake entries for each
table to create.

## Linters and Validations

The systems uses several Linters to enforce Coding standards for both
PHP and JS code. Specifically:

* PHPCS for Code Validation
* PHPStan for Code Consistency
* RectorPHP for Best Practices
* ESLint for JSX Pages

## WIP

- API Definition (group /api)
- Split of Controller and Model (for DB queries)
- Add Postman collection for API test (locally) 
- Main Template for JSX
- Add PHPUnit tests

## TODO

* Add [Docker Support](https://leafphp.dev/docs/introduction/docker.html)
* Add a payment system (can be used [Cashier](https://laravel.com/docs/11.x/billing) from Laravel)
* Add JEST Combined Test Coverage
* Additional security with JWT Tokens and Signed payload
* Add to Github workflow (Linters + Tests + Postman)
