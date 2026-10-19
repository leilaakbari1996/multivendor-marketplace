<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Post\DeletePostAction;
use App\Actions\Admin\Post\StorePostAction;
use App\Actions\Admin\Post\UpdatePostAction;
use App\Constants\AdminView;
use App\Datatables\Admin\PostDatatable;
use App\Enums\MediaCollection;
use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Post;
use App\Services\LocalFileUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function __construct(
        private readonly StorePostAction $storePostAction,
        private readonly UpdatePostAction $updatePostAction,
        private readonly DeletePostAction $deletePostAction,
        private readonly LocalFileUploader $fileUploader,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Post::class);

        return view(
            AdminView::PREFIX . 'posts.index',
            [
                'title' => __('post.title'),
            ],
        );
    }

    public function data(PostDatatable $datatable): JsonResponse
    {
        $this->authorize('viewAny', Post::class);

        return $datatable->toJson();
    }

    public function create(): View
    {
        $this->authorize('create', Post::class);

        return view(
            AdminView::PREFIX . 'posts.create',
            [
                'title' => __('post.create'),
                'statuses' => PostStatus::options(),
            ],
        );
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $this->storePostAction->execute(
            $request->validated(),
        );

        return to_route(AdminView::PREFIX_ROUTE . 'post.index')
            ->with('success', __('post.messages.created'));
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        $post->load('media');

        $image = $post->media->firstWhere(
            'collection',
            MediaCollection::IMAGE,
        );

        $imageUrl = $image
            ? $this->fileUploader->url(
                path: $image->file_path,
                disk: $image->disk,
            )
            : null;

        return view(
            AdminView::PREFIX . 'posts.edit',
            [
                'title' => __('post.edit'),
                'post' => $post,
                'statuses' => PostStatus::options(),
                'imageUrl' => $imageUrl,
            ],
        );
    }

    public function update(
        UpdatePostRequest $request,
        Post $post,
    ): RedirectResponse {
        $this->authorize('update', $post);

        $this->updatePostAction->execute(
            post: $post,
            data: $request->validated(),
        );

        return to_route(AdminView::PREFIX_ROUTE . 'post.index')
            ->with('success', __('post.messages.updated'));
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $this->deletePostAction->execute($post);

        return ApiResponse::success(__('post.messages.deleted'));
    }
}
