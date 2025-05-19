<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Services\Telegram\TelegramCommandService;

class TelegramController extends Controller
{
    public function __construct(private TelegramCommandService $service)
    {
    }

    public function handle(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->noContent();
        }

        Log::info('Message ', $message);

        $chatId = $message['chat']['id'];
        $name = $message['from']['first_name'] ?? 'User';
        $text = $message['text'] ?? '';

        $this->service->handleCommand($chatId, $name, $text);

        return response()->noContent();
    }
}
