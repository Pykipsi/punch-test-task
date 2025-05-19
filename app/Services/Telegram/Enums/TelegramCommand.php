<?php

namespace App\Services\Telegram\Enums;

enum TelegramCommand: string
{
    case START = '/start';
    case STOP = '/stop';

    public static function fromText(string $text): ?self
    {
        return collect(self::cases())
            ->first(fn(self $cmd) => $cmd->value === trim($text));
    }
}
