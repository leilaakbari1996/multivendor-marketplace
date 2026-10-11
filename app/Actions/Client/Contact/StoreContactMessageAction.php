<?php

namespace App\Actions\Client\Contact;

use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;

class StoreContactMessageAction
{
    public function execute(array $data): ContactMessage
    {
        return ContactMessage::create([
            ...$data,
            'status' => ContactMessageStatus::NEW->value,
        ]);
    }
}
