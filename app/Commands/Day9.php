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
        // occupied and the number of free space blocks after.
        // The last number is simply the number of occupied file blocks.
        // Create a collection holding number pairs.
        $diskMap = collect(str_split($puzzle[0], 2));

        // Create a map of the hard drive.  Each element of the
        // collection represents a single block and contains a
        // file ID, or "." for an empty space.
        $hardDrive = [];
        $fileId = 0;
        $s = 0;
        foreach ($diskMap as $item) {
            $blocks = intval(substr($item, 0, 1));
            $emptySpace = intval(substr($item, 1, 1));
            for ($i = 0; $i < $blocks; $i++) {
                $hardDrive[] = $fileId;
            }
            for ($i = 0; $i < $emptySpace; $i++) {
                $hardDrive[] = ".";
            }
            $fileId++;
        }

        var_dump($hardDrive);

        $k_last = array_key_last($hardDrive);
        $n = count($hardDrive);
        // Start the decompression
        for ($i = 0; $i < $n; $i++) {
            if ($hardDrive[$i] == ".") {
                // Block isn't a free space.  Keep going.
                // Found a blank block.  Find key of the last non-empty block
                // and swap it with this one
                while ($hardDrive[$k_last] != ".") {
                    $lastFileId = $hardDrive[$k_last];
                    $k_last--;
                }
                $harddrive[$key] = $lastFileId;
                $harddrive[$k_last] = ".";
            }
        }
        var_dump($hardDrive);
    }
}
