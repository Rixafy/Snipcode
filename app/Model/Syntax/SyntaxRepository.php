<?php declare(strict_types=1);

namespace Snipcode\Repository;

use Snipcode\Entity\Syntax;
use Doctrine\ORM\EntityManagerInterface;

class SyntaxRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Syntax::class);
    }

    /**
     * @param $id
     * @return Syntax|object
     */
    public function get(string $id)
    {
        return parent::get($id);
    }

    /**
     * @param $id
     * @return Syntax|object
     */
    public function getReference(string $id)
    {
        return parent::getReference($id);
    }

    public function getByName(string $name): ?Syntax
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
    }

    public function getByShortName(string $name): ?Syntax
    {
        return $this->getRepository()->findOneBy(['short_name' => $name]);
    }

    /**
     * @return Syntax[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function create(string $name): Syntax
    {
        return new Syntax($name);
    }
}