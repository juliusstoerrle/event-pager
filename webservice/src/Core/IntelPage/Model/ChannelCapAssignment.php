<?php

declare(strict_types=1);

namespace App\Core\IntelPage\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
readonly class ChannelCapAssignment extends AbstractCapAssignment
{
    public const string DISCRIMINATOR = 'ch';

    #[ORM\ManyToOne(targetEntity: Channel::class)]
    private Channel $channel;

    public function __construct(
        Pager $pager,
        Slot $slot,
        Channel $channel,
    ) {
        parent::__construct($pager, $slot);
        $this->channel = $channel;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
    }
}
