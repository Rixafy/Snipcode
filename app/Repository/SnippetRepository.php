<?php

namespace App\Repository;

use App\Entity\IpAddress;
use App\Entity\Session;
use App\Entity\Snippet;
use App\Entity\Syntax;
use DateTime;
use Nettrine\ORM\EntityManager;

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
     * @param string $payload
     * @param Session $authorSession
     * @param IpAddress $authorIpAddress
     * @param Syntax $syntax
     * @param DateTime $expireAt
     * @return Snippet
     */
    public function create(string $payload, Session $authorSession, IpAddress $authorIpAddress, Syntax $syntax, DateTime $expireAt): Snippet
    {
        return new Snippet($payload, $authorSession, $authorIpAddress, $syntax, $expireAt);
    }
}