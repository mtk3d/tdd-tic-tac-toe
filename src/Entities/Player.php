<?php

namespace App\Entities;

class Player extends Entity
{
    private $name;
    private $mark;

    public function __construct(string $name, Mark $mark)
    {
        $this->name = $name;
        $this->mark = $mark;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getMark() : Mark
    {
        return $this->mark;
    }
}