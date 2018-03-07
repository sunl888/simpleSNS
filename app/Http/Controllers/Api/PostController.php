<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Events\PostHasBeenRead;
use App\Http\Requests\PostRequest;
use App\Repositories\PostRepository;
use App\Http\Requests\CommentRequest;
use App\Transformers\PostTransformer;
use App\Http\Controllers\ApiController;
use App\Repositories\CommentRepository;
use App\Transformers\CommentTransformer;
use App\Exceptions\PermissionDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Ty666\LaravelVote\Contracts\VoteController;
use Ty666\LaravelVote\Traits\VoteControllerHelper;
use Ty666\LaravelVote\Contracts\CanCountUpVotesModel;
use Ty666\LaravelVote\Contracts\CanCountDownVotesModel;

class PostController extends ApiController implements VoteController
{
    use VoteControllerHelper;

    protected $resourceClass = Post::class;

    public function __construct()
    {
        // 验证是否登录
        $this->middleware('auth:api')->except('index', 'show', 'showComments');
    }

    /**
     * 文章列表.
     *
     * @param Request $request
     * @return \App\Support\Response\TransformerResponse
     */
    public function index(Request $request)
    {
        $posts = Post::applyFilter($request)
            ->publishPost()
            ->publishdAt()
            ->latest('published_at')
            ->paginate($this->perPage());

        return $this->response()->paginator($posts, new PostTransformer());
    }

    /**
     * 显示指定的文章.
     *
     * @param Post $post
     * @return \App\Support\Response\TransformerResponse
     * @throws PermissionDeniedException
     */
    public function show(Post $post)
    {
        if ($post->isDraft()) {
            throw new PermissionDeniedException('文章无法查看, 你的权限还不够喔 (╯︵╰,)');
        }
        event(new PostHasBeenRead($post, request()->getClientIp()));

        return $this->response()->item($post, new PostTransformer());
    }

    /**
     * 更新文章.
     *
     * @param Post $post
     * @param PostRequest $postRequest
     * @param PostRepository $postRepository
     * @return \App\Support\Response\Response
     * @throws PermissionDeniedException
     */
    public function update(Post $post, PostRequest $postRequest, PostRepository $postRepository)
    {
        if (! $post->isAuthor()) {
            throw new PermissionDeniedException('文章无法更新, 你的权限还不够喔 (╯︵╰,)');
        }
        $postRepository->update($postRequest->validated(), $post);

        return $this->response()->noContent();
    }

    /**
     * 创建文章.
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
     * 删除文章.
     *
     * @param Post $post
     * @return \App\Support\Response\Response
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        // 如果文章作者是自己就可以删除
        if (! $post->isAuthor()) {
            throw new PermissionDeniedException('删除失败, 你的权限还不够喔 (╯︵╰,)');
        }
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
        $comments = $post->comments()
            ->latest()
            ->paginate($this->perPage());

        return $this->response()->paginator($comments, new CommentTransformer());
    }

    protected function voteResponse($model)
    {
        // TODO 这里不灵活 需要优化
        if ($model instanceof CanCountUpVotesModel || $model instanceof CanCountDownVotesModel) {
            return response()->json([
                'up_votes_count'   => $model->getUpVotesCount(),
                'down_votes_count' => $model->getDownVotesCount(),
            ]);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
