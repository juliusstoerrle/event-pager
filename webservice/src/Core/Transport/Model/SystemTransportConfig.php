<?php

namespace App\Core\Transport\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * This entity enables administrators to manage transport
 * through the application instead of through configuration
 * files to improve easy of administration.
 *
 * A SystemTransportConfig combines a technical transport
 * implementation with a user readable title and deployment
 * specific configuration (e.g. API Keys).
 * There can be multiple configurations for one transport.
 */
// #[ORM\Entity]
class SystemTransportConfig
{
    // id

    /**
     * human readable, unique id to reference within configuration.
     */
    // #[ORM\Column]
    private readonly string $key;

    /**
     * FQCN of Transport implementation.
     */
    // #[ORM\Column]
    private readonly string $transport;

    /**
     * human readable identifier.
     */
    // #[ORM\Column(length: 80)]
    private string $title;

    /**
     * Do not allow sending new messages to this transport.
     *
     * Already queued outgoing messages may still be send.
     */
    // #[ORM\Column]
    private bool $enabled = false;

    /**
     * What ever data needs to be available to the transport centrally (e.g. API Keys).
     */
    // #[ORM\Column]
    private ?array $vendorSpecifcConfig;

    public function __construct(string $key, string $transport)
    {
        $this->key = $key;
        $this->transport = $transport;
    }

    public function transport(): string
    {
        return $this->transport;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @returns vendor-specific json-compatible configuration data, e.g. API Keys
     */
    public function getVendorSpecifcConfig(): ?array
    {
        return $this->vendorSpecifcConfig;
    }

    /**
     * Add configuration details specific to the transport vendor (e.g. API Keys).
     */
    public function setVendorSpecificConfig(
        #[\SensitiveParameter]
        ?array $vendorSpecifcConfig,
    ): void {
        $this->vendorSpecifcConfig = $vendorSpecifcConfig;
    }
}
