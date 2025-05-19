<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly User $userModel)
    {
    }

    public function getSubscribedUsers(): Collection
    {
        return $this->userModel->query()->where('subscribed', true)->get();
    }

    public function findByTelegramId(string $telegramId): ?User
    {
        return $this->userModel->query()->where('telegram_id', $telegramId)->first();
    }

    public function createOrUpdateUser(string $telegramId, string $name): User
    {
        return $this->userModel->query()->updateOrCreate(['telegram_id' => $telegramId], ['telegram_id' => $telegramId, 'name' => $name, 'subscribed' => true]);
    }
}
