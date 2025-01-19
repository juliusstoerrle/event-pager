<?php

namespace App\Core\IntelPage\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
readonly class NoCapAssignment extends AbstractCapAssignment
{
    public const string DISCRIMINATOR = 'nocapassignment';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }
}
