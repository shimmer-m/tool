<?php

/**
 * Each engineer has a duty to keep the code elegant
 * Created by meet at 2024/1/20 14:57
 */

namespace tool;

use ArrayAccess;

class Arr
{

    /**
     * Is Array
     * @param mixed $value
     * @return bool
     * Created by meet at 2024/1/20 14:59
     */
    public static function accessible(mixed $value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     */
    public static function add(array $array, string $key, mixed $value): array
    {
        if (is_null(static::get($array, $key))) {
            static::set($array, $key, $value);
        }
        return $array;
    }


    /**
     * Get an item from an array using "dot" notation.
     */
    public static function get(mixed $array, int|string|null $key = null, mixed $default = null)
    {
        if (!static::accessible($array)) {
            return value($default);
        }
        if (is_null($key)) {
            return $array;
        }
        if (static::exists($array, $key)) {
            return $array[$key];
        }
        if (!is_string($key) || !str_contains($key, '.')) {
            return $array[$key] ?? value($default);
        }
        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return value($default);
            }
        }
        return $array;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     * If no key is given to the method, the entire array will be replaced.
     */
    public static function set(array &$array, null|int|string $key, mixed $value): array
    {
        if (is_null($key)) {
            return $array = $value;
        }
        if (!is_string($key)) {
            $array[$key] = $value;
            return $array;
        }
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $array;
    }

    /**
     * Determine if the given key exists in the provided array.
     */
    public static function exists(array|ArrayAccess $array, int|string $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    }

}