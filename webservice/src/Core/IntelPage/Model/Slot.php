<?php

declare(strict_types=1);

namespace App\Core\IntelPage\Model;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Embeddable]
readonly class Slot {
    #[ORM\Column(type: 'integer')]
    private int $slot;

    public const int SLOT_MAX = 7;
    public const int SLOT_MIN = 0;

    public function isInBounds(int $slot): bool
    {
        return ($slot >= self::SLOT_MIN) && ($slot <= self::SLOT_MAX);
    }

    public function __construct(int $slot)
    {
        if (!$this->isInBounds($slot)) {
            throw new \InvalidArgumentException("Slot value $slot out of bounds!");
        }
        $this->slot = $slot;
    }
}