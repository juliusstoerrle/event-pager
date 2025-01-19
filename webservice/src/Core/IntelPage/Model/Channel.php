<?php

namespace App\Core\IntelPage\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Channel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Embedded]
    private CapCode $capCode;

    #[ORM\Column]
    private bool $audible;

    #[ORM\Column]
    private bool $vibration;

    public function getCapCode(): CapCode
    {
        return $this->capCode;
    }

    public function setCapCode(CapCode $capCode): void
    {
        $this->capCode = $capCode;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAudible(): bool
    {
        return $this->audible;
    }

    public function setAudible(bool $audible): static
    {
        $this->audible = $audible;

        return $this;
    }

    public function isVibration(): bool
    {
        return $this->vibration;
    }

    public function setVibration(bool $vibration): static
    {
        $this->vibration = $vibration;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
