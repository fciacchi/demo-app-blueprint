# DOCUMENTATION

The following project is a demo application that has:
* User's management
* Donation page
* Admin backoffice

The idea is to build the following application using [Leaf PHP Framework](https://leafphp.dev/).
This Framework has been chosen over Laravel, because I already have working 
knowledge with it and due to the tight timeline of development, it's a better 
choice. However **Leaf PHP** is very similar to Laravel, having both Inertia 
and Vite for working with JSX pages and Eloquent ORM for the database.

A Live version of the App is accessible at: https://demo.asplanned.app
## What is being left out

For the purpose of the test, it is being left out:

* User authentication
* Mailing system
* Content pages (terms, privacy, etc)
* Design is also based upon template [XXXX]()

## Database Structure

![DB Structure](assets/images/ACME-DB-Structure.png)

Diagram built with: [DBDiagram.io](https://dbdiagram.io/)

## WIP

- Database entities and migrations
- Database seeding
- API Definition (group /api)
- Split of Controller and Model (for DB queries)
- Main Template for JSX
- Add phpspec, rectorphp and phpstan
- Add PHPUnit tests
- Add Github Workflow
- Add Postman collection for API test (locally) 

## TODO

* Add [Docker Support](https://leafphp.dev/docs/introduction/docker.html)
* Add a payment system (can be used [Cashier](https://laravel.com/docs/11.x/billing) from Laravel)
* Add JEST Combined Test Coverage
* Additional security with JWT Tokens and Signed payload
* Add Postman test to Github workflow
