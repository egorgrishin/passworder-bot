<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/bot', function (\Illuminate\Http\Request $request) {
    $keyboard = [
        ['7', '8', '9'],
        ['4', '5', '6'],
        ['1', '2', '3'],
        ['0']
    ];

    $reply_markup = \Telegram\Bot\Laravel\Facades\Telegram::replyKeyboardMarkup([
        'keyboard' => $keyboard,
        'resize_keyboard' => true,
        'one_time_keyboard' => true
    ]);

    $response = \Telegram\Bot\Laravel\Facades\Telegram::bot()->sendMessage([
        'chat_id' => '935824965',
        'text' => 'Hello World',
        'reply_markup' => $reply_markup
    ]);

    $messageId = $response->getMessageId();

    \Illuminate\Support\Facades\Log::debug($request->all());

    return response()->json([
        'all' => $request->all(),
        'messageId' => $messageId,
    ]);
})->where('any', '.*');
