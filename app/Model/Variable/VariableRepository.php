<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Variable;
use Doctrine\ORM\EntityManagerInterface;

class VariableRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Variable::class);
    }

    /**
     * @param $id
     * @return Variable|object
     */
    public function get(string $id)
    {
        return parent::get($id);
    }

    public function getByName(string $name): ?Variable
    {
        return $this->getRepository()->findOneBy([
            'name' => $name
        ]);
    }

    public function create(string $name, int $value): Variable
    {
        return new Variable($name, $value);
    }
}