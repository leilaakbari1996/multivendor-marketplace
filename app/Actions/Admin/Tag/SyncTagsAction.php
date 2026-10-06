<?php
namespace App\Actions\Admin\Tag;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SyncTagsAction
{
    public function execute(Model $model, array $tags): void
    {
        $tagIds = collect($tags)
            ->map(fn (string $tag) => $this->resolveTag($tag))
            ->all();

        $model->tags()->sync($tagIds);
    }

    private function resolveTag(string $name): int
    {
        $tag = Tag::firstOrCreate(
            ['name' => $name]
        );

        return $tag->id;
    }
}
