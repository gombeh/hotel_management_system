<?php


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
