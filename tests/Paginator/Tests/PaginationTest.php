<?php

namespace Paginator\Tests;

use Paginator\Paginator;
use Paginator\PageInterface;
use Paginator\PaginatorInterface;
use Paginator\PaginatedArray;


class PaginatorTest extends \PHPUnit_Framework_TestCase
{
	protected function setUp()
	{
		$this->data = new PaginatedArray(array('Andrew', 'Bernard', 'Castello',
							'Dennis', 'Ernie', 'Frank', 'Greg',
							'Henry', 'Isac', 'Jax', 'Kester', 'Leonard',
							'Matthew', 'Nigel', 'Oscar'));
	}

	/**
	 * @expectedException Paginator\Exception\InvalidPageSize
	 * @expectedExceptionMessage The number of rows to display must be an integer greater than 0
	 **/
	public function testInvalidPageSizeNegativeInteger()
	{
		$pageSize = -10;
		$paginator = new Paginator($this->data, $pageSize);
	}

	/**
	 * @expectedException Paginator\Exception\InvalidPageSize
	 * @expectedExceptionMessage The number of rows to display must be an integer greater than 0
	 **/
	public function testInvalidPageSizeNotAnInteger()
	{
		$pageSize = 'pagesize';
		$paginator = new Paginator($this->data, $pageSize);
	}

	/**
	 * @expectedException Paginator\Exception\InvalidPageSize
	 * @expectedExceptionMessage The number of rows to display must be an integer greater than 0
	 **/
	public function testSetInvalidNoIntegerPageSize()
	{
		$paginator = new Paginator($this->data);
		$paginator->setPageSize('invalid');
	}

	/**
	 * @expectedException Paginator\Exception\InvalidPageSize
	 * @expectedExceptionMessage The number of rows to display must be an integer greater than 0
	 **/
	public function testSetInvalidIntegerPageSize()
	{
		$paginator = new Paginator($this->data);
		$paginator->setPageSize(0);
	}

	public function testGetPageSize()
	{
		$paginator = new Paginator($this->data);
		$this->assertEquals(10, $paginator->getPageSize());

		$paginator->setPageSize(20);
		$this->assertEquals(20, $paginator->getPageSize());
	}

	public function testGetCountItems()
	{
		$paginator = new Paginator($this->data);
		$this->assertEquals(count($this->data), $paginator->getCountItems());
	}

	public function testGetTotalPages()
	{
		$paginator = new Paginator($this->data);
		$total = (int) ceil(count($this->data) / 10);
		$this->assertEquals($total, $paginator->getTotalPages());
	}

	public function testGetPageRange()
	{
		$paginator = new Paginator($this->data);
		$expected = range(0, count($this->data) - 1);
		$this->assertEquals($expected, $paginator->getPageRange());
	}

	/**
	 * @expectedException Paginator\Exception\InvalidPage
	 * @expectedExceptionMessage The requested page is out of range
	 **/
	public function testGetPageOutOfRange()
	{
		$paginator = new Paginator($this->data);
		$page = $paginator->getPage(40);
	}

	/**
	 * @expectedException Paginator\Exception\EmptyPage
	 * @expectedExceptionMessage The requested page is empty
	 **/
	public function testGetPageBlank()
	{
		$paginator = new Paginator(new PaginatedArray(array()));
		$this->assertEquals(0, $paginator->getTotalPages());
		$page = $paginator->getPage(1);
	}

	public function testGetPage()
	{
		$paginator = new Paginator($this->data);
		$page = $paginator->getPage(1);
		$this->assertTrue($page instanceof PageInterface);
	}
}
