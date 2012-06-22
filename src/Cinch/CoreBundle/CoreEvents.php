<?php

namespace Cinch\CoreBundle;

class CoreEvents
{
	// before/after rendering events
    const BEFORE_PAGE_RENDERED = 'cinch.core.before_page_rendered';
    const AFTER_PAGE_RENDERED = 'cinch.core.after_page_rendered';
    const BEFORE_REGION_RENDERED = 'cinch.core.before_region_rendered';
    const AFTER_REGION_RENDERED = 'cinch.core.after_region_rendered';
    const BEFORE_BLOCK_RENDERED = 'cinch.core.before_block_rendered';
    const AFTER_BLOCK_RENDERED = 'cinch.core.after_block_rendered';
}