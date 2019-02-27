<?php

namespace App\Entities;

class Board extends Entity
{
    private $fields;
    private $horizontal;
    private $vertical;
    private $boxCount;

    public function __construct(int $horizontal, int $vertical)
    {
        $this->fields = array_pad([], $vertical, null);
        foreach ($this->fields as &$field) {
            $field = array_pad([], $horizontal, null);
        }
        $this->horizontal = $horizontal--;
        $this->vertical = $vertical--;
        $this->boxCount = $this->horizontal * $this->vertical;
    }

    public function getBoard() : array
    {
        return $this->fields;
    }

    public function setMark(int $posX, int $posY, Mark $mark)
    {
        $posX--;
        $posY--;

        if ($posX > $this->horizontal || $posY > $this->vertical) {
            throw new \Exception('Mark position is out of range');
        }

        if ($this->fields[$posY][$posX] !== null) {
            throw new \Exception('Mark position is not empty');
        }

        $this->fields[$posY][$posX] = $mark->getChar();
    }

    public function getBoxCount() : int
    {
        return $this->boxCount;
    }
}