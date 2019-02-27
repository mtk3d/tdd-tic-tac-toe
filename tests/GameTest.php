<?php

use PHPUnit\Framework\TestCase;
use App\Entities\{Board, Mark, Player, Game};

final class GameTest extends TestCase
{
    private $playerOne;
    private $playerTwo;
    private $board;

    public function setUp() : void
    {
        $markX = $this->createMock(Mark::class);
        $markX->method('getChar')->willReturn('x');

        $markO = $this->createMock(Mark::class);
        $markO->method('getChar')->willReturn('o');

        $this->playerOne = $this->createMock(Player::class);
        $this->playerOne->method('getName')->willReturn('John');
        $this->playerOne->method('getMark')->willReturn($markX);

        $this->playerTwo = $this->createMock(Player::class);
        $this->playerTwo->method('getName')->willReturn('Jane');
        $this->playerTwo->method('getMark')->willReturn($markO);

        $this->board = $this->createMock(Board::class);
        $this->board->method('getBoard')->willReturn([
            [ null, null, null ],
            [ null, null, null ],
            [ null, null, null ]
        ]);
        $this->board->method('getBoxCount')->willReturn(9);
    }

    public function testSetMoreThanTwoPlayers() : void
    {
        $game = $this->_regularGame();

        $thirdPlayer = $this->createMock(Player::class);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("There is no more place");
        
        $game->addPlayer($thirdPlayer);
    }

    public function testSetTheSamePlayer() : void
    {
        $game = $this->_singlePlayerGame();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("This player is already in the game");
        
        $game->addPlayer($this->playerOne);
    }

    public function testSetTwoTheSameMarksInTour() : void
    {
        $game = $this->_regularGame();

        $player = $game->whichPlayer();
        $game->makeMove(2, 2, $player);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Is no your tour now");

        $game->makeMove(2, 3, $player);
    }

    public function testThereIsNoBoardInTheGame() : void
    {
        $game = $this->_noBoardGame();
        $player = $game->whichPlayer();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("There is no board in the game");

        $game->makeMove(2, 3, $player);
    }

    public function testThereIsNotEnoughPlayers() : void
    {
        $game = $this->_singlePlayerGame();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("There is not enough players in the game");

        $game->makeMove(2, 3, $this->playerOne);
    }

    public function testTheGameIsOn() : void
    {
        $game = $this->_regularGame();

        $this->assertEquals($game->status(), "The game is on");
    }

    public function testIsNoMoreTour() : void
    {
        $game = $this->_noBoardGame();
        $board = $this->createMock(Board::class);
        $board->method('getBoard')->willReturn([
            [ 'o', 'o', 'x' ],
            [ 'x', 'o', 'o' ],
            [ 'o', 'x', 'x' ]
        ]);
        $board->method('getBoxCount')->willReturn(9);
        $game->setBoard($board);

        $game->makeMove(1, 1, $this->playerOne);
        $game->makeMove(1, 2, $this->playerTwo);
        $game->makeMove(2, 1, $this->playerOne);
        $game->makeMove(3, 1, $this->playerTwo);
        $game->makeMove(2, 2, $this->playerOne);
        $game->makeMove(2, 3, $this->playerTwo);
        $game->makeMove(3, 2, $this->playerOne);
        $game->makeMove(3, 3, $this->playerTwo);
        $game->makeMove(1, 3, $this->playerOne);

        $player = $game->whichPlayer();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("There is no more tour");

        $game->makeMove(2, 3, $player);
    }

    public function testIsDraw() : void
    {
        $game = $this->_noBoardGame();
        $board = $this->createMock(Board::class);
        $board->method('getBoard')->willReturn([
            [ 'o', 'o', 'x' ],
            [ 'x', 'o', 'o' ],
            [ 'o', 'x', 'x' ]
        ]);
        $board->method('getBoxCount')->willReturn(9);
        $game->setBoard($board);

        $game->makeMove(1, 1, $this->playerOne);
        $game->makeMove(1, 2, $this->playerTwo);
        $game->makeMove(2, 1, $this->playerOne);
        $game->makeMove(3, 1, $this->playerTwo);
        $game->makeMove(2, 2, $this->playerOne);
        $game->makeMove(2, 3, $this->playerTwo);
        $game->makeMove(3, 2, $this->playerOne);
        $game->makeMove(3, 3, $this->playerTwo);
        $game->makeMove(1, 3, $this->playerOne);

        $this->assertEquals($game->status(), "It's draw");
    }

    public function testIsWinner() : void
    {
        $game = $this->_noBoardGame();
        $board = $this->createMock(Board::class);
        $board->method('getBoard')->willReturn([
            [ 'o', 'o', 'x' ],
            [ 'x', 'o', 'x' ],
            [ 'o', 'x', 'o' ]
        ]);
        $board->method('getBoxCount')->willReturn(9);
        $game->setBoard($board);

        $game->makeMove(1, 1, $this->playerOne);
        $game->makeMove(1, 2, $this->playerTwo);
        $game->makeMove(2, 1, $this->playerOne);
        $game->makeMove(3, 1, $this->playerTwo);
        $game->makeMove(2, 2, $this->playerOne);
        $game->makeMove(2, 3, $this->playerTwo);
        $game->makeMove(3, 3, $this->playerOne);
        $game->makeMove(3, 2, $this->playerTwo);
        $game->makeMove(1, 3, $this->playerOne);
        
        $name = $this->playerTwo->getName();
        $this->assertEquals($game->status(), "$name wins!!!");
    }

    private function _singlePlayerGame() : Game
    {
        $game = new Game();
        $game->setBoard($this->board);
        $game->addPlayer($this->playerOne);

        return $game;
    }

    private function _noBoardGame() : Game
    {
        $game = new Game();
        $game->addPlayer($this->playerOne);
        $game->addPlayer($this->playerTwo);

        return $game;
    }

    private function _regularGame() : Game
    {
        $game = new Game();
        $game->setBoard($this->board);
        $game->addPlayer($this->playerOne);
        $game->addPlayer($this->playerTwo);

        return $game;
    }
}