<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Day1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day1 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load and process the data for AoC Day 1';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Part 1: Distance between lists
        $f = fopen($this->argument('data'), 'r');

        while (($l = fgets($f)) !== false) {
            list($l_item, $r_item) = explode("   ", $l);
            $l_list[] = (int) $l_item;
            $r_list[] = (int) $r_item;
        }

        sort($l_list);
        sort($r_list);

        $diff = 0;
        $n = count($l_list);
        for ($i = 0; $i < $n; $i++) {
            $diff += abs($l_list[$i] - $r_list[$i]);
        }

        $this->info('The total distance between the lists is ' . $diff);

        // Part 2: Similarity score
        $simScore = 0;
        foreach ($l_list as $v) {
            $simScore += $v * count(array_keys($r_list, $v));
        }

        $this->info('The similarity score is ' . $simScore);

        return 1;
    }
}
