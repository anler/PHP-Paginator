<?php

namespace Paginator\Tests;

use Paginator\Paginator;
use Paginator\PaginatedArray;


class SimpleLayoutTest extends \PHPUnit_Framework_TestCase
{
	protected function setup()
	{
		$this->data = array('Andrew', 'Bernard', 'Castello',
							'Dennis', 'Ernie', 'Frank', 'Greg',
							'Henry', 'Isac', 'Jax', 'Kester', 'Leonard',
							'Matthew', 'Nigel', 'Oscar', 'Joseph', 'Charles',
							'Albert', 'Kenneth', 'Alex', 'Michael', 'Steve',
							'Bill', 'August', 'Abdel', 'Marc', 'Rosen',
							'Robert', 'Hugo', 'Paul', 'Adrian', 'Nicky');
		$this->paginator = new Paginator(new PaginatedArray($this->data));
	}

	public function testRenderNavigationFirstPage()
	{
		$page = $this->paginator->getPage(1);
		$result = $page->renderNavigation();
		$expected = '<span class="inactive">&lt; Previous</span> | <a href="?page=2">Next &gt;</a>';

		$this->assertEquals($expected, $result);
	}

	public function testRenderNavigationMiddlePage()
	{
		$page = $this->paginator->getPage(2);
		$result = $page->renderNavigation();
		$expected = '<a href="?page=1">&lt; Previous</a> | <a href="?page=3">Next &gt;</a>';

		$this->assertEquals($expected, $result);
	}

	public function testRenderNavigationLastPage()
	{
		$page = $this->paginator->getPage($this->paginator->getTotalPages());
		$result = $page->renderNavigation();
		$expected = '<a href="?page='. ($this->paginator->getTotalPages() - 1) .'">&lt; Previous</a> | <span class="inactive">Next &gt;</span>';

		$this->assertEquals($expected, $result);
	}

	public function testRenderNavigationAnIterateItemsFirstPage()
	{
		$page = $this->paginator->getPage(1);
		$result = $page->renderNavigation();
		$expected = '<span class="inactive">&lt; Previous</span> | <a href="?page=2">Next &gt;</a>';

		$this->assertEquals($expected, $result);

		foreach ($page as $item) {
			// code...	
		}

		$result = $page->renderNavigation();

		$this->assertEquals($expected, $result);
	}

	public function testRenderNavigationAnIterateItemsMiddlePage()
	{
		$page = $this->paginator->getPage(2);
		$result = $page->renderNavigation();
		$expected = '<a href="?page=1">&lt; Previous</a> | <a href="?page=3">Next &gt;</a>';

		$this->assertEquals($expected, $result);

		foreach ($page as $item) {
			// code...	
		}

		$result = $page->renderNavigation();

		$this->assertEquals($expected, $result);
	}
}
