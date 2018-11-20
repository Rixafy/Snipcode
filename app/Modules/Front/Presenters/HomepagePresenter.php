<?php

namespace App\Presenters;

use App\Form\SnippetFormFactory;

final class HomepagePresenter extends BasePresenter
{
    /** @var SnippetFormFactory @inject */
    public $snippetFormFactory;

    protected function createComponentSnippetForm()
    {
        return $this->snippetFormFactory->create();
    }
}
