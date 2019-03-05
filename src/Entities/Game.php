<?php

namespace App\Entities;

use App\Utils\BoardAnalyzer;

class Game extends Entity
{
    private $board;
    private $players = [];
    private $lastPlayer;
    private $winner;
    private $moves = 0;

    public function setBoard(Board $board) : void
    {
        $this->board = $board;
    }

    public function addPlayer(Player $player) : void
    {   
        if (count($this->players) >= 2) {
            throw new \Exception("There is no more place");
        }

        foreach ($this->players as $existPlayer) {
            if ($existPlayer == $player) {
                throw new \Exception("This player is already in the game");
            }
        }

        $this->players[] = $player;
    }

    public function makeMove(int $posX, int $posY, Player $player) : void
    {
        $this->_checkGame();

        if ($this->lastPlayer == $player) {
            throw new \Exception("Is no your tour now");
        }

        if ($this->moves >= $this->board->getBoxCount()) {
            throw new \Exception("There is no more tour");
        }

        $this->board->setMark($posX, $posY, $player->getMark());

        $this->lastPlayer = $player;

        $this->moves++;
    }

    public function whichPlayer() : Player
    {
        $resultPlayer = null;

        foreach ($this->players as $player) {
            if ($player != $this->lastPlayer) {
                $resultPlayer = $player;
                break;
            }
        }

        return $resultPlayer;
    }

    public function status() : string
    {
        if ($this->winner) {
            $name = $this->winner->getName();
            return "$name wins!!!";
        }

        if ($this->moves >= $this->board->getBoxCount()) {
            return 'It\'s draw';
        }

        return 'The game is on';
    }

    private function _checkGame() : void
    {
        if (!$this->board) {
            throw new \Exception("There is no board in the game");
        }

        if (count($this->players) < 2) {
            throw new \Exception("There is not enough players in the game");
        }

        $board = $this->board->getBoard();
        $result = BoardAnalyzer::analyze($board);

        if ($result != null) {
            foreach ($this->players as $player) {
                if ($player->getMark()->getChar() == $result) {
                    $this->winner = $player;
                }
            }
        }
    }
}