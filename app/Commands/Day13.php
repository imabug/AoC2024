<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use MCordingley\LinearAlgebra\Matrix;

class Day13 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day13 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 13';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Claw game
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        // Each group in the puzzle input is three lines
        // First line gives number of units the claw will move when A is pushed
        // Second line gives number of units the claw will move when B is pushed
        // Third line gives the prize location.
        // Groups are separated by newlines.

        // Use a matrix math approach
        // M = [[Ax Bx]  Movement A and B buttons
        //      [Ay By]]
        // P = [Px Py] prize position
        // M*N = P where N is the number of button presses for A and B
        // N = inv(M)*P
        // so N can be calculated by determining the inverse of M and then
        // matrix multiplication with P

        $tokens = 0;
        $nPrizes = 0;
        $corrTokens = 0; // Count tokens for part 2
        $corrPrizes = 0; // Count prizes for part 2
        while (count($puzzle) > 0) {
            // Get Button A line
            $a = array_shift($puzzle);
            // Tack on the Button B line
            $a .= array_shift($puzzle);
            // Get Prize line
            $prize = array_shift($puzzle);
            // Skip the blank line
            array_shift($puzzle);

            // Get the Button A and B movements
            $match[] = preg_match_all('/\d+/', $a, $match);
            $ax = intval($match[0][0]); // Ax
            $ay = intval($match[0][1]); // Ay
            $bx = intval($match[0][2]); // Bx
            $by = intval($match[0][3]); // By

            // If the determinant of the matrix != 0, the
            // matrix can be inverted and there's a solution
            $det = ($ax*$by) - ($bx*$ay);
            if ($det != 0) {
                // Get the prize coordinates
                $match[] = preg_match_all('/\d+/', $prize, $match);
                $px = intval($match[0][0]); // Px
                $py = intval($match[0][1]); // Py
                // Calculate the number of A and B button presses
                // $x = intval(($px*$by - $py*$bx)/$det); // A button presses
                // $y = intval((-$px*$ay + $py*$ax)/$det); // B button presses
                $x = ($px*$by - $py*$bx)/$det;
                $y = (-$px*$ay + $py*$ax)/$det;

                // Don't count solutions that require:
                // 1. negative number of button presses
                // 2. more than 100 button presses
                // 3. non-integer number of button presses
                if (($x > 0 && $x <= 100 && is_int($x)) && ($y > 0 && $y <= 100 && is_int($y))) {
                    $nPrizes++; // Won a prize!
                    $tokens += $x*3 + $y;
                }

                // Part 2: Prize location coordinates are off by 10000000000000
                // in each direction
                $px += 10000000000000;
                $py += 10000000000000;
                $x = ($px*$by - $py*$bx)/$det;
                $y = (-$px*$ay + $py*$ax)/$det;
                // Don't exclude solutions with more than 100 button presses
                if (($x > 0 && is_int($x)) && ($y > 0 && is_int($y))) {
                    $corrPrizes++; // Won a prize!
                    $corrTokens += $x*3 + $y;
                }
            }
        }
        $this->info("Won " . $nPrizes . " prizes!");
        $this->info("Had to spend " . $tokens . " to win the prizes.");
        $this->info("Won " . $corrPrizes . " prizes with adjusted prize locations.");
        $this->info("Had to spend " . $corrTokens . " to win the prizes.");
    }
}
