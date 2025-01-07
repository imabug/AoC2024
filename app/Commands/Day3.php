<?php

namespace App\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Day3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day3 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Sum of all the multiplications
     *
     * @var int
     */
    protected $multsum;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Part 1: Parse the data file for mul(x,y)
        $f = fopen($this->argument('data'), 'r');

        $matches = array();
        $this->multsum = 0;
        while (($l = fgets($f)) !== false) {
            // Find all the matches for mul(x,y)
            $nMatches = preg_match_all('/mul\(\d+,\d+\)/', $l, $matches);

            $matches = collect($matches[0]);

            $products = $matches->map(function (string $item) {
                // Parse out the two values in the mul() function.
                $s = Str::trim($item, "mul()");
                // Get the two numbers as a collection
                $nums = Str::of($s)->explode(',');
                // Convert the collection elements to integers
                $nums->transform(function (string $s) {
                    return intval($s);
                });
                return $nums[0] * $nums[1];
            });
            $this->multsum += $products->sum();
        }
        $this->info('Sum of all the multiplications is ' . $this->multsum);
    }
}
