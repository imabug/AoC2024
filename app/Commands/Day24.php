<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Day24 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day24 {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code 2024 Day 24';

    private function gateOp(int $g1, string $op, int $g2): int
    {
        // Perform the gate operation

        switch ($op) {
            case "AND":
                return $g1 & $g2;
                break;
            case "OR":
                return $g1 | $g2;
                break;
            case "XOR":
                return $g1 ^ $g2;
                break;
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fruit monitoring device
        // Input file has two parts.
        // First part is a list of input gates and their initial state (0 or 1).
        // Second part is a list of operations in the form a op b -> c
        // where a, b, and c are different gate identifiers and op is a
        // boolean logic operation (AND, OR, XOR)

        $puzzle = file($this->argument('data'), FILE_IGNORE_NEW_LINES);

        $gates = [];

        // Parse the first part of the input file.
        while (($a = array_shift($puzzle)) != "") {
            list($g, $v) = explode(": ", $a);
            $gates[$g] = (int)$v;
        }

        // Parse the list of operations
        while (count($puzzle) > 0) {
            $a = array_shift($puzzle);
            list($o, $g) = explode(" -> ", $a);
            $gates[$g] = null;
            list($g1, $op, $g2) = explode(" ", $o);
            $ops[$g] = ["g1" => $g1,
                        "op" => $op,
                        "g2" => $g2];
        }

        // Keep looping through the $gates array until there are no more
        // null values
        while (in_array(null, $gates, true)) {
            // Go through each element of the $ops array
            foreach ($ops as $g => $v) {
                // If the current value of gate $g is null, see if we can process it
                // otherwise, it already has a value and we don't need to do anything with it.
                if ($gates[$g] == null) {
                    // If the two gates have values, carry out the operation
                    if (!is_null($gates[$v["g1"]]) && !is_null($gates[$v["g2"]])) {
                        $gates[$g] = $this->gateOp($gates[$v["g1"]], $v["op"], $gates[$v["g2"]]);
                    }
                }
            }
        }

        // Get all the z gates
        // Sort the gates array
        uksort($gates, "strnatcmp");
        // Slice off the z gates
        $z = array_slice($gates, -46, 46, true);
        // echo out the binary number formed by the z gates
        echo(strrev(implode("", $z)));
        // End result is 1101000001011001011111011001000100001001110000
    }
}
