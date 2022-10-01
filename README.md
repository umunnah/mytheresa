# MyTheresa
A RestFul API that adds discount to Products.


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

What things you need to install the software and how to install them.

```
PHP 8
Code Editor (This app was built on VSCode)
Git
```


### Installing

To get this project on your local machine, you first need to clone it using the `git clone` command.

```
git clone https://github.com/umunnah/mytheresa.git
```

Running this on your terminal will ensure you receive the latest version with all it's changes.

Once you've cloned it, install all dependencies using:

```
composer install
```

This should retrieve all the necessary dependencies named in the [composer.json](https://github.com/umunnah/mytheresa/blob/main/composer.json) file.

### How To Use:

Once dependencies are installed, be sure to update ```.env``` file with the necessary environment variable:

```
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=14&charset=utf8"
```

When everything is in place, to setup database and add migration:

```
php bin/console app:test:database
```

## Running tests 🧪

Tests can be run by using the command:

```
php bin/phpunit
```
## Running Application
Run application using the command:
```
symfony server:start 
```

Note  the url to list products is http://localhost:8000/api/v1/products.


[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)