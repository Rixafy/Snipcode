<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use App\Entity\Session;
use App\Facade\ProfileFacade;
use App\Model\Snippet\Exception\SnippetNotFoundException;
use App\Model\Variable\Exception\VariableNotFoundException;
use App\Model\Variable\VariableFacade;
use App\Repository\SyntaxRepository;
use App\Service\SlugGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class SnippetFacade
{
    /** @var SnippetRepository @inject */
    public $snippetRepository;

    /** @var SyntaxRepository @inject */
    public $syntaxRepository;

    /** @var VariableFacade @inject */
    public $variableFacade;

    /** @var SlugGenerator @inject */
    public $slugGenerator;

    /** @var ProfileFacade @inject */
    public $profileFacade;

    /** @var SnippetFactory @inject */
    public $snippetFactory;

    /** @var EntityManagerInterface @inject */
    public $entityManager;

	/**
	 * @throws SnippetNotFoundException
	 */
	public function get(UuidInterface $uuid): Snippet
	{
		return $this->snippetRepository->get($uuid);
	}

	/**
	 * @throws VariableNotFoundException
	 */
	public function create(SnippetData $snippetData): Snippet
	{
		$snippet = $this->snippetFactory->create($snippetData);

		$this->slugGenerator->injectSlug($snippet);

		$this->entityManager->persist($snippet);
		$this->entityManager->flush();

		return $snippet;
	}

	/**
	 * @throws SnippetNotFoundException
	 */
	public function getBySlug(string $slug, bool $addView = false): Snippet
    {
        $snippet = $this->snippetRepository->getBySlug($slug);

        if ($snippet !== null && $addView) {
            $snippet->addView();
            $this->entityManager->flush();
        }

        return $snippet;
    }

	/**
	 * @throws SnippetNotFoundException
	 */
	public function getLastSnippet(Session $session): Snippet
    {
        return $this->snippetRepository->getLastBySession($session);
    }
}