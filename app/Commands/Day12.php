<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Day12 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day12 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 12';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Garden fences
        // Calculate the area and perimeter of each garden
        // plot identified by a letter.
        // Load the whole input file
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        // Turn the data input into a 2D array
        foreach ($puzzle as $row) {
            $puzzle_array[] = str_split($row, 1);
        }
        $nRow = count($puzzle);
        $nCol = strlen($puzzle[0]);

        $plots = [];
        for ($i = 0; $i < $nRow; $i++) {
            for ($j = 0; $j < $nCol; $j++) {
                $plots[$puzzle_array[$i][$j]][] = [
                            "x" => $i,
                            "y" => $j];
            }
        }
        var_dump($plots);
    }
}
