<?php

namespace App\Http\Controllers\Client;

use App\Constants\Client\BlogConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Blog\BlogFilterRequest;
use App\Models\Post;
use App\Queries\PostQuery;
use App\Queries\CategoryQuery;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    public function __construct(
        private readonly PostQuery $postQuery,
    ) {
    }

    public function index(BlogFilterRequest $request): View|JsonResponse
    {
        $posts = $this->postQuery->paginate(
            filters: $request->validated(),
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'total' => $posts->total(),
                'grid_html' => view(
                    'client.partials.blog.grid',
                    compact('posts')
                )->render(),
                'pagination_html' => $posts->hasPages()
                    ? view(
                        'components.client.pagination',
                        ['paginator' => $posts->withQueryString()]
                    )->render()
                    : '',
            ]);
        }

        $recentPosts = $posts->take(BlogConstant::RECENT_POSTS_LIMIT);

        return view(
            'client.pages.blogs.index',
            compact('posts',  'recentPosts')
        );
    }

    public function show(Post $post)
    {
        $post->load(['author', 'image'])->loadCount('likes');
        $recentPosts = $this->postQuery->recent(exceptId: $post->id);
        $prev        = $this->postQuery->previous($post);
        $next        = $this->postQuery->next($post);

        return view(
            'client.pages.blogs.show',
            compact('post','recentPosts','next','prev')
        );
    }
}
