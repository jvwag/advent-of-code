<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class Infi
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Infi extends Assignment
{
    public const INPUT_LOCATION = "infi-2018.txt";

    public const CHAR_MAP = [
        // @formatter:off  LEFT   RIGHT  TOP    BOTTOM
        "\u{2550}"     => [true,  true,  false, false], // ═
        "\u{2551}"     => [false, false, true,  true],  // ║
        "\u{2554}"     => [false, true,  false, true],  // ╔
        "\u{2557}"     => [true,  false, false, true],  // ╗
        "\u{255a}"     => [false, true,  true,  false], // ╚
        "\u{255d}"     => [true,  false, true,  false], // ╝
        "\u{2560}"     => [false, true,  true,  true],  // ╠
        "\u{2563}"     => [true,  false, true,  true],  // ╣
        "\u{2566}"     => [true,  true,  false, true],  // ╦
        "\u{2569}"     => [true,  true,  true,  false], // ╩
        "\u{256c}"     => [true,  true,  true,  true],  // ╬
        // @formatter:on
    ];

    private const LEFT = 0;
    private const RIGHT = 1;
    private const TOP = 2;
    private const BOTTOM = 3;


    /**
     * @return array
     */
    public function run(): array
    {
        // convert input
        /** @noinspection PhpUnusedLocalVariableInspection */
        $input = trim($this->getInput());

        // determine height and width of given input
        $h = substr_count($input, "\n") + 1;
        $w = strpos($input, "\n") / 3;

        $nodes = [];

        // split input in chars (input is UTF-8, so 3 bytes for the map chars)
        $grid = str_split(str_replace("\n", "", $input), 3);

        // loop over the grid to find neighbours and create a graph
        foreach ($grid as $i => $c) {
            $nodes[$i] = $this->getNeighbours($grid, $i, $w, $h);
        }

        // determine fastest route between the top right and bottom left (height x width)
        $route = self::bfs_path($nodes, 0, ($w * $h) - 1);

        // print output for debugging
        //$this->printRoute($grid, $h, $w, $route);

        // init output
        $output1 = count($route); // count of the route steps
        $output2 = null;

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    /**
     * Determine neighbours based on the type of character and the position on the grid
     *
     * @param string[] $grid Grid of special chars
     * @param int $i Location on grid (index: left-to-right,top-to-bottom)
     * @param int $w Width of the grid
     * @param int $h Height of the grid
     * @return int[] Neighbours (index numbers)
     */
    private function getNeighbours(array $grid, int $i, int $w, int $h): array
    {
        $x = ($i % $w) + 1;
        $y = floor($i / $h) + 1;
        $neighbours = [];

        if ($x > 1 && self::CHAR_MAP[$grid[$i - 1]][self::RIGHT] && self::CHAR_MAP[$grid[$i]][self::LEFT]) {
            $neighbours[] = $i - 1;
        }

        if ($x < $w && self::CHAR_MAP[$grid[$i]][self::RIGHT] && self::CHAR_MAP[$grid[$i + 1]][self::LEFT]) {
            $neighbours[] = $i + 1;
        }

        if ($y > 1 && self::CHAR_MAP[$grid[$i - $w]][self::BOTTOM] && self::CHAR_MAP[$grid[$i]][self::TOP]) {
            $neighbours[] = $i - $w;
        }

        if ($y < $h && self::CHAR_MAP[$grid[$i]][self::BOTTOM] && self::CHAR_MAP[$grid[$i + $w]][self::TOP]) {
            $neighbours[] = $i + $w;
        }

        return $neighbours;
    }

    /**
     * Breadth-first search
     *
     * @param int[][] $graph Graph (array of nodes with an array of neighbours as value)
     * @param int $start Start index
     * @param int $end End index
     * @return bool|array False if path was not found, or array with nodes indexes with the shortest path
     *
     * @author Lex T <lextoumbourou@gmail.com>
     * @license MIT
     * @see https://github.com/lextoumbourou/bfs-php/blob/master/bfs.php
     */
    public static function bfs_path($graph, $start, $end)
    {
        $queue = new \SplQueue();
        # Enqueue the path
        $queue->enqueue([$start]);
        $visited = [$start];
        while ($queue->count() > 0) {
            $path = $queue->dequeue();
            # Get the last node on the path
            # so we can check if we're at the end
            $node = $path[\count($path) - 1];

            if ($node === $end) {
                return $path;
            }
            foreach ($graph[$node] as $neighbour) {
                if (!\in_array($neighbour, $visited, true)) {
                    $visited[] = $neighbour;
                    # Build new path appending the neighbour then and enqueue it
                    $new_path = $path;
                    $new_path[] = $neighbour;
                    $queue->enqueue($new_path);
                }
            }
        }
        return false;
    }

    /**
     * Print Route
     *
     * @param string[] $grid Grid of special chars
     * @param int $h Grid height
     * @param int $w Grid width
     * @param int[] $route Route
     */
    protected function printRoute(array $grid, int $h, int $w, array $route): void
    {
        for ($y = 0; $y < $h; $y++) {
            for ($x = 0; $x < $w; $x++) {
                $i = $x + ($y * $w);
                $a = in_array($i, $route, true) ? "|" : " ";
                echo $a . $grid[$i] . $a;
            }
            echo PHP_EOL;
        }
    }
}