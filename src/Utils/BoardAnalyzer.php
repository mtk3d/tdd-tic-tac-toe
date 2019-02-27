<?php

namespace App\Utils;

class BoardAnalyzer
{
    public static function analyze(array $board)
    {
        // Rotate array 90deg
        $rotateBoard = call_user_func_array(
            'array_map',
            array(-1 => null) + array_map('array_reverse', $board)
        );

        // Check horizontal
        foreach ($board as $line) {
            if (count(array_unique($line)) == 1) {
                return $line[0];
            }
        }

        // Check vertical
        foreach ($rotateBoard as $column) {
            if (count(array_unique($column)) == 1) {
                return $column[0];
            }
        }

        // Check diagonal
        $diagonal = self::checkDiagonal($board);
        if ($diagonal) {
            return $diagonal;
        }

        $rotateDiagonal = self::checkDiagonal($rotateBoard);
        if ($rotateDiagonal) {
            return $rotateDiagonal;
        }

        return null;
    }

    private static function checkDiagonal($board)
    {
        $vertical = count($board);
        $horizontal = count($board[0]);
        $elements = min($vertical, $horizontal);

        $lastElement = $board[0][0];
        $hasDiagonal = true;
        for ($i = 0; $i < $elements; $i++) {
            if ($lastElement != $board[$i][$i]) {
                $hasDiagonal = false;
            }
        }

        if ($hasDiagonal) {
            return $lastElement;
        }

        return null;
    }
}