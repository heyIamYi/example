<?php

namespace App\Repositories;

use App\Traits\CustomerRepositoryTrait;
use App\Traits\RepositoryTrait;
use Illuminate\Support\Facades\Schema;

class BaseRepository
{
    // 引用trait
    use RepositoryTrait;
    use CustomerRepositoryTrait;

    protected $model;
    protected $keywordSearchFields = [];
    protected $orderBy = ['sort' => 'asc', 'id' => 'desc'];
    protected $with = [];

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->model, $method], $parameters);
    }

    /**
     * 條件查詢：
     * $criteria 傳入條件名稱
     * $with     傳入關聯資料
     * $orderBy  傳入排序
     */
    protected function findByCriteria($criteria, $orderBy = null, $with = [])
    {
        $query = $this->model->query();
        if ($with) {
            $query->with($with);
        }
        if (!empty($criteria['keyword'])) {
            $query->where(function ($q) use ($criteria) {
                foreach ($this->keywordSearchFields as $field) {
                    if ($this->isFieldSearchable($field)) {
                        $q->orWhere($field, 'like', '%' . $criteria['keyword'] . '%');
                    }
                }
            });
        }
        if ($criteria['is_show'] === '') {
            $criteria['is_show'] = null;
        }
        if (isset($criteria['is_show']) && !is_null($criteria['is_show']) && $this->isFieldSearchable('is_show')) {
            $query->where('is_show', $criteria['is_show']);
        }

        if ($orderBy) {
            foreach ($orderBy as $column => $direction) {
                if ($this->isFieldSearchable($column)) {
                    // throw new Exception("欄位 $column 不存在或不可用於排序");
                    $query->orderBy($column, $direction);
                }

            }
        }

        return $query;
    }

    public function getData($criteria)
    {
        $query = $this->findByCriteria($criteria, $this->orderBy, $this->with);
        if (isset($criteria['is_status']) && $criteria['is_status'] != '') {
            $query->where('state', $criteria['is_status']);
        }
        return $query->paginate(10);
    }

    /**
     * 確認欄位是否存在於Molel
     */
    protected function isFieldSearchable($field)
    {
        return Schema::hasColumn($this->model->getTable(), $field);
    }

    public function setOrderBy(array $orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setWith($with)
    {
        $this->with = $with;
        return $this;
    }

    /**
     * 資料狀態相關修改
     */
    public function isShow($value, $id = null)
    {
        if ($id) {
            $data = $this->model->find($id);
            $data->update([
                'is_show' => $value,
            ]);
        } else {
            $data = $this->model->create([
                'is_show' => $value,
            ]);
        }
    }

    public function isIndex($value, $id = null)
    {
        if ($id) {
            $data = $this->model->find($id);
            $data->update([
                'is_index' => $value,
            ]);
        } else {
            $data = $this->model->create([
                'is_index' => $value,
            ]);
        }
    }

    public function isHot($value, $id = null)
    {
        if ($id) {
            $data = $this->model->find($id);
            $data->update([
                'is_hot' => $value,
            ]);
        } else {
            $data = $this->model->create([
                'is_hot' => $value,
            ]);
        }
    }

    public function isNew($value, $id = null)
    {
        if ($id) {
            $data = $this->model->find($id);
            $data->update([
                'is_new' => $value,
            ]);
        } else {
            $data = $this->model->create([
                'is_new' => $value,
            ]);
        }
    }

    public function sort($value, $id = null)
    {
        if ($id) {
            $data = $this->model->find($id);
            $data->update([
                'sort' => $value,
            ]);
        } else {
            $data = $this->model->create([
                'sort' => $value,
            ]);
        }
    }

}
