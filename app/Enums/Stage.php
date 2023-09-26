<?php

namespace App\Enums;

enum Stage: string
{
    case SetChatPassword = 'set_chat_password';
    case WaitingPassword = 'waiting_password';
    case Menu = 'menu';
    case SetTitle = 'set_title';
    case SetLogin = 'set_login';
    case SelectPasswordType = 'select_password_type';
    case SetPasswordLen = 'set_password_len';
    case SetPassword = 'set_password';
}
