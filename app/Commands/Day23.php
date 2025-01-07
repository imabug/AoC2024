<?php

namespace App\Commands;

use Graphp\Graph;
use LaravelZero\Framework\Commands\Command;

class Day23 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day23 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 23';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);
    }
}
