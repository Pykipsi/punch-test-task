<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

use App\Services\Telegram\TelegramCommandServiceInterface;

class SendTelegramNotification implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    private string $telegramId;
    private array $tasks;

    private TelegramCommandServiceInterface $telegramService;

    public function __construct(string $telegramId, array $tasks)
    {
        $this->telegramId = $telegramId;
        $this->tasks = $tasks;
        $this->telegramService = app(TelegramCommandServiceInterface::class);
    }

    public function handle(): void
    {
        $text = __('telegram.unfinished_tasks') . "\n\n";
        foreach ($this->tasks as $task) {
            $text .= "• " . $task['title'] . "\n";
        }

        $this->telegramService->sendMessage($this->telegramId, $text);
    }
}
