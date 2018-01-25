<?php

namespace App\Http\Controllers\Api;

use App\Events\PostHasBeenRead;
use App\Http\Controllers\ApiController;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Transformers\CommentTransformer;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Ty666\LaravelVote\Contracts\VoteController;
use Ty666\LaravelVote\Traits\VoteControllerHelper;

class PostController extends ApiController implements VoteController
{
    use VoteControllerHelper;

    protected $resourceClass = Post::class;

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
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->response()->noContent();
    }

    public function storeComment(Post $post, CommentRequest $request, CommentRepository $commentRepository)
    {
        $data = $request->validated();
        $comment = $commentRepository->createComment($post, $data);

        return $this->response()->item($comment, new CommentTransformer());
    }

    public function showComments(Post $post)
    {
        $comments = $post->comments()->latest()->with('user', 'user.avatar')->paginate($this->perPage());
        return $this->response()->item($comments, new CommentTransformer());
    }
}
