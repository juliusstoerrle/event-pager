<?php

namespace App\Tests\Entity;

use App\Entity\CapCode;
use App\Entity\Channel;
use App\Entity\ChannelCapAssignment;
use App\Entity\IndividualCapAssignment;
use App\Entity\NoCapAssignment;
use App\Entity\Pager;
use PHPUnit\Framework\TestCase;

final class PagerTest extends TestCase
{
    public function testCapAssignment(): void
    {
        $pager = new Pager("Pager 1", 3);
        $channel = new Channel();

        $pager
            ->assignCap(0, new NoCapAssignment())
            ->assignCap(
                1,
                new IndividualCapAssignment(false, false, new CapCode(1))
            )
            ->assignCap(2, new ChannelCapAssignment($channel));

        $assignments = $pager->getCapAssignments();
        $this->assertTrue($assignments[0] instanceof NoCapAssignment);
        $this->assertTrue($assignments[1] instanceof IndividualCapAssignment);
        $this->assertTrue($assignments[2] instanceof ChannelCapAssignment);
    }

    public function testSlotOutOfBoundsUpper(): void
    {
        $pager = new Pager("Pager 2", 2);

        foreach ([-1, 9999999, 10000000] as $invalidSlot) {
            $this->expectException(\InvalidArgumentException::class);
            $pager->assignCap($invalidSlot, new NoCapAssignment());
        }
    }
}
