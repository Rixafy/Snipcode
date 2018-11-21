<?php

namespace App\Component;

use App\Form\SnippetFormFactory;

class SnippetFormComponent extends BaseComponent
{
    /** @var SnippetFormFactory @inject */
    public $snippetFormFactory;

    public function createComponentForm()
    {
        return $this->snippetFormFactory->create($this);
    }
}