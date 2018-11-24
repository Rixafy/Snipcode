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

    public function actionDefault(string $slug)
    {
        $this->snippet = $this->snippetFacade->getBySlug($slug, true);

        if($this->snippet === null) {
            $this->error("Snippet not found");
        }
    }

    public function renderDefault()
    {
        $this->template->snippet = $this->snippet;
    }
}
