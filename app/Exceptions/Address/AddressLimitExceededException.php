<?php

namespace App\Exceptions\Address;

use RuntimeException;

class AddressLimitExceededException extends RuntimeException
{
    public function __construct(int $max)
    {
        parent::__construct(
            "حداکثر {$max} آدرس می‌توانید ثبت کنید."
        );
    }
}
