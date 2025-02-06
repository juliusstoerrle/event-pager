<?php

declare(strict_types=1);

namespace App\Tests\Core\IntelPage\Model;

use App\Core\IntelPage\Model\CapCode;
use App\Core\IntelPage\Model\Channel;
use App\Core\IntelPage\Model\ChannelCapAssignment;
use App\Core\IntelPage\Model\IndividualCapAssignment;
use App\Core\IntelPage\Model\NoCapAssignment;
use App\Core\IntelPage\Model\Pager;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('unit')]
final class PagerTest extends TestCase
{
    public function testCapAssignment(): void
    {
        $pager = new Pager('Pager 1', 3);
        $channel = new Channel();

        $pager->assignCap(0, new NoCapAssignment())
            ->assignCap(1, new IndividualCapAssignment(false, false, CapCode::fromInt(1)))
            ->assignCap(7, new ChannelCapAssignment($channel));

        $assignments = $pager->getCapAssignments();
        self::assertInstanceOf(NoCapAssignment::class, $assignments[0]);
        self::assertInstanceOf(IndividualCapAssignment::class, $assignments[1]);
        self::assertInstanceOf(ChannelCapAssignment::class, $assignments[7]);
    }

    public function testSlotOutOfBoundsUpper(): void
    {
        $pager = new Pager('Pager 2', 2);

        try {
            $pager->assignCap(8, new NoCapAssignment());
        } catch (InvalidArgumentException $e) {
            self::assertTrue(true);

            return;
        }

        self::fail('Assigned a CapAssignment out of bounds but shouldn\'t be able to!');
    }

    public function testSlotOutOfBoundsLower(): void
    {
        $pager = new Pager('Pager 3', 3);

        try {
            $pager->assignCap(-1, new NoCapAssignment());
        } catch (InvalidArgumentException $e) {
            self::assertTrue(true);

            return;
        }

        self::fail();
    }
}
