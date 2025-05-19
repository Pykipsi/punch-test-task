<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use GuzzleHttp\Client;

use App\Services\Telegram\Enums\TelegramCommand;
use App\Repositories\UserRepositoryInterface;

class TelegramCommandService implements TelegramCommandServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function handleCommand(string $chatId, string $name, string $text): void
    {
        $command = TelegramCommand::fromText($text);

        match ($command) {
            TelegramCommand::START => $this->handleStart($chatId, $name),
            TelegramCommand::STOP => $this->handleStop($chatId),
            default => $this->sendMessage($chatId, __('telegram.unidentified_command', ['command' => $text])),
        };
    }

    public function sendMessage(string $chatId, string $text): void
    {
        $token = config('services.telegram.bot_token');

        $client = new Client();

        $client->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $text,
            ],
        ]);
    }

    private function handleStart(string $telegramId, string $name): void
    {
        $user = $this->userRepository->findByTelegramId($telegramId);

        if (!$user) {
            $user = $this->userRepository->createOrUpdateUser($telegramId, $name);
            $this->sendMessage($telegramId, __('telegram.start', ['name' => $user->name]));
        } else {
            $this->userRepository->createOrUpdateUser($telegramId, $name);

            if (!$user->subscribed) {
                $this->sendMessage($telegramId, __('telegram.resubscribed'));
            }
        }
    }

    private function handleStop(string $telegramId): void
    {
        $user = $this->userRepository->findByTelegramId($telegramId);

        if ($user) {
            $user->update(['subscribed' => false]);
            $this->sendMessage($telegramId, __('telegram.stop'));
        } else {
            $this->sendMessage($telegramId, __('telegram.not_subscribed'));
        }
    }
}
