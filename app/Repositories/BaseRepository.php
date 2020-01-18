<?php

/*
 * This file is part of PHP CS Fixer.
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories;

trait BaseRepository
{
    /**
     * Get number of records.
     *
     * @param null|mixed $condition
     *
     * @return array
     */
    public function getNumber($param = null)
    {
        $model = $this->model;
        $this->setParam($model, $param);
        return $model->count();
    }

    /**
     * Update columns in the record by id.
     *
     * @param $id
     * @param $input
     *
     * @return App\Model|User
     */
    public function updateColumn($id, $input)
    {
        $this->model = $this->getById($id);

        foreach ($input as $key => $value) {
            $this->model->{$key} = $value;
        }

        return $this->model->save();
    }

    /**
     * Destroy a model.
     *
     * @param  $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * Get model by id.
     *
     * @param mixed      $id
     * @param null|mixed $param
     *
     * @return App\Model
     */
    public function getById($id, $param = null)
    {
        $model = $this->model;
        $this->setParam($model, $param);

        return $model->findOrFail($id);
    }

    /**
     * Get all the records.
     *
     * @param mixed $sortColumn
     * @param mixed $sort
     *
     * @return array User
     */
    public function all($sortColumn = 'id', $sort = 'asc')
    {
        return $this->model->orderBy($sortColumn, $sort)->get();
    }

    /**
     * Get number of the records.
     *
     * @param int    $number
     * @param string $sort
     * @param string $sortColumn
     *
     * @return Paginate
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Store a new record.
     *
     * @param  $input
     *
     * @return User
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    /**
     * Update a record by id.
     *
     * @param  $id
     * @param  $input
     * @param mixed $without
     *
     * @return User
     */
    public function update($id, $input, $without = false)
    {
        $model = $this->model;
        if ($without) {
            $model = $model->withoutGlobalScopes();
        }
        $model = $model->find($id);
        if (empty($model)) {
            return null;
        }

        return $this->save($model, $input);
    }

    /**
     * Save the input's data.
     *
     * @param  $model
     * @param  $input
     *
     * @return User
     */
    public function save($model, $input)
    {
        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * create model.
     *
     * @param input array
     * @param mixed $input
     *
     * @return model resource
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * 数据分页.
     *
     * @param int   $perPage
     * @param array $columns
     * @param mixed $condition
     * @param mixed $number
     * @param mixed $sort
     * @param mixed $sortColumn
     *
     * @return mixed
     */
    public function paginate($condition = '', $columns = ['*'], $number = 10, $sort = 'desc', $sortColumn = 'id')
    {
        return $this->model->select($columns)->orderBy($sortColumn, $sort)->paginate($number);
    }

    public function getValue($id, $columnName)
    {
        return $this->model->where('id', $id)->value($columnName);
    }

    public function deleteByCondition($condition)
    {
        return $this->model->where($condition)->delete();
    }

    public function getValueByCondition($condition, $columnName)
    {
        return $this->model->where($condition)->value($columnName);
    }

    public function deleteRecord($condition, $param_in = false)
    {
        return $this->model->where($condition)
                            ->when($param_in, function ($query) use ($param_in) {
                                return $query->whereIn($param_in['field'], $param_in['range']);
                            })
                            ->delete();
    }

    public function getPluck($columnName, $condition = null, $without = false, $orderBy = [])
    {
        $model = $this->model;
        if ($condition) {
            $model = $model->where($condition);
        }
        if ($without) {
            $model = $model->withoutGlobalScopes();
        }
        if ($orderBy) {
            $model = $model->orderBy($orderBy[0], $orderBy[1]);
        }

        return is_array($columnName) ? $model->pluck($columnName[0], \DB::raw($columnName[1])) : $model->pluck($columnName);
    }

    public function updateValue($param, $input)
    {
        $model = $this->model;
        $this->setParam($model, $param);

        return $model->update($input);
    }

    public function getDataList($param = null)
    {
        $model = $this->model;
        if (isset($param['fields'])) {
            $model = $model->select(\DB::raw($param['fields']));
        }
        if (isset($param['where'])) {
            foreach ($param['where'] as $key => $v) {
                if ($key === 'subquery') {
                    $model = $model->where(function ($query) use ($v) {
                        foreach ($v as $sub_key => $sub_v) {
                            $query->$sub_key($sub_v[0], $sub_v[1], $sub_v[2]);
                        }
                    });
                } else {
                    $model = $model->where($v[0], $v[1], $v[2]);
                }
            }
        }
        if (isset($param['or'])) {
            foreach ($param['or'] as $v) {
                $model = $model->orWhere($v[0], $v[1], $v[2]);
            }
        }
        if (isset($param['in'])) {
            $model = $model->whereIn($param['in']['field'], $param['in']['range']);
        }
        if (isset($param['notIn'])) {
            $model = $model->whereNotIn($param['notIn']['field'], $param['notIn']['range']);
        }
        if (isset($param['notNull'])) {
            $model = $model->whereNotNull($param['notNull']);
        }

        if (isset($param['notInMulti'])) {
            foreach ($param['notInMulti'] as $key => $value) {
                $model = $model->whereNotIn($value['field'], $value['range']);
            }
        }

        if (isset($param['orderBy'])) {
            foreach ($param['orderBy'] as $v) {
                $model = $model->orderBy($v[0], $v[1]);
            }
        }
        if (isset($param['without'])) {
            $model = $model->withoutGlobalScopes();
        }
        if (isset($param['whereRaw'])) {
            $model = $model->whereRaw($param['whereRaw']);
        }
        if (isset($param['join'])) {
            foreach ($param['join'] as $key => $value) {
                $model = $model->$key($value[0], $value[1], '=', $value[2]);
            }
        }
        if (isset($param['joinMulti'])) {
            foreach ($param['joinMulti'] as $value) {
                $joinMethod = $value[0];
                $model      = $model->$joinMethod($value[1], $value[2], '=', $value[3]);
            }
        }
        if (isset($param['status'])) {
            $model = $model->status($param['status']);
        }
        if (isset($param['groupBy'])) {
            foreach ($param['groupBy'] as $value) {
                $model = $model->groupBy($value);
            }
        }
        if (isset($param['offset'])) {
            $model = $model->offset($param['offset']);
        }
        if (isset($param['limit'])) {
            $model = $model->limit($param['limit']);
        }

        return isset($param['pageSize']) ? $model->paginate($param['pageSize']) : $model->get();
    }

    public function getData($param = null)
    {
        $model = $this->model;
        $this->setParam($model, $param);
        return $model->first();
    }

    public function insertAll($data)
    {
        return $this->model->insert($data);
    }

    public function getRecordByCondition($condition = [], $field = '*')
    {
        $result = $this->model->select($field)->where($condition)->first();

        return $result;
    }

    public function getRecordListByCondition($condition = [],
                                            $field = '*',
                                            $sortColumn = 'id',
                                            $sort = 'desc')
    {
        $result = $this->model->select($field)->where($condition)->orderBy($sortColumn, $sort)->get();

        return $result;
    }

    public function firstOrCreate($search, $data = false)
    {
        if ($data) {
            return $this->model->firstOrCreate($search, $data);
        }

        return $this->model->firstOrCreate($search);
    }

    public function updateOrCreate($search, $data = false)
    {
        if ($data) {
            return $this->model->updateOrCreate($search, $data);
        }

        return $this->model->updateOrCreate($search);
    }

    private function setParam(&$model, $param)
    {
        if (isset($param['where'])) {
            $model = $model->where($param['where']);
        }

        if (isset($param['without'])) {
            $model = $model->withoutGlobalScopes();
        }

        if (isset($param['or'])) {
            foreach ($param['or'] as $v) {
                $model = $model->orWhere($v[0], $v[1], $v[2]);
            }
        }

        if (isset($param['in'])) {
            $model = $model->whereIn($param['in']['field'], $param['in']['range']);
        }

        if (isset($param['orderBy'])) {
            foreach ($param['orderBy'] as $v) {
                $model = $model->orderBy($v[0], $v[1]);
            }
        }

        if (isset($param['joinMulti'])) {
            foreach ($param['joinMulti'] as $value) {
                $joinMethod = $value[0];
                $model      = $model->$joinMethod($value[1], $value[2], '=', $value[3]);
            }
        }

        if (isset($param['notNull'])) {
            $model = $model->whereNotNull($param['notNull']);
        }

        if (isset($param['fields'])) {
            $model = $model->select(\DB::raw($param['fields']));
        }
    }

    public function handleOrderBy($orderBy)
    {
        $temp = [];

        foreach (explode(',', $orderBy) as $field) {
            if (strchr($field, '-')) {
                array_push($temp, [str_replace('-', '', $field), 'desc']);
            } else {
                array_push($temp, [$field, 'asc']);
            }
        }
        return $temp;
    }

    public function validOrderBy($orderBy, $valid_fields)
    {
        foreach (explode(',', $orderBy) as $field) {
            if (!in_array(str_replace('-', '', $field), $valid_fields)) {
                return false;
            }
        }
        return true;
    }
}
