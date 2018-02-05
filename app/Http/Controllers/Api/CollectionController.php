<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\Api;

use App\Models\Collection;
use Illuminate\Http\Request;
use App\Events\SubscribedEvent;
use App\Http\Controllers\ApiController;
use App\Http\Requests\CollectionRequest;
use App\Repositories\CollectionRepository;
use App\Transformers\CollectionTransformer;
use App\Exceptions\PermissionDeniedException;

class CollectionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['show', 'index']);
    }

    // 订阅/取消订阅收藏集
    public function toggleSubscribe(Collection $collection)
    {
        $result = me()->toggleSubscribe($collection);
        if ($result['detached'] == []) {
            event(new SubscribedEvent($collection, me()));
        }
    }

    public function show(Collection $collection)
    {
        return $this->response()->item($collection, new CollectionTransformer());
    }

    public function store(CollectionRequest $request, CollectionRepository $collectionRepository)
    {
        $collectionRepository->create($request->validated());

        return $this->response()->noContent();
    }

    /**
     * @param Collection $collection
     * @param CollectionRequest $request
     * @param CollectionRepository $collectionRepository
     * @return mixed
     * @throws PermissionDeniedException
     */
    public function update(Collection $collection, CollectionRequest $request, CollectionRepository $collectionRepository)
    {
        if (! $collection->isAuthor()) {
            throw new PermissionDeniedException('更新失败, 你的权限还不够喔 (╯︵╰,)');
        }
        $collectionRepository->update($request->validated(), $collection);

        return $this->response()->noContent();
    }

    public function index(Request $request)
    {
        $collections = Collection::ApplyFilter($request)
            ->paginate($this->perPage());

        return $this->response()->paginator($collections, new CollectionTransformer());
    }

    /**
     * @param Collection $collection
     * @return mixed
     * @throws PermissionDeniedException
     * @throws \Exception
     */
    public function destroy(Collection $collection)
    {
        if (! $collection->isAuthor()) {
            throw new PermissionDeniedException('删除失败, 你的权限还不够喔 (╯︵╰,)');
        }

        $collection->delete();

        return $this->response()->noContent();
    }
}
