<?php

namespace App\Traits;
use Illuminate\Support\Facades\File;

trait RepositoryTrait
{
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function delete($id)
    {
        $model = $this->model->find($id);

        if (!$model) {
            return false;
        }

        return $model->delete();
    }

    public function save()
    {
        return $this->model->save();
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function where($column, $operator = null, $value = null)
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = "=";
        }

        return $this->model->where($column, $operator, $value);
    }

    public function take($limit)
    {
        return $this->model->take($limit)->get();
    }

    public function paginate($perPage = 10)
    {
        $results = $this->model->paginate($perPage);

        return $results;
    }

    public function orderBy($column, $direction = 'asc')
    {
        return $this->model->orderBy($column, $direction);
    }

    public function plunk($keyColumn, $valueColumn = null)
    {
        if (is_null($valueColumn)) {
            return $this->model->get([$keyColumn])->pluck($keyColumn)->toArray();
        }

        $collection = $this->model->get([$keyColumn, $valueColumn]);
        return $collection->mapWithKeys(function ($item) use ($keyColumn, $valueColumn) {
            return [$item[$keyColumn] => $item[$valueColumn]];
        });
    }
}
