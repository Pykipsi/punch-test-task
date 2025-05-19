<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Get all subscribed users.
     *
     * @return Collection|User[]
     */
    public function getSubscribedUsers(): Collection;

    public function createOrUpdateUser(string $telegramId, string $name): User;
}
