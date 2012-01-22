<?php

namespace Paginator;


interface PaginatorInterface
{
	public function setPageSize($pageSize);

	public function getPageSize();

	public function getPage($numPage);

	public function getAllowEmptyFirstPage();

	public function getTotalPages();

	public function getPageRange();

	public function getCountItems();

	public function getItems();
}
