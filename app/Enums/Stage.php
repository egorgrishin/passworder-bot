<?php

namespace App\Enums;

enum Stage: string
{
    case SetPassword = 'set_password';
    case WaitingPassword = 'waiting_password';
    case Menu = 'menu';
}
