<?php declare(strict_types=1);

namespace Snipcode\Repository;

use Snipcode\Entity\Constant;
use Doctrine\ORM\EntityManagerInterface;

class ConstantRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Constant::class);
    }

    /**
     * @param $id
     * @return Constant|object
     */
    public function get(string $id)
    {
        return parent::get($id);
    }

    public function getByName(string $name): ?Constant
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
    }

    /**
     * @return Constant[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function create(string $name, string $value): Constant
    {
        return new Constant($name, $value);
    }
}