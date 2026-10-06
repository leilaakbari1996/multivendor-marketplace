<?php

namespace App\Actions\Admin\User;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function execute(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {

            $image = $data['image'] ?? null;
            $roles = $data['roles'] ?? [];

            unset(
                $data['image'],
                $data['roles'],
            );

            if (filled($data['password'] ?? null)) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            $user->roles()->sync($roles);

            if ($image instanceof UploadedFile) {

                $user->media()
                    ->where('collection', MediaCollection::AVATAR->value)
                    ->delete();

                $this->storeMediaAction->execute(
                    model: $user,
                    file: $image,
                    collection: MediaCollection::AVATAR,
                    directory: 'users',
                );
            }

            return $user->refresh();
        });
    }
}
