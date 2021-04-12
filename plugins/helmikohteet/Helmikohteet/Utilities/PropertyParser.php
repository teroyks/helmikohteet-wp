<?php

/**
 * Parser for getting string values from a multidimensional associative array.
 *
 * Specify keys as an array to get a value from many levels down.
 * For example: parseProperty(['foo', 'bar'], ['foo' => ['bar' => 'baz']])
 * returns 'baz'.
 *
 * @see PropertyParserTest for examples.
 *
 * @deprecated direct XML parsing used instead
 */

namespace Helmikohteet\Utilities;

use Helmikohteet\ListingsList\ApartmentType;

/**
 * Parses a value from a multidimensional array.
 */
class PropertyParser
{
    /**
     * @param string|array $property Property key or keys
     * @param array        $data     Data to search
     *
     * @return string Value, or empty if not found.
     */
    public function parseProperty($property, array $data): string
    {
        switch ($property) {
            case ['@attributes', 'type']:
                $code = $data['@attributes']['type'] ?? '';

                return ApartmentType::get($code);
        }

        return is_array($property)
            ? $this->parseArrayProperty($property, $data)
            : $this->parseStringProperty($property, $data);
    }

    /**
     * Fetches a value with an array of keys.
     *
     * @param array $property
     * @param array $data
     *
     * @return string Value, or empty if not found.
     */
    private function parseArrayProperty(array $property, array $data): string
    {
        $rest = array_values($property);
        $key  = array_shift($rest);

        // error_log(print_r($rest, true));
// error_log(print_r($data, true));
// error_log(print_r($key, true));


        return empty($rest)
            ? $this->parseStringProperty($key, $data)
            : $this->parseArrayProperty($rest, $data[$key] ?? []);
    }

    /**
     * Fetches array value that matches given key.
     *
     * @param       $property
     * @param array $data
     *
     * @return string Value, or empty if not found.
     */
    private function parseStringProperty($property, array $data): string
    {
        $toString =  fn(array $arr) => '[' . implode(':', $arr) . ']';
        $getValue = fn() => $data[$property] ?? '';

        $val = $getValue();

        return is_array($val) ? $toString($val) : $val;
    }
}
