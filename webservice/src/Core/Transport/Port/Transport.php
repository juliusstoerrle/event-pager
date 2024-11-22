<?php

namespace App\Core\Transport\Port;

use App\Core\Transport\Model\Message;
use App\Core\Transport\Model\SystemTransportConfig;
use App\Core\Transport\Model\UserTransportConfig;

/**
 * A Transport implements the logic to push (or queue) one
 * message to one delivery mechanism (e.g. Telegram, SMS, Email).
 *
 * A Transport is instantiated through the withSystemConfiguration factory method,
 * receiving configuration options such as API keys set by an administrator.
 * When creating a new transport, start by creating a Transport class.
 */
interface Transport
{
    /**
     * static constructor method.
     */
    public static function withSystemConfiguration(SystemTransportConfig $config): static;

    /**
     * Once a message was determined to be send through this transport,
     * it should be passed to this method.
     *
     * The implementation of this method should validate the message if
     * applicable, otherwise queue the message for asynchonous processing
     */
    public function process(Message $message, UserTransportConfig $config): void;

    /**
     * Allows to check if a transport is enabled and configured correctly
     * to be able to send messages.
     */
    public function acceptsNewMessages(): bool;
}
