<?php

namespace SaliBhdr\TyphoonIranCities\Support;

final class PackagePath
{
    public static function root(): string
    {
        return dirname(__DIR__, 2);
    }

    public static function stubs(string $segment = ''): string
    {
        $path = self::root() . DIRECTORY_SEPARATOR . 'stubs';

        if ($segment !== '') {
            $path .= DIRECTORY_SEPARATOR . $segment;
        }

        $resolved = realpath($path);

        if ($resolved === false) {
            throw new \RuntimeException("Package stubs path not found: {$path}");
        }

        return $resolved;
    }

    public static function csv(): string
    {
        return self::root() . DIRECTORY_SEPARATOR . 'csv';
    }
}
