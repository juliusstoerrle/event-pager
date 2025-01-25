<?php

namespace App\Core\IntelPage\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ChannelCapAssignment extends AbstractCapAssignment
{
    public const string DISCRIMINATOR = 'channelcapassignment';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Channel $channel;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
    }

    public function setChannel(Channel $channel): static
    {
        $this->channel = $channel;

        return $this;
    }
}
