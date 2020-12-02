<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2018;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2018
 */
class Day13 extends Assignment
{
    /** @var array List of directions starting up, incrementing clockwise */
    private const DIRECTIONS =
        [
            self::UP,
            self::RIGHT,
            self::DOWN,
            self::LEFT,
        ];

    /** @var array Replacement tiles for the track */
    private const TRACK_REPLACEMENT =
        [
            self::UP => self::VERTICAL,
            self::DOWN => self::VERTICAL,
            self::LEFT => self::HORIZONTAL,
            self::RIGHT => self::HORIZONTAL,
        ];

    /** @var string Horizontal char */
    private const HORIZONTAL = "-";

    /** @var string Vertical char */
    private const VERTICAL = "|";

    /** @var string Corner A char */
    private const CORNER_A = "\\";

    /** @var string Corner B char */
    private const CORNER_B = "/";

    /** @var string Intersection char */
    private const INTERSECTION = "+";

    /** @var string Up facing cart char */
    private const UP = "^";

    /** @var string Right facing cart char */
    private const RIGHT = ">";

    /** @var string Down facing cart char */
    private const DOWN = "v";

    /** @var string Left facing cart char */
    private const LEFT = "<";


    /**
     * @return array
     */
    public function run(): array
    {
        $y = 0;
        $tracks = [];
        // parse the tracks from the input in tracks[y][x] format
        foreach (explode("\n", trim($this->getInput(), "\n")) as $line) {
            $tracks[$y++] = str_split($line);
        }

        $carts = [];
        $i = 0;
        // find the carts on the tracks, loop over all cells
        foreach ($tracks as $y => $row) {
            foreach ($tracks[$y] as $x => $cell) {
                // if a cell has a cart character
                // @todo instead of using the char for the direction we could use the enum integer, this would save a lookup later on
                if (in_array($cell, self::DIRECTIONS, true)) {
                    // extract the cart information
                    $carts[$i++] = ["y" => $y, "x" => $x, "dir" => $tracks[$y][$x], "turns" => 0];
                    // replace the cart on the track with a track character
                    $tracks[$y][$x] = self::TRACK_REPLACEMENT[$tracks[$y][$x]];
                }
            }
        }

        $collision_pos = null;
        $output1 = null;
        // loop, until we find a collision
        while (count($carts) > 1) {
            // make step
            $this->step($tracks, $carts, $collision_pos);

            // the output of part one is the first collision we find
            if (!$output1) {
                $output1 = $collision_pos;
            }
        }

        $output2 = null;
        if($carts) {
            // the position of the last cart left is the output of part 2
            $cart = reset($carts);
            $output2 = $cart["x"] . "," . $cart["y"];
        }

        // return answers
        return
            [
                $output1,
                $output2
            ];
    }

    /**
     * Step all carts one position, and return the collision coordinates
     *
     * @param string[][] $tracks Array with tracks x => y => track_type
     * @param array[] $carts Array with cart information cart_id => [x,y,dir,steps]
     * @param string $first_collision String with x,y of the first collision
     */
    private function step($tracks, &$carts, &$first_collision): void
    {
        // determine width of tracks, used to sort
        $width = count($tracks[0]);
        // sort the carts: convert x,y to x+(y*width) and sort on this number
        uasort($carts, function ($a, $b) use ($width) {
            return $a["x"] + ($a["y"] * $width) <=> $b["x"] + ($b["y"] * $width);
        });

        $remove_carts = [[]];
        // loop over all carts
        foreach ($carts as $cart_id => &$cart) {

            // make a step, because we know the direction
            switch ($cart["dir"]) {
                case self::UP:
                    $cart["y"]--;
                    break;
                case self::DOWN:
                    $cart["y"]++;
                    break;
                case self::LEFT:
                    $cart["x"]--;
                    break;
                case self::RIGHT:
                    $cart["x"]++;
                    break;
            }

            // if we are on a curve, determine the new direction
            // @todo: this probably can be done by math
            switch ($tracks[$cart["y"]][$cart["x"]] . $cart["dir"]) {
                case self::CORNER_A . self::UP: // '\^'
                    $cart["dir"] = self::LEFT;
                    break;
                case self::CORNER_A . self::RIGHT: // '\>'
                    $cart["dir"] = self::DOWN;
                    break;
                case self::CORNER_A . self::DOWN: // '\v'
                    $cart["dir"] = self::RIGHT;
                    break;
                case self::CORNER_A . self::LEFT: // '\<'
                    $cart["dir"] = self::UP;
                    break;
                case self::CORNER_B . self::UP: // '/^'
                    $cart["dir"] = self::RIGHT;
                    break;
                case self::CORNER_B . self::RIGHT: // '/>'
                    $cart["dir"] = self::UP;
                    break;
                case self::CORNER_B . self::DOWN: // '/v'
                    $cart["dir"] = self::LEFT;
                    break;
                case self::CORNER_B . self::LEFT: // '/<'
                    $cart["dir"] = self::DOWN;
                    break;
            }

            // if we are on an intersection, determine the new direction
            if ($tracks[$cart["y"]][$cart["x"]] === self::INTERSECTION) {
                // find current direction
                // @todo the lookup would be saved here
                $dir = array_search($cart["dir"], self::DIRECTIONS, true);
                // lookup the current (turns modulus 3)-1 turn we need to make: left(-1), straight(0) or right(1)
                $dir += ($cart["turns"]++ % 3) - 1;
                // use modulus to normalize overflow in the direction, and convert direction back to chars
                // @todo and here
                $cart["dir"] = self::DIRECTIONS[(4 + $dir) % 4];
            }

            // collision detection, loop over all carts
            foreach ($carts as $other_cart_id => $other_cart) {
                // if cart is not this cart, and x and y values are the same
                if ($cart_id !== $other_cart_id && $cart["x"] === $other_cart["x"] && $cart["y"] === $other_cart["y"]) {
                    if (!$first_collision) {
                        $first_collision = $cart["x"] . "," . $cart["y"];
                    }
                    // if we have a collision, remove the carts
                    $remove_carts[] = [$cart_id, $other_cart_id];
                }
            }
        }
        // unset value set by reference
        unset($cart);

        // combine remove carts array, and remove all entries that are marked
        $remove_carts = array_merge(...$remove_carts);
        foreach ($remove_carts as $cart_id) {
            unset($carts[$cart_id]);
        }
    }
}