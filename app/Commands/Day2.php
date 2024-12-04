<?php

namespace App\Commands;

use Illuminate\Support\Collection;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Day2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day2 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Number of safe reports
     *
     * @var int
     */
    protected $safeReports = 0;

    // Decide if the sequence of levels is in descending order.
    // Return 1 if it they are.
    private function isDescending(Collection $r): int
    {
        $descending = 1;
        $n = $r->count();
        for ($i = 0; $i < $n-1; $i++) {
            if ($r[$i] > $r[$i+1]) {
                $descending *= 1;
            }
            if ($r[$i] <= $r[$i+1]) {
                $descending *= 0;
            }
        }
        return $descending;
    }

    // Decide if the sequence of levels is in ascending order.
    // Return 1 if they are.
    private function isAscending(Collection $r): int
    {
        $ascending = 1;
        $n = $r->count();
        for ($i = 0; $i < $n-1; $i++) {
            if ($r[$i] < $r[$i+1]) {
                $ascending *= 1;
            }
            if ($r[$i] > $r[$i+1]) {
                $ascending *= 0;
            }
        }
        return $ascending;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Part 1: Analyze reports
        $f = fopen($this->argument('data'), 'r');

        while (($l = fgets($f)) !== false) {
            $report = collect(explode(" ", $l));
            // Convert the elements in $reports to integers
            $report->transform(function (string $item) {
                return intval($item);
            });
            // If the sequence of levels is not in descending
            // or ascending order, skip the rest of the loop
            if (!$this->isDescending($report) && !$this->isAscending($report)) continue;

            // Chunk the list of reports into pairs
            $reportChunks = $report->sliding(2);

            $isSafe = 1;
            $diffs = $reportChunks->mapSpread(function (int $a, int $b) {
                return $diff = abs($a - $b);
            });
            var_dump($diffs);
            $this->info('Min diff: ' . $diffs->min());
            $this->info('Max diff: ' . $diffs->max());
            if ($diffs->min() >= 1 && $diffs->max() <= 3) {
                $this->safeReports++;
            }
        }
        $this->info('The number of safe reports is ' . $this->safeReports);
    }
}
