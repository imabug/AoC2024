<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Day14 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day14 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code Day 14';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Evade bathroom guarding robots
        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        // Puzzle space is a 101x103 tile space
        $nRow = 103;
        $nCol = 101;
        // Initialize the puzzle space.  Each
        // element of the puzzle space holds the number
        // of robots in that tile
        for ($i=0;$i<$nCol; $i++) {
            for ($j=0;$j<$nRow;$j++) {
                $hallway[$i][$j] = 0;
            }
        }

        // Parse the input file.
        // The $robots array will contain the velocity vector
        // for each robot
        $i = 0;
        while (count($puzzle) > 0) {
            // Each puzzle line consists of a
            // robot position given by p=x,y
            // and the robot velocity given by v=x,y
            $match[] = preg_match_all('/\d+/', array_shift($puzzle), $match);
            $x = intval($match[0][0]);
            $y = intval($match[0][1]);
            $vx = intval($match[0][2]);
            $vy = intval($match[0][3]);
            // Position the robot
            $hallway[$x][$y]++;
            $robot[] = ["x" => $x, // Robot's current x/y position
                        "y" => $y,
                        "vx" => $vx, // Robot's velocity vector
                        "vy" => $vy];
        }

        // Move the robots for 100 seconds
        for ($t = 0; $t < 100; $t++) {
            // Move each robot
            foreach ($robot as $r => $v) {
                // Get the robot's current position and
                // Calculate the new location
                $oldx = $robot[$r]["x"];
                $oldy = $robot[$r]["y"];
                $vx = $robot[$r]["vx"];
                $vy = $robot[$r]["vy"];
                $newx = $oldx + $vx;
                $newy = $oldy + $vy;
                // Check if the robot has gone off any of the edges
                if ($newx < 0) {
                    // Off the left edge of the hall.
                    // Wrap around to the right side
                    $newx = $oldx + $vx + ($nCol-1);
                }
                if ($newx >= $nCol) {
                    // Off the right edge of the hall.
                    // Wrap around to the left side
                    $newx = $oldx + $vx - ($nCol - 1);
                }
                if ($newy < 0) {
                    // Off the top edge of the hall
                    // Wrap around to the bottom side.
                    $newy = $oldy + $vy + ($nRow-1);
                }
                if ($newy >= $nRow) {
                    // Off the bottom edge of the hall.
                    // Wrap around to the top side
                    $newy = $oldy + $vy - ($nCol - 1);
                }
                // Remove the robot from the original spot
                $hallway[$oldx][$oldy]--;
                // Add the robot to the new spot
                $hallway[$newx][$newy]++;
                // Update the robot's position
                $robot[$r] = ["x" => $newx,
                              "y" => $newy,
                              "vx" => $vx,
                              "vy" => $vy];
            }
        }
        // Calculate safety factor
        $nRobots = ["Q1" => 0, // Top left quadrant
                    "Q2" => 0, // Top right quadrant
                    "Q3" => 0, // Bottom left quadrant
                    "Q4" => 0]; // Bottom right quadrant
        for ($i = 0; $i < ($nCol - 1)/2; $i++) {
            for ($j = 0; $j < ($nRow - 1)/2; $j++) {
                $nRobots["Q1"] += $hallway[$i][$j];
                $nRobots["Q2"] += $hallway[$i+($nCol - 1)/2+1][$j];
                $nRobots["Q3"] += $hallway[$i][$j+($nRow-1)/2+1];
                $nRobots["Q4"] += $hallway[$i+($nCol-1)/2+1][$j+($nRow-1)/2+1];
            }
        }
        $this->info("Safety factor: " . array_product($nRobots));
    }
}
