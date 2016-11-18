<?php

namespace LuhnMod16;

/**
 * Class LuhnMod16
 * @package LuhnMod16
 */
class LuhnMod16
{
    /**
     * @param $data
     * @return string
     * @throws \Exception
     */
    public static function calculate($data)
    {
        if (!is_string($data)) {
            throw new \InvalidArgumentException('Data with value "' . $data . '" is not a string.');
        }

        // Split the data into individual characters
        $characters = str_split($data);

        // Create an array to put the final characters into
        $character_list = [];

        // From right to left...
        for ($i = count($characters) - 1; $i >= 0; $i--) {
            // Convert character to decimal
            $character_list[$i] = hexdec($characters[$i]);

            // For every odd character, ie 1, 3, 5, etc...
            if ($i % 2 !== 0) {
                // Double it
                $doubled = $character_list[$i] * 2;

                // Convert it to hexadecimal
                $hexed = dechex($doubled);

                // If it's still a number (not a hex 'letter'), note casting to string, as ctype_digit accepts ascii codes as well
                if (ctype_digit((string) $hexed)) {
                    $character_list[$i] = array_sum(str_split($hexed)); // Store it
                }
            }
        }

        // Add them all up
        $total = array_sum($character_list);

        // Get the difference between next multiple of 16 and the sum
        $difference = ceil($total / 16) * 16 - $total;

        // Convert to hex
        $hex = dechex($difference);

        // uppercase it
        return strtoupper($hex);
    }
}
