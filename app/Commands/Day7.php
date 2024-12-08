<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Day7 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day7 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 7';

    private function canObtain(int $result, array $terms): bool
    {
        if (count($terms) == 1) {
            return $result == $terms[0];
        }
        $lastTerm = array_pop($terms);
        if (($result % $lastTerm == 0) and $this->canObtain($result / $lastTerm, $terms)) {
            return true;
        }
        if ($result > $lastTerm and $this->canObtain($result - $lastTerm, $terms)) {
            return true;
        }
        return false;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        // Parse the input file.
        // First value is the equation result.
        // The remaining values after the : are the equation terms
        // Figure out what combination of '+' and '*' operators
        // gives the result value.

        $calSum = 0;
        foreach ($puzzle as $row) {
            // Get the result and terms from each line.
            list($result, $terms) = explode(": ", $row);
            // Convert the terms into an array of individual values
            $terms = explode(" ", $terms);
            if ($this->canObtain($result, $terms)) {
                $calSum += $result;
            }
        }
        $this->info("Total calibration result is " . $calSum);
    }
}
