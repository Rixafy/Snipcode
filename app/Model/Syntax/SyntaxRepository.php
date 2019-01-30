<?php

namespace App\Repository;

use App\Entity\Syntax;
use Nettrine\ORM\EntityManager;

class SyntaxRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
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

    /**
     * @param string $name
     * @return Syntax|object
     */
    public function getByName(string $name)
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
    }

    /**
     * @param string $name
     * @return Syntax|object
     */
    public function getByShortName(string $name)
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

    /**
     * @param string $name
     * @return Syntax
     */
    public function create(string $name): Syntax
    {
        return new Syntax($name);
    }
}