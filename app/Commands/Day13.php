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
    }
}
