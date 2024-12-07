<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

/**
 * Enum for guard directions
 *
 * @var enum
 */
enum Direction
{
    case UP;
    case DOWN;
    case LEFT;
    case RIGHT;
}

class Day6 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day6 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 6';

    /**
     * Size of the puzzle matrix
     *
     * @var int
     */
    protected int $nRow = 0;
    protected int $nCol = 0;

    /**
     * Current guard position
     *
     * @var array
     */
    protected $guardPos = ["x" => 0, "y" => 0];

    /**
     * An array to hold the i,j index positions of the squares
     * visited by the guard
     *
     * @var array
     */
    protected $guardPositions = array();

    /**
     * Variable to indicate current direction the guard is moving
     *
     * @var enum
     */
    protected Direction $guardDir;

    /**
     * Check to see if the guard is still in the puzzle matrix
     */
    private function stillInMatrix(int $x, int $y): bool
    {
        if (($x >= 0 and $y >= 0) and ($x < $this->nRow and $y < $this->nCol)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Move the guard
     */
    private function moveGuard(Direction $dir): void
    {
        if ($dir == Direction::UP) {
            $this->guardPos["x"] -= 1;
        }
        if ($dir == Direction::DOWN) {
            $this->guardPos["x"] += 1;
        }
        if ($dir == Direction::LEFT) {
            $this->guardPos["y"] -= 1;
        }
        if ($dir == Direction::RIGHT) {
            $this->guardPos["y"] += 1;
        }

        return;
    }

    /**
     * Check what's in the next square
     */
    private function getNextSquare(array $m, Direction $dir): string|bool
    {
        // Get the guard's current position
        $x = $this->guardPos["x"];
        $y = $this->guardPos["y"];

        switch ($dir) {
            case Direction::UP:
                $x--;
                break;
            case Direction::DOWN:
                $x++;
                break;
            case Direction::LEFT:
                $y--;
                break;
            case Direction::RIGHT:
                $y++;
                break;
        }
        if ($this->stillInMatrix($x, $y)) {
            return $m[$x][$y];
        } else {
            return false;
        }
    }

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

        // Find the guard's starting position.  Just brute force
        // through the matrix.
        for ($i = 0; $i < $this->nRow; $i++) {
            for ($j = 0; $j < $this->nCol; $j++) {
                if ($puzzle_matrix[$i][$j] == "^") {
                    $this->guardPos["x"] = $i;
                    $this->guardPos["y"] = $j;
                    $this->guardPositions[] = $i.",".$j;
                    $this->guardDir = Direction::UP;
                }
            }
        }
        $this->info("Found the guard at " . $this->guardPos["x"] . "," . $this->guardPos["y"]);

        // Move the guard
        // Guard moves to the right any time an
        // obstacle ('#') is encountered.
        while ($this->stillInMatrix($this->guardPos["x"], $this->guardPos["y"])) {
            // Check the square the guard will be moving in to
            $s = $this->getNextSquare($puzzle_matrix, $this->guardDir);
            if ($s == "#") {
                // There's an obstacle.  Change direction.
                switch ($this->guardDir) {
                    case Direction::UP:
                        // Was moving up, now move right
                        $this->guardDir = Direction::RIGHT;
                        break;
                    case Direction::RIGHT:
                        // Was moving right, now move down
                        $this->guardDir = Direction::DOWN;
                        break;
                    case Direction::DOWN:
                        // was moving down, now move left
                        $this->guardDir = Direction::LEFT;
                        break;
                    case Direction::LEFT:
                        // was moving left, now move up
                        $this->guardDir = Direction::UP;
                        break;
                }
            } elseif ($s == false) {
                // Next square is off the map.
                break;
            }
            $this->moveGuard($this->guardDir);
            $this->info("Guard moved to " . $this->guardPos["x"] . "," . $this->guardPos["y"]);
            // Update the list of visited positions
            // See if the guard has been here before.
            $needle = $this->guardPos["x"] . "," . $this->guardPos["y"];
            if (!array_search($needle, $this->guardPositions)) {
                // Guard hasn't been here before.  Add it to the list
                $this->guardPositions[] = $needle;
            }
            // Mark the position on the map with an X
            $puzzle_matrix[$this->guardPos["x"]][$this->guardPos["y"]] = "X";
        }
        // Guard has left the building
        // The list of guard positions ended up being off by one from the correct answer.
        $this->info("Guard has visited " . count($this->guardPositions) . " distinct squares.");

        // Count up all the Xs
        // Counting the Xs ended up giving the right answer
        $n = 0;
        for ($i = 0; $i < $this->nRow; $i++) {
            for ($j = 0; $j < $this->nCol; $j++) {
                if ($puzzle_matrix[$i][$j] == "X") $n++;
            }
        }
        $this->info("There are " . $n . " Xs");
    }

}
