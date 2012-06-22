<?php

namespace Cinch\CoreBundle\Container;

use Cinch\CoreBundle\Entity\Page;

class DataContainer
{
	private $page;

	public function setPage(Page $page)
	{
		$this->page = $page;
	}

	public function getPage()
	{
		return $this->page;
	}

    public function getRegion($alias)
    {
        return $this->page->getRegion($alias);
    }

    public function getRegions()
    {
        return $this->page->getRegions();
    }

    public function getBlocks()
    {
        $blocks = array();

        foreach ($this->page->getRegions() as $region)
        {
            foreach ($region->getBlocks() as $block)
            {
                $blocks[] = $block;
            }
        }

        return $blocks;
    }
}