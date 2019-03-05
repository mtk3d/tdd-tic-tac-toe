<?php

use PHPUnit\Framework\TestCase;
use App\Entities\{Mark};

final class MarkTest extends TestCase
{
    public function testCreateMark() : void
    {
        $mark = new Mark(Mark::SHARP);
        $this->assertEquals($mark->getChar(), 'x');

        $mark = new Mark(Mark::CIRCLE);
        $this->assertEquals($mark->getChar(), 'o');
    }
}
