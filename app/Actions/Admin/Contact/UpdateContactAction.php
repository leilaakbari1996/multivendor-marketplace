<?php

namespace App\Actions\Admin\Contact;

use App\Models\ContactMessage;

class UpdateContactAction
{
    public function execute(ContactMessage $contactMessage, array $data): ContactMessage
    {
        $contactMessage->update($data);

        return $contactMessage;
    }
}
