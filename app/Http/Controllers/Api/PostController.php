<?php

namespace App\Http\Controllers\Api;

use App\Events\PostHasBeenRead;
use App\Http\Controllers\ApiController;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostController extends ApiController
{
    /**
     * 文章列表
     *
     * @param Request $request
     * @return \App\Support\Response\TransformerResponse
     */
    public function index(Request $request)
    {
        $posts = Post::ApplyFilter($request)
            ->paginate($this->perPage());
        return $this->response()->paginator($posts, new PostTransformer());
    }

    /**
     * 显示指定的文章
     *
     * @param Post $post
     * @return \App\Support\Response\TransformerResponse
     */
    public function show(Post $post)
    {
        event(new PostHasBeenRead($post, request()->getClientIp()));
        return $this->response()->item($post, new PostTransformer());
    }

    /**
     * 更新文章
     *
     * @param Post $post
     * @param PostRequest $postRequest
     * @param PostRepository $postRepository
     * @return \App\Support\Response\Response
     */
    public function update(Post $post, PostRequest $postRequest, PostRepository $postRepository)
    {
        $postRepository->update($postRequest->validated(), $post);
        return $this->response()->noContent();
    }

    /**
     * 创建文章
     *
     * @param PostRequest $postRequest
     * @param PostRepository $postRepository
     * @return \App\Support\Response\Response
     */
    public function store(PostRequest $postRequest, PostRepository $postRepository)
    {
        $postRepository->create($postRequest->validated());
        return $this->response()->noContent();
    }

    /**
     * 删除文章
     *
     * @param Post $post
     * @return \App\Support\Response\Response
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
        } catch (\Exception $e) {
            throw new HttpException('500', '文章删除失败.');
        }
        return $this->response()->noContent();
    }

    public function addLikes(Post $post, PostRepository $postRepository)
    {
        $postRepository->addLikes($post);
        return $this->response()->noContent();
    }

    public function subLikes(Post $post, PostRepository $postRepository)
    {
        $postRepository->subLike($post);
        return $this->response()->noContent();
    }
}
