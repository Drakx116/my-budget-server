<?php

namespace App\Service\Utils;

class JsonHelper
{
    public static function encode(array $data): string
    {
        try {
            return json_encode($data, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return '';
        }
    }

    public static function decode(string $data, bool $associative = true): array
    {
        try {
            return json_decode($data, $associative, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return [];
        }
    }
}
