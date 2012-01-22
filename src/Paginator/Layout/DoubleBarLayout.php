<?php

namespace Paginator\Layout;

use Paginator\PageInterface;

/**
 * 
 **/
class DoubleBarLayout implements PageLayoutInterface
{
	public function renderNavigation(PageInterface $page, $options = array())
	{
		$options = array_merge(array(
			'url' => '',
			'pageParam' => 'page',
			'querystring' => ''
		), $options);

		$buffer = array();
		if ($page->hasPrevious())
		{
			$href = "{$options['url']}?{$options['pageParam']}={$page->getPreviousPageNumber()}";
			if ($options['querystring'])
			{
				$href .= '&'.$options['querystring'];
			}
			$buffer[] = "<a href=\"$href\">&lt; Previous</a>";
		}
		else
		{
			$buffer[] = '<span class="inactive">&lt; Previous</span>';
		}
		$buffer[] = ' | ';
		if ($page->hasNext())
		{
			$href = "{$options['url']}?{$options['pageParam']}={$page->getNextPageNumber()}";
			if ($options['querystring'])
			{
				$href .= '&'.$options['querystring'];
			}
			$buffer[] = "<a href=\"$href\">Next &gt;</a>";
		}
		else
		{
			$buffer[] = '<span class="inactive">Next &gt;</span>';
		}

		return implode('', $buffer);
	}
}
