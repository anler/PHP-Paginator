<?php

namespace Paginator;

use Paginator\Exception;

/**
 * Pagination class
 **/
class Paginator implements PaginatorInterface
{
	/**
	 * Items to paginate. Can be any object implementing the
  	 * SPL Countable interface
	 *
	 * @var mixed
	 **/
	protected $items;
	/**
	 * Max number of records per page
	 *
	 * @var integer
	 **/
	protected $pageSize;

	/**
	 * Where or not to allow the first page be empty
	 *
	 * @var boolean
	 **/
	protected $allowEmptyFirstPage;
	
	function __construct(PaginatedInterface $items, $pageSize = 10, $allowEmptyFirstPage = false)
	{
		$this->items = $items;
		$this->setPageSize($pageSize);
		$this->allowEmptyFirstPage = $allowEmptyFirstPage;
	}

	public function setPageSize($pageSize)
	{
		if (is_int($pageSize) && $pageSize > 0)
		{
			$this->pageSize = $pageSize;
		}
		else
		{
			throw new Exception\InvalidPageSize;
		}
	}

	public function getPageSize()
	{
		return $this->pageSize;
	}

	public function getPage($pageNumber)
	{
		return new Page($this, $pageNumber);
	}

	public function getAllowEmptyFirstPage()
	{
		return $this->allowEmptyFirstPage;
	}

	public function getTotalPages()
	{
		return (int) ceil(count($this->items) / $this->pageSize);
	}

	public function getPageRange()
	{
		return range(0, count($this->items) - 1);
	}

	public function getCountItems()
	{
		return count($this->items);
	}

	public function getItems()
	{
		return $this->items;
	}
}
