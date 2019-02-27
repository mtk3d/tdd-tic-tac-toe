<?php

use PHPUnit\Framework\TestCase;
use App\Utils\BoardAnalyzer;

final class BoardAnalyzerTest extends TestCase
{
    private $boardDiagonalLine = [
        [ 'o', 'o', 'x' ],
        [ 'x', 'o', 'x' ],
        [ 'o', 'x', 'o' ]
    ];

    private $boardDiagonalSecondLine = [
        [ 'x', 'o', 'o' ],
        [ 'o', 'o', 'x' ],
        [ 'o', 'x', 'x' ]
    ];

    private $boardHorizontalLine = [
        [ 'o', 'o', 'o' ],
        [ 'x', 'o', 'x' ],
        [ 'x', 'x', 'o' ]
    ];

    private $boardVerticalLine = [
        [ 'o', 'o', 'x' ],
        [ 'x', 'o', 'x' ],
        [ 'o', 'x', 'x' ]
    ];

    private $boardNoWinner = [
        [ 'o', 'o', 'x' ],
        [ 'x', 'o', 'o' ],
        [ 'o', 'x', 'x' ]
    ];

    public function testAnalyzerHorizontal() : void
    {
        $result = BoardAnalyzer::analyze($this->boardHorizontalLine);
        $this->assertEquals($result, 'o');
    }

    public function testAnalyzerDiagonal() : void
    {
        $result = BoardAnalyzer::analyze($this->boardDiagonalLine);
        $this->assertEquals($result, 'o');

        $result = BoardAnalyzer::analyze($this->boardDiagonalSecondLine);
        $this->assertEquals($result, 'o');
    }
    
    public function testAnalyzerVertical() : void
    {
        $result = BoardAnalyzer::analyze($this->boardVerticalLine);
        $this->assertEquals($result, 'x');
    }
    
    public function testAnalyzerNoWinner() : void
    {
        $result = BoardAnalyzer::analyze($this->boardNoWinner);
        $this->assertEquals($result, null);
    }
}