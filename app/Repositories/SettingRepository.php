<?php

namespace App\Repositories;


use App\Models\Setting;

class SettingRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Setting::class;
    }

    public function filterData(array &$data)
    {
        if (isset($data['description']))
            $data['description'] = e($data['description']);
        return $data;
    }

    public function preCreate(array &$data)
    {
        $data = $this->filterData($data);
        $data['creator_id'] = auth()->id();
        return $data;
    }

    public function preUpdate(array &$data)
    {
        return $this->filterData($data);
    }

    public function findByNameWithoutCache($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function allSettingWithoutCache()
    {
        return $this->model->withoutGlobalScope('notSystem')->recent()->get()->keyBy('name');
    }

    public function set($data)
    {
        foreach ($data as $name => $value) {
            if (!is_array($value)) {
                $value = ['value' => $value];
            }
            $this->model->withoutGlobalScope('notSystem')->updateOrCreate(['name' => $name], $value);
        }
    }
}
