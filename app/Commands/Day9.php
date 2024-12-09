<?php

namespace App\Commands;

use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class Day9 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day9 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 9';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        // Puzzle input is a long string of numbers (the disk map).
        // Each pair of numbers represents the number of file blocks
        // occupied and the number of free space blocks.
        // The last number is simply the number of occupied file blocks.
        // Create a collection holding number pairs.
        $diskMap = collect(str_split($puzzle[0], 2));

        // Create a map of the hard drive
        $hardDrive = new Collection;
        $blockId = 0;
        foreach ($diskMap as $item) {
            $d = "";
            $blocks = intval(substr($item, 0, 1));
            $emptySpace = intval(substr($item, 1, 1));
            // Create a string represent the space on the disk
            // Use * for the occupied space and . for the
            // empty space.
            $d = str_pad($d, $blocks, "*");
            $d = str_pad($d, strlen($d)+$emptySpace, ".");
            $hardDrive->put($blockId, $d);
            $blockId++;
        }
        $hardDrive->dump();
    }
}
