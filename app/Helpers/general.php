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
