<?php

return [
    'rounds' => env('HASH_ROUNDS', 4),
    'algo'   => env('HASH_ALGORITHM', 'xxh128'),
];
