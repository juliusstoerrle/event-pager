<?php

namespace App\Core\IntelPage\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[
    ORM\DiscriminatorMap([
        NoCapAssignment::DISCRIMINATOR => NoCapAssignment::class,
        IndividualCapAssignment::DISCRIMINATOR => IndividualCapAssignment::class,
        ChannelCapAssignment::DISCRIMINATOR => ChannelCapAssignment::class,
    ])
]
readonly abstract class AbstractCapAssignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Embedded]
    private Slot $slot;

    #[ORM\ManyToOne(targetEntity: Pager::class, inversedBy: "slots")]
    #[ORM\JoinColumn(name: "pager_id", referencedColumnName: "id")]
    private Pager $pager;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlot(): Slot
    {
        return $this->slot;
    }

    public function setSlot(Slot $slot): static
    {
        $this->slot = $slot;

        return $this;
    }
}
