<?php

namespace App\Repository;

use App\Entity\IpAddress;
use App\Entity\Session;
use App\Entity\Snippet;
use App\Entity\Syntax;
use DateTime;
use Nettrine\ORM\EntityManager;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

class SnippetRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
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

    /**
     * @param int $value
     * @return Snippet|object
     */
    public function getByAutoIncrement(int $value)
    {
        return $this->getRepository()->findOneBy([
            'auto_increment' => $value
        ]);
    }

    /**
     * @param null|string $title
     * @param string $payload
     * @param Session $authorSession
     * @param IpAddress $authorIpAddress
     * @param Syntax $syntax
     * @param DateTime $expireAt
     * @return Snippet
     */
    public function create(?string $title, string $payload, Session $authorSession, IpAddress $authorIpAddress, ?Syntax $syntax, DateTime $expireAt): Snippet
    {
        return new Snippet($title, $payload, $authorSession, $authorIpAddress, $syntax, $expireAt);
    }

    //TODO: Need case sensitive support in Doctrine2

    /**
     * @param string $slug
     * @return Snippet[]
     */
    public function getBySlug(string $slug): array
    {
        return $this->getRepository()->findBy(['slug' => $slug]);
    }

    /**
     * @param string $slug
     * @return Snippet|null
     */
    public function getOneBySlug(string $slug): ?Snippet
    {
        foreach ($this->getBySlug($slug) as $snippet) {
            if ($snippet->getSlug() === $slug)
                return $snippet;
        }

        return null;
    }

    /**
     * @param Session $session
     * @return Snippet|object
     */
    public function getLastBySession(Session $session): ?Snippet
    {
        return $this->getRepository()->findOneBy([
            'author_session' => $session
        ], [
            'created_at' => 'desc'
        ]);
    }
}