<?php

declare(strict_types=1);

namespace App\Core\MessageRecipient\Model;

use Symfony\Component\Uid\Ulid;

/**
 * @property-read Ulid $id
 */
interface MessageRecipient
{
    public function getName(): string;
}
