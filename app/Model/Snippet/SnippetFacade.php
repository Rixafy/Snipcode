<?php declare(strict_types=1);

namespace App\Facade;

use App\Entity\Session;
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

    public function getById(string $id): ?Snippet
    {
        return $this->snippetRepository->get($id);
    }

    public function getBySlug(string $slug, bool $addView = false): ?Snippet
    {
        $snippet = $this->snippetRepository->getBySlug($slug);

        if ($snippet !== null && $addView) {
            $snippet->addView();
            $this->snippetRepository->save($snippet);
            $this->snippetRepository->flush();
        }

        return $snippet;
    }

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

    public function createSnippet(?string $title, string $payload, ?Syntax $syntax, DateTime $expireAt): Snippet
    {
        $snippet = $this->snippetRepository->create($title, $payload, $this->profileFacade->getCurrentSession(), $this->profileFacade->getCurrentIpAddress(), $syntax, $expireAt);

        return $this->generateSlug($snippet);
    }

    public function flushSnippets(): void
    {
        $this->snippetRepository->flush();
    }

    public function getTemporarySnippet(): Snippet
    {
        return $this->temporarySnippet;
    }

    public function setTemporarySnippet(Snippet $temporarySnippet): void
    {
        $this->temporarySnippet = $temporarySnippet;
    }

    public function getLastSnippet(Session $session): ?Snippet
    {
        return $this->snippetRepository->getLastBySession($session);
    }
}