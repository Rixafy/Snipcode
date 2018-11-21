<?php

namespace App\Facade;

use App\Entity\Snippet;
use App\Entity\Syntax;
use App\Repository\SnippetRepository;
use App\Repository\SyntaxRepository;
use App\Repository\VariableRepository;
use App\Service\SlugGenerator;
use DateTime;

class SnippetFacade
{
    /** @var SnippetRepository @inject */
    public $snippetRepository;

    /** @var SyntaxRepository @inject */
    public $syntaxRepository;

    /** @var VariableRepository @inject */
    public $variableRepository;

    /** @var SlugGenerator @inject */
    public $slugGenerator;

    /** @var ProfileFacade @inject */
    public $profileFacade;

    /** @var Snippet */
    private $temporarySnippet;

    public function getSnippet(string $slug)
    {
        return $this->snippetRepository->getOneBySlug($slug);
    }

    /**
     * @param Snippet $snippet
     * @return Snippet
     */
    private function generateSlug(Snippet $snippet): Snippet
    {
        $snippets_inserted = $this->variableRepository->getByName('snippets_inserted');

        $snippets_inserted->increaseValue();

        $snippet->setSlugHelper($snippets_inserted->getValue());
        $snippet->setSlug($this->slugGenerator->encodeSlug($snippet->getSlugHelper()));

        $this->snippetRepository->save($snippet);
        $this->variableRepository->save($snippets_inserted);

        return $snippet;
    }

    /**
     * @param null|string $title
     * @param string $payload
     * @param Syntax|null $syntax
     * @param DateTime $expireAt
     * @return Snippet
     */
    public function createSnippet(?string $title, string $payload, ?Syntax $syntax, DateTime $expireAt): Snippet
    {
        $snippet = $this->snippetRepository->create($title, $payload, $this->profileFacade->getCurrentSession(), $this->profileFacade->getCurrentIpAddress(), $syntax, $expireAt);

        return $this->generateSlug($snippet);
    }

    public function flushSnippets(): void
    {
        $this->snippetRepository->flush();
    }

    /**
     * @return Snippet
     */
    public function getTemporarySnippet(): Snippet
    {
        return $this->temporarySnippet;
    }

    /**
     * @param Snippet $temporarySnippet
     */
    public function setTemporarySnippet(Snippet $temporarySnippet): void
    {
        $this->temporarySnippet = $temporarySnippet;
    }
}