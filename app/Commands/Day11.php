<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Day11 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day11 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 11';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        $stones = explode(" ", $puzzle[0]);

        foreach ($stones as $k=>$v) {
            $stones[$k] = intval($v);
        }

        for ($blink = 0; $blink < 25; $blink++) {
            foreach ($stones as $k=>$v) {
                if ($v == 0) {
                    // Stone has a 0 on it.  Change it to 1.
                    $stones[$k] = 1;
                } else if((strlen((string)$v) % 2) == 0) {
                    // Number on the stone has an even number of digits
                    // Get the left half of the digits
                    $l = strlen((string)$v);
                    $stones[$k] = intval(substr((string)$v, 0, $l/2));
                    // Make a new stone with the right half of the digits
                    $stones[] = intval(substr((string)$v, $l/2, $l/2));
                } else {
                    // No other rules apply.  Multiply by 2024
                    $stones[$k] = $v*2024;
                }
            }
        }
        $this->info("There are " . count($stones));
    }
}
