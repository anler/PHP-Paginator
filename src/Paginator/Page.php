<?php

namespace Paginator;


/**
 * Page class
 **/
class Page implements PageInterface
{
	/**
	 * Paginator for this page
	 *
	 * @var object
	 **/
	protected $paginator;

	/**
	 * Page number
	 *
	 * @var integer
	 **/
	protected $page;

	/**
	 * PageLayout used to render the navigation links
	 *
	 * @var object
	 **/
	protected $layout;

	public function __construct($paginator, $page = 1)
	{
		if ($paginator instanceof Paginator)
		{
			$this->paginator = $paginator;
		}
		else
		{
			throw new Exception\InvalidPage("The paginator must be an instance of a class implementing PaginatorInterface");
		}

		if (is_int($page) && $page > 0)
		{
			if ($page > $paginator->getTotalPages())
			{
				if ($page == 1)
				{
					if (!$paginator->getAllowEmptyFirstPage())
					{
						throw new Exception\EmptyPage;
					}
				}
				else
				{
					throw new Exception\InvalidPage;
				}
			}

			$this->page = $page;
		}
		else
		{
			throw new Exception\InvalidPage;
		}

		$this->layout = new Layout\DoubleBarLayout;
	}

	public function getPaginator()
	{
		return $this->paginator;
	}

	public function getIterator()
	{
		$pageSize = $this->paginator->getPageSize();
		return new \ArrayIterator(
			$this->paginator->getItems()->getSlice(
				$this->paginator->getPageSize(),
				$this->getStartIndex() - 1
			));
	}

	public function getNumber()
	{
		return $this->page;
	}

	public function hasNext()
	{
		return $this->page < $this->paginator->getTotalPages();
	}

	public function hasPrevious()
	{
		$totalPages = $this->paginator->getTotalPages();
		if ($totalPages > 1)
		{
			return $this->page >= $totalPages;
		}
		else
		{
			return false;
		}
	}

	public function hasOtherPages()
	{
		return ($this->hasPrevious() || $this->hasNext());
	}

	public function getNextPageNumber()
	{
		if ($this->page < $this->paginator->getTotalPages())
		{
			return $this->page + 1;
		}
	}

	public function getPreviousPageNumber()
	{
		if ($this->page > 1)
		{
			return $this->page - 1;
		}
	}

	public function getStartIndex()
	{
		$pageSize = $this->paginator->getPageSize();
		return ($pageSize * $this->page - $pageSize) + 1;
	}

	public function getEndIndex()
	{
		$pageSize = $this->paginator->getPageSize();
		$total = $this->paginator->getCountItems();
		if (($pageSize * $this->page - $total) > 0)
		{
			return $total;
		}
		else
		{
			return $pageSize * $this->page;
		}
	}

	public function getLayout()
	{
		return $this->layout;
	}

	public function setLayout(Layout\PageLayoutInterface $layout)
	{
		$this->layout = $layout;
	}

	public function renderNavigation($options = array())
	{
		return $this->layout->renderNavigation($this, $options);
	}
}
