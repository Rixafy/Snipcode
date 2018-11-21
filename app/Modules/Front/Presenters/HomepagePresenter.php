<?php

namespace App\Presenters;

use App\Component\SnippetFormComponent;

final class HomepagePresenter extends BasePresenter
{
    /** @var SnippetFormComponent @inject */
    public $snippetFormComponent;

    protected function createComponentSnippetForm()
    {
        return $this->snippetFormComponent;
    }
}
