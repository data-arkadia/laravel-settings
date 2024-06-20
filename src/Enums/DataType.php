<?php

namespace DataArkadia\LaravelSettings\Enums;

enum DataType:string
{
    case TEXT = 'string';
    case NUMBER = 'integer';
    case BOOLEAN = 'boolean';
    case RANGE = 'array';

    public static function caseNames(): array
    {
        $caseNames = array_column(self::cases(), 'name');

        return $caseNames;
    }

    public static function caseNamesForHumans(): array
    {
        $caseNamesForHumans = array_map('strtolower', self::caseNames());
        $caseNamesForHumans = array_map('ucfirst', $caseNamesForHumans);

        return $caseNamesForHumans;
    }

    public static function caseValues(): array
    {
        $caseValues = array_column(self::cases(), 'value');

        return $caseValues;
    }

    public static function forDropdown(): array
    {
        return array_combine(
            self::caseNames(),
            self::caseNamesForHumans()
        );
    }
}
