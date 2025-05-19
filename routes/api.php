<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Telegram\TelegramController;

Route::post('/webhook/telegram', [TelegramController::class, 'handle']);
