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

Route::any('/{any}', function (\Illuminate\Http\Request $request) {
    $response = \Telegram\Bot\Laravel\Facades\Telegram::bot()->sendMessage([
        'chat_id' => '935824965',
        'text' => 'Hello World'
    ]);

    $messageId = $response->getMessageId();
    return response()->json([
        'all' => $request->all(),
        'messageId' => $messageId,
    ]);
})->where('any', '.*');
