<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();

    public function create(array $data)
    {
        if (method_exists($this, 'preCreate')) {
            $data = $this->preCreate($data);
        }
        $model = $this->model->create($data);
        if (method_exists($this, 'created')) {
            $this->created($data, $model);
        }
        return $model;
    }

    public function update(array $data, $model)
    {
        if (method_exists($this, 'preUpdate')) {
            $data = $this->preUpdate($data, $model);
        }
        $model = $this->findModel($model);
        $updated = $model->update($data);
        if ($updated && method_exists($this, 'updated')) {
            $this->updated($data, $model);
        }
        return $updated;
    }

    public function findModel($model)
    {
        if ($model instanceof Model)
            return $model;
        else {
            return $this->model->findOrFail($model);
        }
    }

}
