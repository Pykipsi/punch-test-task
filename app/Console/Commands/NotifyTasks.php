<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;

use Illuminate\Console\Command;

use App\Jobs\SendTelegramNotification;
use App\Repositories\UserRepositoryInterface;

class NotifyTasks extends Command
{
    protected $signature = 'app:notify-tasks';

    protected $description = 'Send notification to active users with uncompleted tasks';

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        $this->info(__('common.receiving_tasks'));

        $client = new Client();

        $response = $client->get(config('services.task.url'));

        if ($response->getStatusCode() !== 200) {
            $this->error(__('common.receiving_tasks_error'));
            return Command::FAILURE;
        }

        $tasks = collect(json_decode($response->getBody()->getContents(), true))
            ->filter(fn($task) => !$task['completed'] && $task['userId'] <= 5)
            ->all();

        $users = $this->userRepository->getSubscribedUsers();

        if ($users->isEmpty()) {
            $this->warn(__('common.no_active_users'));
            return Command::SUCCESS;
        }

        foreach ($users as $user) {
            if (count($tasks) == 0) {
                $this->warn(__('common.no_uncompleted_tasks'));
                return Command::SUCCESS;
            }

            SendTelegramNotification::dispatch($user->telegram_id, $tasks);
            $this->info(__('common.send_notifications', ['name' => $user->name]));
        }

        return Command::SUCCESS;
    }
}
