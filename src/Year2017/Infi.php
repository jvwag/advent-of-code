<?php

namespace jvwag\AdventOfCode\Year2017;

use jvwag\AdventOfCode\Assignment;

/**
 * https://aoc.infi.nl/
 *
 * Robots wil eat your job!
 *
 * Bij Infi houden wij niet van repetitief werk en dus proberen we dit jaar wat tijdrovende
 * taken te automatiseren. Voor het uitdelen van de kerstcadeaus hebben wij daarom bezorgrobots
 * gebouwd, zodat wij ons volledig kunnen richten op code committen en kerstborrels bezoeken.
 * Helaas zitten we pas op release 0.9, want we kwamen er achter dat soms meerdere robots op
 * dezelfde plek uit kunnen komen en dat is natuurlijk niet efficiënt. We moeten dit snel
 * oplossen door te bepalen hoe vaak deze situatie voorkomt, want het is al bijna de 25ste!
 * Help jij mee?
 *
 * Om te helpen met debuggen hebben we enkele logs beschikbaar gemaakt. Deze zijn in het
 * volgende formaat opgeslagen:
 *
 * [sx1,sy1][sx2,sy2](x1,y1)(x2,y2)(x1,y1)
 *
 * Eerst vind je tussen de blokhaken de startposities van de robots. Let op: schaalbaarheid
 * is belangrijk, dus het aantal robots is variabel! Vervolgens bevat het log de bewegingen
 * die door de robots uitgevoerd zijn, in dezelfde volgorde als dat de robots zijn gedefinieerd.
 *
 * Voorbeeld:
 *
 * [0,0][1,1](1,0)(0,-1)(0,1)(-1,0)(-1,0)(0,1)(0,-1)(1,0)
 *
 *  1. Robot 1 begint op 0,0 en Robot 2 begint op 1,1
 *  2. Robot 1 gaat naar 1,0 (0,0 + 1,0)
 *  3. Robot 2 gaat naar 1,0 (1,1 + 0,-1)
 *  4. OEPS! Dit is dus een knelpunt.
 *  5. Robot 1 gaat naar 1,1 (1,0 + 0,1)
 *  6. Robot 2 gaat naar 0,0 (1,0 + -1,0)
 *  7. Robot 1 gaat naar 0,1 (1,1 + -1,0)
 *  8. Robot 2 gaat naar 0,1 (0,0 + 0,1)
 *  9. AI, Dit is ook een knelpunt.
 * 10. Robot 1 gaat naar 0,0 (0,1 + 0,-1)
 * 11. Robot 2 gaat naar 1,1 (0,1 + 1,0)
 *
 * Het komt in dit voorbeeld dus 2 keer voor dat de robots elkaar tegen komen. Kun jij uitrekenen
 * hoe vaak dit is gebeurd voor het volgende logbestand?
 *
 * @package jvwag\AdventOfCode\Other
 */
class Infi extends Assignment
{
    public const INPUT_LOCATION = "infi-2017.txt";

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    public function run(): array
    {
        // get input
        $data = trim($this->getInput());

        // initialize vars
        $bots = [];
        $bot_count = $rule_count = $collisions = 0;

        // loop over data
        while ($data) {
            // parse one element
            if (!preg_match("/^([\[\(])(-?\d+),(-?\d+)[\]\)]/", $data, $match)) {
                throw new \InvalidArgumentException("Error in input format");
            }
            /** @noinspection PhpUnusedLocalVariableInspection */
            [$tmp, $type, $x, $y] = $match;

            // handle a start point element
            if ($type === "[") {
                $bots[$bot_count++] = [(int) $x, (int) $y];
            }

            // handle a route element
            if ($type === "(") {
                // determine current bot to move
                $kbot1 = $rule_count++ % $bot_count;

                // move bot
                $bots[$kbot1] = [$bots[$kbot1][0] + $x, $bots[$kbot1][1] + $y];

                // after the last move we see if the bots collided
                if ($kbot1 === $bot_count - 1) {
                    // loop over bots
                    foreach ($bots as $kbot2 => $bot2) {
                        // if two bots are in the same location (and its not me)
                        if ($kbot1 !== $kbot2 && $bots[$kbot1] === $bot2) {
                            // add a pixel, and up a counter
                            $plot[$bots[$kbot1][0]][$bots[$kbot1][1]] = 1;
                            $collisions++;
                            break; // our work is done here
                        }
                    }
                }
            }
            // remove the data we just processed from the data string
            $data = \substr($data, \strlen($match[0]));
        }

        // init the output
        $output1 = $collisions;
        $output2 = "";

        // render the 'hidden' message
        for ($x = 0; $x < 30; $x++) {
            for ($y = 0; $y < 50; $y++) {
                if (isset($plot[$y][$x])) {
                    $output2 .= "x";
                } else {
                    $output2 .= ".";
                }
            }
            $output2 .= "\n";
        }

        // return the output
        return
            [
                $output1,
                $output2,
            ];
    }
}