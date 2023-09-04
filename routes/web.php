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

Route::get('/333', function () {
    $response = \Telegram\Bot\Laravel\Facades\Telegram::bot()->sendMessage([
        'chat_id' => '935824965',
        'text' => 'Hello World'
    ]);

    $messageId = $response->getMessageId();
    dd($messageId, $response);
    return view('welcome');
});

Route::get('/{any}', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::debug([
        $request->method(),
        $request->all()
    ]);
})->where('any', '.*');
