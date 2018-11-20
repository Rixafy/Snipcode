<?php

namespace App\Facade;

use App\Entity\Snippet;
use App\Repository\SnippetRepository;
use App\Repository\VariableRepository;
use App\Service\SlugGenerator;

class SnippetFacade
{
    /** @var SnippetRepository @inject */
    public $snippetRepository;

    /** @var VariableRepository @inject */
    public $variableRepository;

    /** @var SlugGenerator @inject */
    public $slugGenerator;

    /**
     * @param Snippet $snippet
     * @return Snippet
     */
    public function createSlug(Snippet $snippet): Snippet
    {
        $snippets_inserted = $this->variableRepository->getByName('snippets_inserted');

        $snippet->setSlugHelper($snippets_inserted->getValue());
        $snippet->setSlug($this->slugGenerator->generateSlug($snippet->getSlugHelper()));

        $snippets_inserted->increaseValue();

        $this->snippetRepository->save($snippet);
        $this->variableRepository->save($snippets_inserted);
    }
}