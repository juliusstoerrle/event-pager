<?php

declare(strict_types=1);

namespace App\Core\IntelPage\Application;

use App\Core\IntelPage\Exception\TransmitterNotAvailable;
use App\Core\IntelPage\Port\IntelPageSenderInterface;
use UnexpectedValueException;

use function ini_get;
use function sprintf;

final readonly class IntelPageSender implements IntelPageSenderInterface
{
    /**
     * @param int $transmitterConnectionTimout in seconds
     */
    public function __construct(
        private string $transmitterHost,
        private int $transmitterPort,
        private int $transmitterConnectionTimout = 10,
    ) {
        if ('1' !== ini_get('allow_url_fopen')) {
            throw new UnexpectedValueException('The PHP option "allow_url_fopen" is disabled. Please enable by setting "allow_url_fopen = On" in your php.ini');
        }
    }

    public function transmit(int $capCode, string $text): void
    {
        $outputMessage = sprintf("%d\r%s\r\r", $capCode, $text);

        $pattern = '/^\d+\r[\x00-\x7F]+\r\r$/';
        if (false === preg_match($pattern, $outputMessage)) {
            throw new UnexpectedValueException('The output could not be generated in valid ASCII');
        }

        $errno = 0;
        $errstr = '';
        $fp = fsockopen($this->transmitterHost, $this->transmitterPort, $errno, $errstr, $this->transmitterConnectionTimout);
        if (false === $fp) {
            throw new TransmitterNotAvailable('The transmitter "'.$this->transmitterHost.':'.$this->transmitterPort.'" is not reachable. Error number: '.$errno.' Error string: '.$errstr);
        }

        if (false === fwrite($fp, $outputMessage)) {
            fclose($fp);
            throw new TransmitterNotAvailable('The transmitter "'.$this->transmitterHost.':'.$this->transmitterPort.'" broke connection during transmission');
        }

        fclose($fp);
    }
}
