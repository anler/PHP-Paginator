<?php

namespace Paginator\Layout;

use Paginator\PageInterface;


interface PageLayoutInterface
{
	public function renderNavigation(PageInterface $page, $options = array());
}
