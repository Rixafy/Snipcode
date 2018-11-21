<?php

namespace App\Presenters;

use App\Entity\Snippet;
use App\Facade\SnippetFacade;

final class SnippetPresenter extends BasePresenter
{
    /** @var SnippetFacade @inject */
    public $snippetFacade;

    /** @var Snippet */
    private $snippet;

    public function actionView(string $slug)
    {
        $this->snippet = $this->snippetFacade->getSnippet($slug);
    }

    public function renderView(string $slug)
    {
        $this->template->snippet = $this->snippet;
    }
}
