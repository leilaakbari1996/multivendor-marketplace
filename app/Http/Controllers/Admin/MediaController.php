<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminView;
use App\Enums\MediaOwnerType;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Contracts\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $title = 'رسانه‌ها';

        $media = Media::query()
            ->latest()
            ->get([
                'id',
                'file_name',
                'file_path',
                'mime_type',
                'size',
                'created_at',
                'mediable_type',
                'mediable_id',
            ]);

        foreach ($media as &$item)
        {
            $item->type = MediaOwnerType::fromModel($item->mediable_type);
        }

        return view(
            AdminView::MEDIA_INDEX,
            compact('title', 'media')
        );
    }
}
