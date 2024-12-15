<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Day15 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day15 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 15';

    private function move_up(&$robot, &$warehouse): void
    {
        return;
    }

    private function move_down(&$robot, &$warehouse): void
    {
        return;
    }

    private function move_left(&$robot, &$warehouse): void
    {
        return;
    }

    private function move_right(&$robot, &$warehouse): void
    {
        return;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lantern fish warehouse woes
        // Variant of a Sokobahn type puzzle
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        // Input file has two parts separated by a blank line.
        // Top part is a map of the warehouse.
        // Warehouse is a 50x50 grid.  Outside border of the grid are the walls.
        // Starting position of the robot is in the middle (25,25).
        // # - walls
        // O - boxes that can be moved
        // Bottom part are the warehouse robot's moves.
        // ^ - up
        // v - down
        // < - left
        // > - right

        // Warehouse map
        foreach ($puzzle as $r) {
            if ($r == "") {
                // End of the warehouse map.  Skip the newline and exit the loop
                array_shift($puzzle);
                break;
            }
            $warehouse[] = str_split(array_shift($puzzle), 1);
        }
        // Combine the rest of the file into one long string.
        $moves = "";
        foreach ($puzzle as $r) {
            $moves .= array_shift($puzzle);
        }
        // Turn it into an array we can step through
        $moves = str_split($moves, 1);

        // Robot's starting position
        $robot = ["x" => 24,
                  "y" => 24];

        // Step through each element of the moves array
        while (count($moves) > 0) {
            switch (array_shift($moves)) {
                case '^':
                    $this->move_up($robot, $warehouse);
                    break;
                case 'v':
                    $this->move_down($robot, $warehouse);
                    break;
                case '<':
                    $this->move_left($robot, $warehouse);
                    break;
                case '>':
                    $this->move_right($robot, $warehouse);
                    break;
            }
        }
    }
}
