# Base-web

This is my basic server configuration for developing simple websites or webapps.

### Dependencies

This project is based on [Slim](https://www.slimframework.com) framework with 
[Twig](https://twig.symfony.com/) as view template engine.
It uses [Slim-PDO](https://github.com/FaaPz/Slim-PDO) for database interaction and
loads environment variables from a `.env` file using [phpdotenv](https://github.com/vlucas/phpdotenv).

### Development

From the project root run 
```
composer start
```
and the application will be available at `http://localhost:8080`
> Ensure `logs/` is web writeable.


### Tests
I enhanced the `BaseTestCase` with few methods, mainly to add DB connection while testing.

Test environment variables are defined inside `phpunit.xml`.

To run the test suite run
```
composer test
```
from the project root
