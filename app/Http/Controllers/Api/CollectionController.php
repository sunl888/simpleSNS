<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\CollectionRequest;
use App\Models\Collection;
use App\Repositories\CollectionRepository;
use App\Traits\FollowTrait;
use App\Transformers\CollectionTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CollectionController extends ApiController
{
    use FollowTrait;
    protected static $model;

    public function __construct()
    {
        static::$model = Collection::class;
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

    public function update(Collection $collection, CollectionRequest $request, CollectionRepository $collectionRepository)
    {
        $collectionRepository->update($request->validated(), $collection);
        return $this->response()->noContent();
    }

    public function index(Request $request)
    {
        $collections = Collection::ApplyFilter($request)
            ->paginate($this->perPage());
        return $this->response()->collection($collections, new CollectionTransformer());
    }

    /**
     * @param Collection $collection
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Collection $collection)
    {
        if ($collection->user_id == auth()->id())
            $collection->delete();
        else {
            throw new ModelNotFoundException('删除失败');
        }
        return $this->response()->noContent();
    }
}
