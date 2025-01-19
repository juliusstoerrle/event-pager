<?php

namespace App\Core\IntelPage\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
readonly class IndividualCapAssignment extends AbstractCapAssignment
{
    public const string DISCRIMINATOR = 'individualcapassignment';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Embedded]
    private CapCode $capCode;

    #[ORM\Column]
    private bool $audible;

    #[ORM\Column]
    private bool $vibration;

    public function __construct(bool $audible, bool $vibration, CapCode $capCode)
    {
        $this->audible = $audible;
        $this->vibration = $vibration;
        $this->capCode = $capCode;
    }

    public function getCapCode(): CapCode
    {
        return $this->capCode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isAudible(): bool
    {
        return $this->audible;
    }

    public function isVibration(): bool
    {
        return $this->vibration;
    }
}
