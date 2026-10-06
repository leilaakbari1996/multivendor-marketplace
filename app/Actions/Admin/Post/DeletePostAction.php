<?php

namespace App\Actions\Admin\Post;

use App\Models\Post;

class DeletePostAction
{
    public function __construct()
    {
    }

    public function execute(Post $post): void
    {
        $post->delete();
    }
}
