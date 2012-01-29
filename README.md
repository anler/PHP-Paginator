# PHP-Paginator, an extensible paginator library for PHP

PHP-Paginator is a simple library. It's inspired by the Django's pagination and this [tutorial][2], following the best practices from the [Symfony2][1] community.

## Installation

First clone the repository with the dependencies:

```
git clone git://github.com/ikame/PHP-Paginator.git
cd PHP-Paginator
git submodule init
git submodule update
```

## Documentation

The goal of PHP-Paginator is to be as long as possible independent from the database
engine and ORM used by the end user, in fact, you can use it even for paginate data
fetched from other sources rather than a database.
In order to have this flexibility PHP-Paginator can't be used directly in your project
but with a minimal setup you will be ready to go.

The library is composed by four types of objects:

1. A Paginator object: The object that manages the pagination
2. A Page object: The representation as a page of data
3. A Paginated object: This object is the cornerstone of the library, and the one
you will to use must. It is passed to the paginator and is responsible
of fetching the data from the source you want
4. A Layout object: This object is responsible of managing the representation (as
html or any format you want) of the navigation links of the paginator.

PHP-Paginator has a Paginator, Page, SimpleLayout and PaginatedArray out of the box:

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

PaginatedArray is a class implementing the interface Paginator\PaginatedInterface. In order to create your own Paginated components, you need to implement the two methods of this interface which are:

	count()
	getSlice($length, $offset)

count() should return an integer representing the length of the dataset your working with
getSlice($length, $offset) receives a length and an offset and should return a list/array of elements of your dataset.

Here's an example. In my custom project I have created a ProductsPaginatedQuery class that connects to my database:

```php
<?php

require_once 'path/to/lib/PHP-Paginator/autoload.php';

use Paginator;


class ProductsPaginatedQuery implements Paginator\PaginatedInterface
{
	public function count()
	{
		return MyDBHandler::query("select count(*) from products");
	}

	public function get_slice($length, $offset)
	{
		return MyDBHandler::query("select * from products limit $length offset $offset");
	}
}

$paginatedItems = new ProductsPaginatedQuery();
$paginator = new Paginator\Paginator($paginatedItems);

$page = $paginator->getPage(1);

foreach($page as $item) {
	printf('Item: %s', $item);
}

```

As you see, you can make your paginated class as complicated and custom as you want, PHP-Paginator doesn't get in your way.

## Compatibility

PHP-Paginator works with PHP 5.3.2 or later.


## License

PHP-Paginator is licensed under the MIT license.

[1]: http://symfony.com
[2]: http://www.sitepoint.com/perfect-php-pagination/