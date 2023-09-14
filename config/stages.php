<?php

return [
    'default' => 'menu',

    'list' => [
        'set_password'         => ['next' => ['menu']],
        'menu'                 => ['next' => ['add_data']],
        'add_data'             => ['next' => ['write_resource_name']],
        'enter_resource_name'  => ['next' => ['write_first_data']],
        'enter_first_data'     => ['next' => ['write_second_data']],
        'choose_second_method' => ['next' => ['enter_second_data']],
        'enter_second_data'    => ['next' => ['menu']],
    ],
];
