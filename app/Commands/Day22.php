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
            $t = array_pop($puzzle);
            // Calculate the 2000th secret number
            for ($i = 0; $i < 2000; $i++) {
                $s1 = (($s << 6) ^ $s) % 16777216;
                $s2 = (($s1 >> 5) ^ $s1) % 16777216;
                $s3 = (($s2 << 11) ^ $s2) % 16777216;
                $s = $s3;

                $t1 = (($t << 6) ^ $t) % 16777216;
                $t2 = (($t1 >> 5) ^ $t1) % 16777216;
                $t3 = (($t2 << 11) ^ $t2) % 16777216;
                $t = $t3;
            }
            $sum = $sum + $s3 + $t3;
        }
        $this->info("Sum: " . $sum);
    }
}
