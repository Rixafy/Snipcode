<?php declare(strict_types=1);

namespace App\Facade;

use App\Repository\ConstantRepository;

class ConfigFacade
{
    /** @var ConstantRepository @inject */
    public $constantRepository;

    /** @var array */
    protected $constants;

    public function getConstants(): array
    {
        if ($this->constants === null) {
            $this->constants = [];

            foreach ($this->constantRepository->getAll() as $constant) {
                $this->constants[$constant->getName()] = $constant->getValue();
            }
        }

        return $this->constants;
    }
}