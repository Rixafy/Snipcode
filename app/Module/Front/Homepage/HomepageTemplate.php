<?php

declare(strict_types=1);

namespace App\Module\Front\Homepage;

use App\Model\Snippet\Snippet;
use App\Module\Front\BaseFrontTemplate;

class HomepageTemplate extends BaseFrontTemplate
{
    /** @var Snippet[] */
    public array $yourSnippets;
    
    public ?Snippet $forkedFrom;
}
