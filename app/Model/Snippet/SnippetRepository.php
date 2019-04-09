<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\IpAddress;
use App\Entity\Session;
use App\Entity\Snippet;
use App\Entity\Syntax;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class SnippetRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Snippet::class);
    }

    /**
     * @param $id
     * @return Snippet|object
     */
    public function get(string $id)
    {
        return parent::get($id);
    }

    public function getByAutoIncrement(int $value): ?Snippet
    {
        return $this->getRepository()->findOneBy([
            'auto_increment' => $value
        ]);
    }

    public function create(?string $title, string $payload, Session $authorSession, IpAddress $authorIpAddress, ?Syntax $syntax, DateTime $expireAt): Snippet
    {
        return new Snippet($title, $payload, $authorSession, $authorIpAddress, $syntax, $expireAt);
    }

    public function getBySlug(string $slug): ?Snippet
    {
        return $this->getRepository()->findOneBy(['slug' => $slug]);
    }

    public function getLastBySession(Session $session): ?Snippet
    {
        return $this->getRepository()->findOneBy([
            'author_session' => $session
        ], [
            'created_at' => 'desc'
        ]);
    }
}