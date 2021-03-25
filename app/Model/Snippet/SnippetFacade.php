<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use App\Model\Snippet\Exception\SnippetNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class SnippetFacade extends SnippetRepository
{
    public function __construct(
        private SnippetFactory $snippetFactory,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct($entityManager);
    }

    public function create(SnippetData $data): Snippet
    {
        $snippet = $this->snippetFactory->create($data);

        $this->entityManager->persist($snippet);
        $this->entityManager->flush();

        return $snippet;
    }

    /**
     * @throws SnippetNotFoundException
     */
    public function edit(UuidInterface $id, SnippetData $data): Snippet
    {
        $snippet = $this->get($id);

        $snippet->edit($data);
        $this->entityManager->flush();

        return $snippet;
    }

    /**
     * @throws SnippetNotFoundException
     */
    public function delete(UuidInterface $id): void
    {
        $snippet = $this->get($id);

        $this->entityManager->remove($snippet);
        $this->entityManager->flush();
    }
}
