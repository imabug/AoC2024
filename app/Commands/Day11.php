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

        $s = [];
        foreach ($stones as $k=>$v) {
            // Store the stones in an array with the stone's value as the key
            // and the number of stones as the value
            $s[$v] = 1;
        }

        // Plutonian pebbles
        // Rules:
        // 1. Stone value = 0: Replace with 1.  No new stone is created.
        // 2. Stone has even number of digits: Replace with 2 stones.
        // 3. Rules 1 and 2 don't apply.  Multiply stone value by 2024.  No new stone is created.

        for ($blink = 1; $blink <= 75; $blink++) {
            foreach ($s as $k=>$v) {
                if ($k == 0) {
                    // Rule 1.  Replace the $v 0 stones with $v 1 stones
                    // Replace all the 0 stones with 1
                    if (array_key_exists(1, $s)) {
                        $s[1] += $v;
                        $s[0] -= $v;
                    } else {
                        $s[1] = $v;
                        $s[0] -= $v;
                    }
                } else if ((strlen((string)$k) % 2) == 0) {
                    // Number has an even number of digits
                    // There are $v stones with the number $k on them
                    $l = strlen((string)$k);  // Number of digits
                    // Left half of the number
                    $left = intval(substr((string)$k, 0, $l/2));
                    // Right half of the number
                    $right = intval(substr((string)$k, $l/2, $l/2));
                    if (array_key_exists($left, $s)) {
                        // If a stone with the left number exists,
                        // add $v more of them
                        $s[$left] += $v;
                    } else {
                        // Create $v new stones
                        $s[$left] = $v;
                    }
                    if (array_key_exists($right, $s)) {
                        // If a stone with the right number exists,
                        // Add $v more of them
                        $s[$right] += $v;
                    } else {
                        // Create $v new stones
                        $s[$right] = $v;
                    }
                    // Remove the $v stones with the number $k on them
                    $s[$k] -= $v;
                } else {
                    if (array_key_exists($k*2024, $s)) {
                        // If a stone with the number $k*2024 exists,
                        // Add $v more of them
                        $s[$k*2024] += $v;
                        // Remove the $v stones with $k on them
                        $s[$k] -=$v;
                    } else {
                        // Create $v new stones
                        $s[$k*2024] = $v;
                        $s[$k] -= $v;
                    }
                }
            }
            if ($blink == 25) {
                $this->info("There are " . array_sum($s) . " stones after 25 blinks.");
            }
        }
        $this->info("There are " . array_sum($s) . " stones after 75 blinks");
        // Brute force approach.  Works, but doesn't scale well.
        // for ($blink = 0; $blink < 75; $blink++) {
        //     foreach ($stones as $k=>$v) {
        //         if ($v == 0) {
        //             // Stone has a 0 on it.  Change it to 1.
        //             $stones[$k] = 1;
        //         } else if((strlen((string)$v) % 2) == 0) {
        //             // Number on the stone has an even number of digits
        //             // Get the left half of the digits
        //             $l = strlen((string)$v);
        //             $stones[$k] = intval(substr((string)$v, 0, $l/2));
        //             // Make a new stone with the right half of the digits
        //             $stones[] = intval(substr((string)$v, $l/2, $l/2));
        //         } else {
        //             // No other rules apply.  Multiply by 2024
        //             $stones[$k] = $v*2024;
        //         }
        //     }
        //     if ($blink == 24) {
        //         $this->info("There are " . count($stones) . " stones after 25 blinks");
        //     }
        //     $this->info("Blink: " . $blink);
        // }
        // $this->info("There are " . count($stones) . " stones after 75 blinks");
    }
}
