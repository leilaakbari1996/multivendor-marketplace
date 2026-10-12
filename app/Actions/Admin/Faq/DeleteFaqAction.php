<?php

namespace App\Actions\Admin\Faq;

use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class DeleteFaqAction
{
    public function execute(Faq $faq): void
    {
        DB::transaction(function () use ($faq) {
            $faq->categories()->detach();

            $faq->delete();
        });
    }
}
