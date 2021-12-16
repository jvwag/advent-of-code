<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode\Year2021;

use jvwag\AdventOfCode\Assignment;

/**
 * Class
 *
 * @package jvwag\AdventOfCode\Year2021
 */
class Day16 extends Assignment
{
    /**
     * @return array
     */
    public function run(): array
    {
        // get input and convert to binary string
        $binary = $this->convertHexStringToBinaryString(trim($this->getInput()));

        // parse the binary string and create a nested array of packets
        $packets = $this->parsePackets($binary);

        // return answers
        return
            [
                $this->sumVersions($packets), // process packets with the sum of versions
                $this->solveExpression($packets[0]) // process packets using the expression solver
            ];
    }

    /**
     * Utility to convert a hex string to a binary string
     *
     * @param string $hex Hex string
     * @return string Binary string
     */
    public function convertHexStringToBinaryString(string $hex): string
    {
        $binary = "";
        // loop over each pair of nibbles
        foreach (str_split($hex, 2) as $hex_byte) {
            // add binary output it to the binary string, while taking in account all needed prefix zero's
            $binary .= sprintf("%08b", hexdec($hex_byte));
        }

        return $binary;
    }

    /**
     * Utility function to extract some bits from the front of the string, and sizing the string (given by reference)
     * down, and returning the extracted value. The value will be an integer or string based on the int_val flag.
     *
     * @param string $str String to extract bits from the front
     * @param int $length Number of bits to take from the string
     * @param bool $int_val True if the return value must be an integer
     * @return int|string Output depends on the int_val flag
     */
    private function getBits(string &$str, int $length, bool $int_val = true): int|string
    {
        $val = substr($str, 0, $length);
        $str = substr($str, $length);
        return $int_val ? (int)bindec($val) : $val;
    }

    /**
     * Parse binary data info packets
     *
     * @param string $binary String of zeros and ones
     * @param int|null $max_packets Maximum number of packets to process before returning
     * @return array Array of packets
     */
    public function parsePackets(string &$binary, ?int $max_packets = null): array
    {
        // init array of all packets and the current packet
        $packets = [];
        $packet = [];

        // loop while we have data
        while ($binary) {
            // extract version and type
            $packet["version"] = $this->getBits($binary, 3);
            $packet["type"] = $this->getBits($binary, 3);

            // if the type is a literal
            if ($packet["type"] === 4) {

                $chunks = "";
                // loop over the data and get all the chunks
                do {
                    // the first bit of a chunk indicates if more chunks are coming
                    $last_flag = $this->getBits($binary, 1);

                    // extract a chunk and combine it
                    $chunks .= $this->getBits($binary, 4, false);

                } while ($last_flag === 1); // until we found the last chunk

                // combine chunks into a value
                $packet["value"] = bindec($chunks);
            } else {
                // this is not a literal, so get the length type of subfields
                $length_type = $this->getBits($binary, 1);

                if ($length_type === 0) {
                    // a zero length type will provide with 15 bits of length, indicating a substring of the binary string
                    $length_bits = $this->getBits($binary, 15);

                    // extract the sub packets string
                    $sub_packets_string = $this->getBits($binary, $length_bits, false);

                    // and process the packets recursively
                    $packet["sub_packets"] = $this->parsePackets($sub_packets_string);
                } else {
                    // another length type, but this will use the number of packets that will follow
                    $number_of_packets = $this->getBits($binary, 11);

                    // pass the full binary string, but give a parameter: so it will only process a defined amount of packets
                    $packet["sub_packets"] = $this->parsePackets($binary, $number_of_packets);
                }
            }

            // finished parsing this packet, add it to the packets array
            $packets[] = $packet;

            // if we have less than 8 zeros left in our binary string? this must be padding, so break this packet
            if (strlen($binary) < 8 && bindec($binary) === 0) {
                break;
            }

            // if we have a maximum amount of packets we may process
            if (count($packets) === $max_packets) {
                break;
            }
        }

        // return the packets we have found
        return $packets;
    }

    /**
     * Get sum of all versions in all packets, recursively
     *
     * @param array $packets Array of packets
     * @return int Sum of all version fields in the packets and sub-packets
     */
    public function sumVersions(array $packets): int
    {
        $version_sum = 0;
        // loop over the packets
        foreach ($packets as $packet) {
            // add the version number to the sum
            $version_sum += $packet["version"];
            // if the packet is not a literal value
            if ($packet["type"] !== 4) {
                // we will recursively process the sub packets
                $version_sum += $this->sumVersions($packet["sub_packets"]);
            }
        }

        // return the sum
        return $version_sum;
    }

    /**
     * Solve the expression given by the packets
     *
     * @param array $packet A single packet
     * @return int The answer to the expression
     */
    public function solveExpression(array $packet): int
    {
        // if the packet type is a literal value, return this
        if ($packet["type"] === 4) {
            return $packet["value"];
        }

        $values = [];
        // loop over all sub-packets
        foreach ($packet["sub_packets"] as $sub_packet) {
            // and process the expression of each sub-packet, and add it to the values array
            $values[] = $this->solveExpression($sub_packet);
        }

        // now determine how to process the values
        switch ($packet["type"]) {
            case 0:
                return array_sum($values);
            case 1:
                return array_product($values);
            case 2:
                return min($values);
            case 3:
                return max($values);
            case 5:
                return $values[0] > $values[1] ? 1 : 0;
            case 6:
                return $values[0] < $values[1] ? 1 : 0;
            case 7:
                return $values[0] === $values[1] ? 1 : 0;
        }

        // an unknown type: panic!
        assert(false, "Unknown type");
    }
}