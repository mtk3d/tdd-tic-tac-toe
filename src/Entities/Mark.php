<?php

namespace App\Entities;

class Mark extends Entity
{
    const CIRCLE = 'o';
    const SHARP  = 'x';

    private $char;

    public function __construct($char)
    {
        $this->char = $char;
    }

    public function getChar() : string
    {
        return $this->char;
    }
}