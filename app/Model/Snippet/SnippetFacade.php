<?php

declare(strict_types=1);

namespace Snipcode\Model\Snippet;

use Snipcode\Entity\Session;
use Snipcode\Facade\ProfileFacade;
use Snipcode\Model\Slug\SlugHelper;
use Snipcode\Model\Snippet\Exception\SnippetNotFoundException;
use Snipcode\Model\Variable\Exception\VariableNotFoundException;
use Snipcode\Model\Variable\VariableFacade;
use Snipcode\Model\Syntax\SyntaxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class SnippetFacade
{
    /** @var SnippetRepository */
    private $snippetRepository;

    /** @var SyntaxRepository */
    private $syntaxRepository;

    /** @var VariableFacade */
    private $variableFacade;

    /** @var SlugHelper */
    private $slugHelper;

    /** @var ProfileFacade */
    private $profileFacade;

    /** @var SnippetFactory */
    private $snippetFactory;

    /** @var EntityManagerInterface */
    private $entityManager;

	/**
	 * SnippetFacade constructor.
	 * @param SnippetRepository $snippetRepository
	 * @param SyntaxRepository $syntaxRepository
	 * @param VariableFacade $variableFacade
	 * @param SlugHelper $slugHelper
	 * @param ProfileFacade $profileFacade
	 * @param SnippetFactory $snippetFactory
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(
		SnippetRepository $snippetRepository, 
		SyntaxRepository $syntaxRepository, 
		VariableFacade $variableFacade, 
		SlugHelper $slugHelper, 
		ProfileFacade $profileFacade, 
		SnippetFactory $snippetFactory, 
		EntityManagerInterface $entityManager
	) {
		$this->snippetRepository = $snippetRepository;
		$this->syntaxRepository = $syntaxRepository;
		$this->variableFacade = $variableFacade;
		$this->slugHelper = $slugHelper;
		$this->profileFacade = $profileFacade;
		$this->snippetFactory = $snippetFactory;
		$this->entityManager = $entityManager;
	}

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

		$this->slugHelper->injectSlug($snippet);

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