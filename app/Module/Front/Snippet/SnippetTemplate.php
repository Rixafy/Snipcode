<?php

declare(strict_types=1);

namespace App\Module\Front\Snippet;

use App\Model\Snippet\Snippet;
use App\Module\Front\BaseFrontTemplate;

class SnippetTemplate extends BaseFrontTemplate
{
    public Snippet $snippet;
}
