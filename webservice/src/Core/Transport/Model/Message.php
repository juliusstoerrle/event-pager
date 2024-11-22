<?php

namespace App\Core\Transport\Model;

/**
 * Contract for messages pushed to a transport to keep transport module low-level.
 *
 * @property $messageId
 * @property $content
 */
interface Message
{
    // FOR PHP 8.4:
    // public string $messageId { get; }
    // public string $content { get; }
}
