<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function index(): array
    {
        return User::with('paidTransfers', 'receivedTransfers')->get()->toArray();
    }

    public function store(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function destroy(User $user): bool
    {
        return (bool) $user->delete();
    }
}
