<?php declare(strict_types=1);

namespace Snipcode\Component;

use Snipcode\Form\SnippetFormFactory;

class SnippetFormComponent extends BaseComponent
{
    /** @var SnippetFormFactory @inject */
    public $snippetFormFactory;

    public function createComponentForm()
    {
        return $this->snippetFormFactory->create($this, $this->getPresenter()->getForkText());
    }
}