<?php

namespace App\Support\Response;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Scope;


class TransformerResponse implements Responsable
{
    /**
     * @var FractalManager
     */
    protected static $fractalManager;
    /**
     * The include query string key.
     *
     * @var string
     */
    protected $includeKey = 'include';
    /**
     * The include separator.
     *
     * @var string
     */
    protected $includeSeparator = ',';
    /**
     * Indicates if eager loading is enabled.
     *
     * @var bool
     */
    protected $eagerLoading = true;
    /**
     * @var ResourceInterface
     */
    protected $resource = null;
    protected $meta = [];
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public static function getFractalManager()
    {
        return static::$fractalManager;
    }

    public static function setFractalManager(FractalManager $fractalManager)
    {
        static::$fractalManager = $fractalManager;
    }

    /**
     * @return TransformerResponse
     */
    public function item($item, $transformer = null)
    {
        $this->resource = new Item($item, $transformer);
        return $this;
    }

    /**
     * @return TransformerResponse
     */
    public function collection(Collection $collection, $transformer = null)
    {
        $this->resource = new FractalCollection($collection, $transformer);
        return $this;
    }

    /**
     * @return TransformerResponse
     */
    public function paginator(Paginator $paginator, $transformer = null)
    {
        $collection = $paginator->getCollection();
        $this->resource = new FractalCollection($collection, $transformer);
        $this->resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $this;
    }

    public function toResponse($request)
    {
        $this->resource->setMeta($this->meta);
        $this->response->setContent($this->fractalCreateData());

        return $this->response->toResponse($request);
    }

    private function fractalCreateData($scopeIdentifier = null, Scope $parentScopeInstance = null)
    {

        if (!isset(static::$fractalManager)) {
            static::setFractalManager(app(FractalManager::class));
        }

        $this->parseFractalIncludes(request());
        if (!$this->resource->getTransformer()) {
            $this->resource->setTransformer($this->fetchDefaultTransformer($this->resource->getData()));
        }

        if ($this->shouldEagerLoad($this->resource)) {
            $eagerLoads = $this->mergeEagerLoads($this->resource->getTransformer(), static::$fractalManager->getRequestedIncludes());
            if (!empty($eagerLoads))
                $this->resource->getData()->load($eagerLoads);
        }
        return static::$fractalManager->createData($this->resource, $scopeIdentifier, $parentScopeInstance)->toArray();
    }

    /**
     * Parse the includes.
     *
     * @param Request $request
     *
     * @return void
     */
    public function parseFractalIncludes(Request $request)
    {
        $includes = $request->input($this->includeKey);

        if (!is_array($includes)) {
            $includes = array_filter(explode($this->includeSeparator, $includes));
        }

        static::$fractalManager->parseIncludes($includes);
    }

    /**
     * Tries to fetch a default transformer for the given data.
     *
     * @param  mixed $data
     *
     * @return \League\Fractal\TransformerAbstract|null
     */
    protected function fetchDefaultTransformer($data)
    {
        if (($data instanceof LengthAwarePaginator || $data instanceof Collection) && $data->isEmpty()) {
            return null;
        }

        $classname = $this->getClassnameFrom($data);

        if ($this->hasDefaultTransformer($classname)) {
            $transformer = config('api.transformers.' . $classname);
        } else {
            $classBasename = class_basename($classname);

            if (!class_exists($transformer = "App\\Transformers\\{$classBasename}Transformer")) {
                throw new \Exception("No transformer for {$classname}");
            }
        }
        return new $transformer;
    }

    /**
     * Get the class name from the given object.
     *
     * @param  object $object
     *
     * @return string
     */
    protected function getClassnameFrom($object)
    {
        if ($object instanceof LengthAwarePaginator or $object instanceof Collection) {
            return get_class(array_first($object));
        }

        if (!is_string($object) && !is_object($object)) {
            throw new \Exception("No transformer of \"{$object}\"found.");
        }

        return get_class($object);
    }

    /**
     * Check if the class has a default transformer.
     *
     * @param  string $classname
     *
     * @return bool
     */
    protected function hasDefaultTransformer($classname)
    {
        return !is_null(config('api.transformers.' . $classname));
    }

    /**
     * Eager loading is only performed when the response is or contains an
     * Eloquent collection and eager loading is enabled.
     * @param ResourceInterface $resource
     * @return bool
     */
    protected function shouldEagerLoad(ResourceInterface $resource)
    {
        $data = $resource->getData();
        if ($data instanceof Paginator) {
            $data = $data->getCollection();
        }

        return !is_null($resource->getTransformer()) && $this->eagerLoading && $data instanceof EloquentCollection;
    }

    /**
     * Get includes as their array keys for eager loading.
     *
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string|array $requestedIncludes
     *
     * @return array
     */
    protected function mergeEagerLoads($transformer, $requestedIncludes)
    {
        $includes = array_merge($requestedIncludes, $transformer->getDefaultIncludes());
        $includes = array_intersect($includes, $transformer->getAvailableIncludes());
        $eagerLoads = [];

        foreach ($includes as $key => $value) {
            $eagerLoads[] = camel_case(is_string($key) ? $key : $value);
        }

        return $eagerLoads;
    }

    /**
     * Add a meta data key/value pair.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return TransformerResponse
     */
    public function addMeta($key, $value)
    {
        $this->meta[$key] = $value;
        return $this;
    }

    /**
     * Get the binding meta data.
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set the meta data for the binding.
     *
     * @param array $meta
     *
     * @return TransformerResponse
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;
        return $this;
    }

    public function __call($method, $arguments)
    {
        return $this->response->$method(...$arguments);
    }

    /**
     * Disable eager loading.
     *
     * @return TransformerResponse
     */
    public function disableEagerLoading()
    {
        $this->eagerLoading = false;

        return $this;
    }

    /**
     * Enable eager loading.
     *
     * @return TransformerResponse
     */
    public function enableEagerLoading()
    {
        $this->eagerLoading = true;

        return $this;
    }
}