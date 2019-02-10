<?php

if (! function_exists('array_group_by')) {
    /**
     * Group an associative array by field.
     *
     * @param array $items
     * @param string $groupBy
     * @param bool $preserveKeys
     * @return array
     */
    function array_group_by(array $items, string $groupBy, bool $preserveKeys = false)
    {
        $results = [];

        foreach ($items as $key => $value) {
            if (! array_key_exists($groupBy, $value)) {
                continue;
            }

            $groupKeys = $value[$groupBy];

            if (! is_array($groupKeys)) {
                $groupKeys = [$groupKeys];
            }

            foreach ($groupKeys as $groupKey) {
                $groupKey = is_bool($groupKey) ? (int) $groupKey : $groupKey;

                if (! array_key_exists($groupKey, $results)) {
                    $results[$groupKey] = [];
                }

                if ($preserveKeys) {
                    $results[$groupKey][$key] = $value;
                } else {
                    $results[$groupKey][] = $value;
                }
            }
        }

        return $results;
    }
}

if (! function_exists('array_map_with_keys')) {
    /**
     * Run an associative map over each of the items.
     *
     * @param array $items
     * @param callable $callback
     * @return array
     */
    function array_map_with_keys(array $items, callable $callback)
    {
        $result = [];

        foreach ($items as $key => $value) {
            $assoc = $callback($value, $key);

            foreach ($assoc as $mapKey => $mapValue) {
                $result[$mapKey] = $mapValue;
            }
        }

        return $result;
    }
}

if (! function_exists('array_sort_by')) {
    /**
     * Sort the array using the given callback.
     *
     * @param array $items
     * @param callable|string $callback
     * @param int $options
     * @param bool $descending
     * @return array
     */
    function array_sort_by(array $items, $callback, $options = SORT_REGULAR, bool $descending = false)
    {
        $results = [];

        $callback = is_callable($callback) ? $callback : function ($item) use ($callback) {
            return $item[$callback];
        };

        foreach ($items as $key => $value) {
            $results[$key] = $callback($value, $key);
        }

        $descending ? arsort($results, $options)
            : asort($results, $options);

        foreach (array_keys($results) as $key) {
            $results[$key] = $items[$key];
        }

        return $results;
    }
}

if (! function_exists('str_startswith')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    function str_startswith($haystack, $needle)
    {
        return substr($haystack, 0, strlen($needle)) === (string) $needle;
    }
}

if (! function_exists('array_get')) {
    /**
     * Get an item from an array.
     *
     * @param array $array
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }
}
