# PHP-Paginator, an extensive paginator library for PHP

PHP-Paginator is a simple library inspired by the Django's pagination and based on
[Symfony2][1] components.

## Installation

First clone the repository with the dependencies:

```sh
git clone git://github.com/ikame/PHP-Paginator.git
cd PHP-Paginator
git submodule init
git submodule update
```

## Usage

```php
<?php
require_once 'path/to/lib/PHP-Paginator/autoload.php';

use Paginator;

$paginatedItems = new Paginator\PaginatedArray(array(1, 2, 3, 4, 5));
$paginator = new Paginator\Paginator($paginatedItems);

$page = $paginator->getPage(1);

foreach($page as $item) {
	printf('Item: %s', $item);
}
```

PHP-Paginator works with PHP 5.3.2 or later.


## License

PHP-Paginator is licensed under the MIT license.
