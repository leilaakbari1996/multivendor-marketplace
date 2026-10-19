<?php

declare(strict_types=1);

namespace App\Datatables\Admin;

use App\Models\Post;
use App\Support\BadgeHelper;
use Illuminate\Database\Eloquent\Builder;

final class PostDatatable extends BaseDatatable
{
    protected function query(): Builder
    {
        return Post::query()
            ->select([
                'id',
                'title',
                'author_id',
                'status',
                'is_featured',
                'published_at',
            ])
            ->with('author');
    }

    protected function actionsView(): string
    {
        return 'admin.pages.posts.partials._actions';
    }

    protected function columns(): array
    {
        return [
            'author' => fn (Post $row): string => $row->author?->name
                ?? '-',

            'status' => fn (Post $row): string => $row->status->label(),

            'is_featured' => fn (Post $row): string => BadgeHelper::booleanButton(
                value: (bool) $row->is_featured,
                trueLabel: __('post.badges.featured'),
                falseLabel: __('post.badges.normal'),
            ),
        ];
    }

    protected function rawColumns(): array
    {
        return ['is_featured'];
    }
}
