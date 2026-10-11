<?php

namespace App\Queries;

use App\Models\Otp;

class OtpQuery
{

    public function findByMobile(string $phone): ?Otp
    {
        return Otp::query()
            ->forMobile($phone)
            ->first();
    }

    public function delete($phone)
    {
        Otp::query()
            ->forMobile($phone)
            ->delete();
    }

    public function create($data)
    {
        Otp::query()->create($data);
    }


}
