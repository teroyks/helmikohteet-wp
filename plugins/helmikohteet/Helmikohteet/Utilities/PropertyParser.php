<?php

/**
 * Parser for getting string values from a multidimensional associative array.
 *
 * Specify keys as an array to get a value from many levels down.
 * For example: parseProperty(['foo', 'bar'], ['foo' => ['bar' => 'baz']])
 * returns 'baz'.
 *
 * @see PropertyParserTest for examples.
 */

namespace Helmikohteet\Utilities;

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
        return $data[$property] ?? '';
    }
}
