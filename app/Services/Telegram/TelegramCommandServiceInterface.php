<?php

declare(strict_types=1);

namespace App\Services\Telegram;

interface TelegramCommandServiceInterface
{
    public function handleCommand(string $chatId, string $name, string $text): void;

    public function sendMessage(string $chatId, string $text): void;
}
