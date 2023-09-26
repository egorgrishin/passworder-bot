<?php

namespace App\Helpers;

use Exception;

class Generator
{
    private const SYMBOLS = [
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'abcdefghijklmnopqrstuvwxyz',
        '0123456789',
        '!@#$%^&*()-_+=;:,./?\|`~[]{}',
    ];

    /**
     * Генерирует пароль указанной длины
     */
    public static function create(int $length): string
    {
        $alphabets_count = count(self::SYMBOLS) - 1;
        $alphabets = self::SYMBOLS;
        shuffle($alphabets);
        for ($i = count($alphabets); $i < $length; $i++) {
            $alphabets[] = self::SYMBOLS[self::rand($alphabets_count)];
        }

        $str = '';
        shuffle($alphabets);
        foreach ($alphabets as $alphabet) {
            $str .= $alphabet[self::rand(strlen($alphabet) - 1)];
        }

        return $str;
    }

    /**
     * Возвращает целое случайное число из диапазона [0; max]
     */
    private static function rand(int $max): int
    {
        try {
            return random_int(0, $max);
        } catch (Exception) {
            return rand(0, $max);
        }
    }
}
