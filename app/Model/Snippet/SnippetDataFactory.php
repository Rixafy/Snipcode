<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use App\Model\Hashids\HashidsProvider;
use App\Model\Session\SessionProvider;
use App\Model\Syntax\SyntaxFacade;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final class SnippetDataFactory
{
    public function __construct(
        private SessionProvider $sessionProvider,
        private SyntaxFacade $syntaxFacade,
        private EntityManagerInterface $entityManager,
        private HashidsProvider $hashidsProvider,
    ) {}

    public function createFromFormData(array $formData, ?Snippet $forkedFrom): SnippetData
    {
        $data = new SnippetData();
        $data->title = $formData['title'];
        $data->payload = $formData['payload'];
        $data->expireAt = (new DateTime())->add(new DateInterval("P{$formData['expireInDays']}D"));
        $data->session = $this->sessionProvider->provide();
        $data->ipAddress = $this->sessionProvider->provide()->getIpAddress();
        $data->syntax = $formData['syntax'] === null ? null : $this->syntaxFacade->get(Uuid::fromString($formData['syntax']));
        $data->forkedFrom = $forkedFrom;
        
        $data->encodedNumber = $this->getNextEncodedNumber();
        $data->slug = $this->hashidsProvider->provide()->encode($data->encodedNumber);

        return $data;
    }

    private function getNextEncodedNumber(): int
    {
        return (int) $this->entityManager->getRepository(Snippet::class)
            ->createQueryBuilder('e')
            ->select('MAX(e.encodedNumber)')
            ->getQuery()
            ->getSingleScalarResult() + 1;
    }
}
