<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
trait DateTimeTrait
{
    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $created_at = null;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $updated_at = null;

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->updated_at = new DateTime();

        if ($this->created_at === null) {
            $this->created_at = new DateTime();
        }
    }
}