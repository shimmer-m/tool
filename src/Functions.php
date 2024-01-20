<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by meet at 2024/1/20 15:02
 */

namespace tool;

use Closure;

/**
 * Get the first element of an array. Useful for method chaining.
 *
 * @param array $array
 * @return mixed
 */
function head(array $array)
{
    return reset($array);
}

/**
 * Get the last element from an array.
 *
 * @param array $array
 * @return mixed
 */
function last(array $array)
{
    return end($array);
}

/**
 * Return the default value of the given value.
 *
 * @param mixed ...$args
 * @return mixed
 */
function value(mixed $value, ...$args)
{
    return $value instanceof Closure ? $value(...$args) : $value;
}