<?php

namespace App\Core\IntelPage\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Pager
{
    public const int PAGER_SLOT_MIN = 0;
    public const int PAGER_SLOT_MAX = 7;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    // ULID
    private int $id;

    #[ORM\Column(length: 255)]
    private string $label;

    #[ORM\Column]
    private int $number;

    #[ORM\OneToMany(
        targetEntity: AbstractCapAssignment::class,
        mappedBy: 'slots',
        cascade: ['persist', 'remove'],
        orphanRemoval: true,
        indexBy: 'slot'
    )]
    private Collection $slots;

    public function __construct(
        string $label,
        int $number,
        ArrayCollection $slots = new ArrayCollection(),
    ) {
        $this->slots = $slots;
        $this->label = $label;
        $this->number = $number;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    private function isInSlotBounds(int $slot): bool
    {
        return ($slot >= self::PAGER_SLOT_MIN) && ($slot <= self::PAGER_SLOT_MAX);
    }

    public function getCapAssignment(int $atSlot): AbstractCapAssignment
    {
        if (!$this->isInSlotBounds($atSlot)) {
            throw new \InvalidArgumentException('Trying to access out of bounds slot!');
        }

        return $this->slots->get($atSlot);
    }

    public function getCapAssignments(): iterable
    {
        return $this->slots->toArray();
    }

    public function assignCap(AbstractCapAssignment $assignment): static
    {
        if (!$this->isInSlotBounds($assignment->getSlot())) {
            throw new \InvalidArgumentException('Trying to access out of bounds slot!');
        }

        $this->slots->set($assignment->getSlot(), $assignment);

        return $this;
    }

    public function setLabel(string $label): static
    {
        if (strlen($label) > 255 || 0 === strlen($label)) {
            throw new \InvalidArgumentException('The length of the new label must be from 0 to 255 characters!');
        }

        $this->label = $label;

        return $this;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }
}
