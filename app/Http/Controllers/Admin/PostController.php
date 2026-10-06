<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Post\DeletePostAction;
use App\Actions\Admin\Post\StorePostAction;
use App\Actions\Admin\Post\UpdatePostAction;
use App\Constants\AdminView;
use App\Enums\MediaCollection;
use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Post;
use App\Services\LocalFileUploader;
use App\Traits\HasDatatable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StorePostAction $storePostAction,
        private readonly UpdatePostAction $updatePostAction,
        private readonly DeletePostAction $deletePostAction,
        private readonly LocalFileUploader $fileUploader,
    ) {}

    public function index(): View
    {
        $title = 'مقالات';

        return view(
            AdminView::POST_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Post::query()
                ->select([
                    'id',
                    'title',
                    'author_id',
                    'status',
                    'is_featured',
                    'published_at',
                ])
                ->with('author'),
            actionsView: 'admin.pages.posts.partials._actions',
            extraColumns: [
                'author' => fn ($row) => $row->author?->name ?? '-',

                'status' => fn ($row) => $row->status->label(),

                'is_featured' => fn ($row) => \App\Support\BadgeHelper::booleanButton(
                    value: (bool) $row->is_featured,
                    trueLabel: 'ویژه',
                    falseLabel: 'عادی',
                ),
            ],
        );
    }


    public function create(): View
    {
        $title = 'ایجاد مقاله';

        $statuses = PostStatus::options();

        return view(
            AdminView::POST_CREATE,
            compact('title', 'statuses')
        );
    }



    public function store(
        StoreRequest $request
    ): RedirectResponse {
        $this->storePostAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'post.index')
            ->with('success', 'مقاله با موفقیت ایجاد شد.');
    }

    public function edit(Post $post): View
    {
        $title = 'ویرایش مقاله';
        $statuses = PostStatus::options();
        $post->load('media');
        $imageUrl = null;


        if (!is_null($post->media))
        {
            $image = $post->media
                ->where('collection', MediaCollection::IMAGE)
                ->first();

            $imageUrl = $image
                ? $this->fileUploader->url(
                    path: $image->file_path,
                    disk: $image->disk,
                )
                : null;
        }
        return view(
            AdminView::POST_EDIT,
            compact(
                'title',
                'post',
                'statuses',
                'imageUrl'
            )
        );
    }

    public function update(
        UpdateRequest $request,
        Post $post
    ): RedirectResponse {
        $this->updatePostAction->execute(
            post: $post,
            data: $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'post.index')
            ->with('success', 'مقاله با موفقیت بروزرسانی شد.');
    }

    public function destroy(Post $post)
    {
        $this->deletePostAction->execute($post);

        return response()->json([
            'message' => 'مقاله با موفقیت حذف شد.',
        ]);
    }
}
