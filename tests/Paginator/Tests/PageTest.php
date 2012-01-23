<?php

namespace Paginator\Tests;

use Paginator\Paginator;
use Paginator\PageInterface;
use Paginator\PaginatorInterface;
use Paginator\PaginatedInterface;
use Paginator\PaginatedArray;
use Paginator\Layout\PageLayoutInterface;


class PageTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
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

	public function testGetNumber()
	{
		$page = $this->paginator->getPage(2);
		$this->assertEquals(2, $page->getNumber());
	}

	public function testHasNext()
	{
		$page = $this->paginator->getPage(1);
		$this->assertTrue($page->hasNext());

		$page = $this->paginator->getPage(2);
		$this->assertTrue($page->hasNext());

		$page = $this->paginator->getPage($this->paginator->getTotalPages());
		$this->assertFalse($page->hasNext());
	}

	public function testHasPrevious()
	{
		$page = $this->paginator->getPage(1);
		$this->assertFalse($page->hasPrevious());

		$page = $this->paginator->getPage(2);
		$this->assertTrue($page->hasPrevious());

		$page = $this->paginator->getPage($this->paginator->getTotalPages());
		$this->assertTrue($page->hasPrevious());
	}

	public function testHasOtherPages()
	{
		$page = $this->paginator->getPage(1);
		$this->assertTrue($page->hasOtherPages());

		$paginator = new Paginator(new PaginatedArray(array(1)));
		$page = $paginator->getPage(1);
		$this->assertFalse($page->hasOtherPages());
	}

	public function testGetNexPageNumber()
	{
		$page = $this->paginator->getPage(1);
		$this->assertEquals(2, $page->getNextPageNumber());

		$page = $this->paginator->getPage($this->paginator->getTotalPages());
		$this->assertEquals(null, $page->getNextPageNumber());
	}

	public function testGetPreviousPageNumber()
	{
		$page = $this->paginator->getPage(2);
		$this->assertEquals(1, $page->getPreviousPageNumber());

		$page = $this->paginator->getPage(1);
		$this->assertEquals(null, $page->getPreviousPageNumber());
	}

	public function testGetStartIndex()
	{
		$page = $this->paginator->getPage(1);
		$this->assertEquals(1, $page->getStartIndex());
		$this->assertEquals(10, $page->getEndIndex());

		$page = $this->paginator->getPage(2);
		$this->assertEquals(11, $page->getStartIndex());
		$this->assertEquals(20, $page->getEndIndex());

		$page = $this->paginator->getPage($this->paginator->getTotalPages());
		$this->assertEquals($this->paginator->getCountItems(), $page->getEndIndex());
	}

	public function testGetLayout()
	{
		$page = $this->paginator->getPage(1);
		$layout = $page->getLayout();
		$this->assertTrue($layout instanceof PageLayoutInterface);

		$expected = '<span class="inactive">&lt; Previous</span> | <a href="?p=2">Next &gt;</a>';
		$result = $page->renderNavigation(array(
			'url' => '',
			'pageParam' => 'p',
			'querystring' => ''
		));
		$this->assertEquals($expected, $result);
	}

	public function testGetIterator()
	{
		$page = $this->paginator->getPage(1);
		$items = array();
		$expected = array_slice($this->data, 0, $this->paginator->getPageSize());

		foreach ($page as $item) {
			$items[] = $item;
		}

		$this->assertEquals($expected, $items);
	}
}
