<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Day22 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day22 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code Day 22';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Monkey Exchange Market
        // Input file consists of 1862 initial secret numbers
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        $sum = 0;
        while (count($puzzle) > 0) {
            $s = array_pop($puzzle);
            // Calculate the 2000th secret number
            for ($i = 0; $i < 2000; $i++) {
                $s1 = (($s * 64) ^ $s) % 16777216;
                $s2 = (($s1 / 32) ^ $s1) % 16777216;
                $s3 = (($s2 * 2048) ^ $s2) % 16777216;
                $s = $s3;
            }
            $sum += $s3;
        }
        $this->info("Sum: " . $sum);
    }
}
