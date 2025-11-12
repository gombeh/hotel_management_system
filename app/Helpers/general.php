<?php


use Illuminate\Database\Eloquent\Model;

if (!function_exists('convert_path_to_namespace')) {
    function convert_path_to_namespace(string $path): string
    {
        $trimmedPath = str_replace('.php', '', $path);

        $exploded = explode('/', $trimmedPath);

        $exploded = array_map(fn(string $section) => ucfirst($section), $exploded);

        return join('\\', $exploded);
    }
}

if (!function_exists('array_some')) {
    function array_some(array $data, callable $callback): bool
    {
        $result = array_filter($data, $callback);
        return count($result) > 0;
    }
}

if (!function_exists('array_every')) {
    function array_every(array $data, callable $callback): bool
    {
        $result = array_filter($data, $callback);
        return count($result) === count($data);
    }
}


if (!function_exists('except_keys')) {
    function except_keys(array|model $array, array|string $keys): mixed
    {
        $keys = is_array($keys) ? $keys : [$keys];
        $array = $array instanceof Model ? $array->toArray() : $array;
        return array_diff_key($array, array_flip($keys));
    }
}

if(!function_exists('keys_exists')) {
    function keys_exists(array $keys, array $arr): bool
    {
        return count(array_intersect_key(array_flip($keys), $arr)) === count($keys);
    }
}

if(!function_exists('keys_not_null')) {
    function keys_not_null(array $keys, array $arr): bool
    {
        if(!keys_exists($keys, $arr)) return false;

        return array_every($keys, fn($key) => !is_null($arr[$key]));
    }
}
