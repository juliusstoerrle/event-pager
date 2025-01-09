<?php

namespace App\Tests\Entity;

use App\Core\IntelPage\Model\CapCode;
use PHPUnit\Framework\TestCase;

final class CapCodeTest extends TestCase
{
    public function testCreateValidCapCode(): void
    {
        $cc = new CapCode(3);
        $this->assertTrue(3 === $cc->getCode());
    }

    public function testCreateInvalidCapCode(): void
    {
        foreach ([-1, 0, 9999999, 10000000] as $testValue) {
            $this->expectException(\InvalidArgumentException::class);
            new CapCode($testValue);
        }
    }
}
