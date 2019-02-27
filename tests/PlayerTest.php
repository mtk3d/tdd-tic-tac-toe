<?php

use PHPUnit\Framework\TestCase;
use App\Entities\{Mark, Player};

final class PlayerTest extends TestCase
{
    private $mark;

    public function setUp() : void
    {
        $this->mark = $this->createMock(Mark::class);
        $this->mark->method('getChar')->willReturn('x');
    }

    public function testCreatePlayer() : void
    {
        $player = new Player('John', $this->mark);

        $this->assertEquals($player->getName(), 'John');
        $this->assertEquals($player->getMark(), $this->mark);
    }
}
