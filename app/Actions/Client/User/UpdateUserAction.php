<?php

namespace App\Actions\Client\User;

use App\Actions\Admin\Media\StoreMediaAction;
use App\Enums\MediaCollection;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    /** فقط این فیلدها از سمت کلاینت قابل تغییرن */
    private const ALLOWED = ['user_name', 'password', 'avatar'];

    public function __construct(
        private readonly StoreMediaAction $storeMediaAction,
    ) {
    }

    public function execute(User $user, array $data): User
    {
        $data = Arr::only($data, self::ALLOWED);

        return DB::transaction(function () use ($user, $data) {

            $avatar = Arr::pull($data, 'avatar');

            if (filled($data['password'] ?? null)) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            if ($data !== []) {
                $user->update($data);
            }

            if ($avatar instanceof UploadedFile) {
                $user->media()
                    ->where('collection', MediaCollection::AVATAR->value)
                    ->delete();

                $this->storeMediaAction->execute(
                    model: $user,
                    file: $avatar,
                    collection: MediaCollection::AVATAR,
                    directory: 'users',
                );
            }

            return $user->refresh();
        });
    }
}
