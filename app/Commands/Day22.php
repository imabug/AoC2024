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

    // Solve the puzzle using brute force by calculating
    // 2000 secret numbers for each starting number
    public function bruteForce(array $puzzle): int
    {
        // Brute force calculation
        $sum = 0;

        while (count($puzzle) > 0) {
            $s = array_pop($puzzle);
            for ($i = 0; $i < 2000; $i++) {
                $s1 = (($s * 64) ^ $s) % 16777216;
                $s2 = (($s1 / 32) ^ $s1) % 16777216;
                $s3 = (($s2 * 2048) ^ $s2) % 16777216;
                $s = $s3;
            }
            $sum += $s3;
        }
        return $sum;
    }

    // Solve the puzzle by working on two numbers at a time
    public function bruteForceUnroll(array $puzzle): int
    {
        $sum = 0;
        while (count($puzzle) > 0) {
            $s = array_pop($puzzle);
            $t = array_pop($puzzle);
            for ($i = 0; $i < 2000; $i++) {
                $s1 = (($s * 64) ^ $s) % 16777216;
                $s2 = (($s1 / 32) ^ $s1) % 16777216;
                $s3 = (($s2 * 2048) ^ $s2) % 16777216;
                $s = $s3;

                $t1 = (($t * 64) ^ $t) % 16777216;
                $t2 = (($t1 / 32) ^ $t1) % 16777216;
                $t3 = (($t2 * 2048) ^ $t2) % 16777216;
                $t = $t3;
            }
            $sum = $sum + $s3 + $t3;
        }
        return $sum;
    }

    // Solve the puzzle by 1 unroll of the inner loop
    // and working on two numbers at a time
    public function bruteForceInnerUnroll(array $puzzle): int
    {
        $sum = 0;
        while (count($puzzle) > 0) {
            $s = array_pop($puzzle);
            $t = array_pop($puzzle);
            for ($i = 0; $i < 1000; $i++) {
                $s1 = (($s * 64) ^ $s) % 16777216;
                $s2 = (($s1 / 32) ^ $s1) % 16777216;
                $s3 = (($s2 * 2048) ^ $s2) % 16777216;
                $s = $s3;
                $s1 = (($s * 64) ^ $s) % 16777216;
                $s2 = (($s1 / 32) ^ $s1) % 16777216;
                $s3 = (($s2 * 2048) ^ $s2) % 16777216;
                $s = $s3;

                $t1 = (($t * 64) ^ $t) % 16777216;
                $t2 = (($t1 / 32) ^ $t1) % 16777216;
                $t3 = (($t2 * 2048) ^ $t2) % 16777216;
                $t = $t3;
                $t1 = (($t * 64) ^ $t) % 16777216;
                $t2 = (($t1 / 32) ^ $t1) % 16777216;
                $t3 = (($t2 * 2048) ^ $t2) % 16777216;
                $t = $t3;
            }
            $sum = $sum + $s3 + $t3;
        }
        return $sum;
    }

    // Solve the puzzle using bit shift operations
    // and working on two starting numbers at a time.
    public function bitShiftUnroll(array $puzzle): int
    {
        $sum = 0;
        while (count($puzzle) > 0) {
            $s = array_pop($puzzle);  // Get a secret number
            $t = array_pop($puzzle);  // Get another secret number
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
        return $sum;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Monkey Exchange Market
        // Input file consists of 1862 initial secret numbers
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        $start = microtime(true);
        $this->info("Sum: " . $this->bruteForce($puzzle));
        $end = microtime(true);
        $this->info("Brute force took " . ($end - $start) . " seconds");

        $start = microtime(true);
        $this->info("Sum: " . $this->bruteForceUnroll($puzzle));
        $end = microtime(true);
        $this->info("Brute force with 2 numbers at a time took " . ($end - $start) . " seconds");

        $start = microtime(true);
        $this->info("Sum: " . $this->bruteForceInnerUnroll($puzzle));
        $end = microtime(true);
        $this->info("Brute force with 2 numbers at a time unrolling the inner loop took " . ($end - $start) . " seconds");

        $start = microtime(true);
        $this->info("Sum: " . $this->bitShiftUnroll($puzzle));
        $end = microtime(true);
        $this->info("Brute force bit shifting took " . ($end - $start) . " seconds");

}
}
