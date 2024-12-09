<?php

namespace App\Commands;

use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class Day8 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day8 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 8';

    /**
     * Size of the puzzle matrix
     *
     * @var int
     */
    protected int $nRow = 0;
    protected int $nCol = 0;

    /**
     * Array of antenna locations
     *
     * @var Collection
     */
    protected Collection $antennaLoc;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);
        $this->nRow = count($puzzle);
        $this->nCol = strlen($puzzle[0]);

        // Convert to a regular 2D matrix
        foreach ($puzzle as $row) {
            $puzzle_matrix[] = str_split($row, 1);
        }

        // Find the locations of each antenna
        $this->antennaLoc = collect([]);
        for ($i = 0; $i < $this->nRow; $i++) {
            for ($j = 0; $j < $this->nCol; $j++) {
                // Initialize a map of antinodes (part 1) and resonant antinodes (part 2)
                $antinodeMap[$i][$j] = ".";
                $resMap[$i][$j] = ".";
                if ($puzzle_matrix[$i][$j] != ".") {
                    $this->antennaLoc->push([
                        "f" => $puzzle_matrix[$i][$j],
                        "x" => $i,
                        "y" => $j]);
                }
            }
        }

        // Group the collection of antenna locations by frequency
        $this->antennaLoc = $this->antennaLoc->groupBy('f');
        // Iterate through each frequency
        foreach ($this->antennaLoc as $freq => $locations) {
            $n = $locations->count();
            $l = $locations->toArray();
            for ($i = 0; $i < $n-1; $i++) {
                for ($j = $i+1; $j <= $n-1; $j++) {
                    $r1 = $l[$i]['x'];
                    $c1 = $l[$i]['y'];
                    $r2 = $l[$j]['x'];
                    $c2 = $l[$j]['y'];

                    // Calculate the antinode location
                    $r = 2*$r1-$r2;
                    $c = 2*$c1-$c2;

                    // Figure out if the coordinates are still within the map.
                    $stillInMap = ($r >= 0) && ($r < $this->nRow) && ($c >= 0) && ($c < $this->nCol);

                    if ($stillInMap) {
                        $antinodeMap[$r][$c] = '#';
                    }
                    $r = 2*$r2-$r1;
                    $c = 2*$c2-$c1;
                    $stillInMap = ($r >= 0) && ($r < $this->nRow) && ($c >= 0) && ($c < $this->nCol);
                    if ($stillInMap) {
                        $antinodeMap[$r][$c] = '#';
                    }
                }
            }

            // Part 2: Look for resonant harmonic antinodes
            for ($i = 0; $i < $n-1; $i++) {
                for ($j = $i+1; $j <= $n-1; $j++) {
                    $r1 = $l[$i]['x'];
                    $c1 = $l[$i]['y'];
                    $r2 = $l[$j]['x'];
                    $c2 = $l[$j]['y'];
                    $dr = $r2 - $r1;
                    $dc = $c2 - $c1;

                    $r = $r2;
                    $c = $c2;
                    while (($r >= 0) && ($r < $this->nRow) && ($c >= 0) && ($c < $this->nCol)) {
                        $r -= $dr;
                        $c -= $dc;
                        $stillInMap = ($r >= 0) && ($r < $this->nRow) && ($c >= 0) && ($c < $this->nCol);

                        if ($stillInMap) {
                            $resMap[$r][$c] = '#';
                        }
                    }
                    $r = $r1;
                    $c = $c1;
                    while (($r >= 0) && ($r < $this->nRow) && ($c >= 0) && ($c < $this->nCol)) {
                        $r += $dr;
                        $c += $dc;
                        $stillInMap = ($r >= 0) && ($r < $this->nRow) && ($c >= 0) && ($c < $this->nCol);

                        if ($stillInMap) {
                            $resMap[$r][$c] = '#';
                        }
                    }
                }
            }
        }
        // Count up all the #s
        $n = 0;
        $r = 0;
        for ($i = 0; $i < $this->nRow; $i++) {
            for ($j = 0; $j < $this->nCol; $j++) {
                if ($antinodeMap[$i][$j] == "#") $n++;
                if ($resMap[$i][$j] == "#") $r++;
            }
        }
        $this->info("There are " . $n . " antinodes");
        $this->info("There are ".$r." resonant antinodes");
    }
}
