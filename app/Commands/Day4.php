<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Day4 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day4 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 4';

    /**
     * Number of 'XMAS' or 'SAMX' strings found
     *
     * @var int
     */
    protected $nXmas = 0;

    // Search the array.  Return the number of 'XMAS'
    // and 'SAMX' strings found
    private function xmasSearch(array $ws): int
    {
        $n = 0;
        foreach ($ws as $r) {
            // Look for XMAS
            $n += preg_match_all("/XMAS/", $r, $matches);

            // Look for SAMX
            $n += preg_match_all("/SAMX/", $r, $matches);
        }

        return $n;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Day 4: Word search puzzle
        // Load the whole input file
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        // Convert to a regular 2D array.
        foreach ($puzzle as $row)
        {
            $puzzle_array[] = str_split($row, 1);
        }

        // Get the size of the puzzle.  Assume each row is the same length.
        $nRow = count($puzzle);
        $ncol = strlen($puzzle[0]);

        // Search each array element for the strings 'XMAS' or 'SAMX'
        $this->nXmas += $this->xmasSearch($puzzle);

        // Transpose the array
        for ($r = 0; $r < $nRow; $r++) {
            for ($c = 0; $c < $nCol; $c++) {
                $puzzle_array_t[$c][$r] = $puzzle_array[$r][$c];
            }
        }
        // Merge the rows of the transposed puzzle back into a single string.
        foreach ($puzzle_array_t as $r)
        {
            $puzzle_t[] = implode($r);
        }
        // Search the transposed array.
        $this->nXmas += $this->xmasSearch($puzzle_t);

        // Map the diagonals to an array
    }

}
