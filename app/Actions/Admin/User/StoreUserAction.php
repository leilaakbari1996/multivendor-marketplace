<?php

namespace App\Actions\Admin\User;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StoreUserAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $image = $data['image'] ?? null;
            $roles = $data['roles'] ?? [];

            unset(
                $data['image'],
                $data['roles'],
            );

            $data['password'] = isset($data['password'])
                ? bcrypt($data['password'])
                : null;

            $user = User::create($data);

            $user->roles()->sync($roles);

            if ($image) {
                $this->storeMediaAction->execute(
                    model: $user,
                    file: $image,
                    collection: MediaCollection::AVATAR,
                    directory: 'users',
                );
            }

            return $user;
        });
    }
}
