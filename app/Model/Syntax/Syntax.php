<?php

declare(strict_types=1);

namespace App\Model\Syntax;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="syntax")
 */
class Syntax
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid_binary", unique=true)
	 */
	private UuidInterface $id;

	/** @ORM\Column(type="string", unique=true) */
	private string $name;

	public function __construct(UuidInterface $id, SyntaxData $data)
	{
		$this->id = $id;
		$this->name = $data->name;
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}
}
