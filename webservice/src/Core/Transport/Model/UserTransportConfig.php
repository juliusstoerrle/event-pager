<?php

namespace App\Core\Transport\Model;

final readonly class UserTransportConfig
{
    public function __construct(
        /**
         * Identifier of the SystemTransportConfig this UserTransportConfig relates to.
         */
        public string $key,
        /**
         * Configuration options specific to the transport vendor, e.g. group names, phone numbers, id's.
         */
        public array $vendorSpecificConfig,

        // regel
    ) {
    }
}
