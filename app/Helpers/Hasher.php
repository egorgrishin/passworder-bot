<?php

namespace App\Helpers;

class Hasher
{
    /**
     * Хэширует переданную строку
     */
    public static function make(string $value): string
    {
        ['rounds' => $rounds, 'algo' => $algo] = config('hash');

        for ($i = 0; $i < $rounds; $i++) {
            $value = hash($algo, $value);
        }

        return $value;
    }
}
