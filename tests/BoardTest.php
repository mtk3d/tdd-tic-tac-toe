<?php

use PHPUnit\Framework\TestCase;
use App\Entities\{Board, Mark, Player};

final class BoardTest extends TestCase
{
    private $markX;
    private $markO;

    public function setUp() : void
    {
        $this->markX = $this->createMock(Mark::class);
        $this->markX->method('getChar')->willReturn(Mark::SHARP);

        $this->markO = $this->createMock(Mark::class);
        $this->markO->method('getChar')->willReturn(Mark::CIRCLE);
    }

    public function testCreatesValidBoard() : void
    {
        $board = new Board(4, 5);
        $this->assertEquals($board->getBoard(),[
            [ null, null, null, null ],
            [ null, null, null, null ],
            [ null, null, null, null ],
            [ null, null, null, null ],
            [ null, null, null, null ]
        ]);
    }
    
    public function testSetMarkInOutOfRange() : void
    {
        $board = new Board(3, 3);
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Mark position is out of range");

        $board->setMark(6, 2, $this->markX);
    }

    public function testSetMarks() : void
    {
        $board = new Board(3, 3);

        $board->setMark(2, 2, $this->markX);
        $board->setMark(2, 3, $this->markO);

        $this->assertEquals($board->getBoard(),[
            [ null, null, null ],
            [ null, 'x', null ],
            [ null, 'o', null ]
        ]);
    }

    public function testSetMarkInNotEmptyPlace() : void
    {
        $board = new Board(3, 3);

        $board->setMark(2, 2, $this->markX);
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Mark position is not empty");

        $board->setMark(2, 2, $this->markO);
    }

    public function testGetBoardBoxCount() : void
    {
        $board = new Board(3, 3);

        $this->assertEquals($board->getBoxCount(), 9);
    }
}
