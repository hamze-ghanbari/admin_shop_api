<?php

namespace App\Repository\Eloquent;

use App\Repository\Contracts\BaseRepositoryInterface;
use Closure;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = app($this->model());
    }

    abstract public function model();

    protected function getModel(){
        return $this->model;
    }

    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function first($columns = ['*'])
    {
        return $this->model->first($columns);
    }

    public function paginate($limit = 15, $columns = ['*'])
    {
        return $this->model->paginate($limit, $columns);
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function findByField($field, $value, $operator = null, $columns = ['*'])
    {
        return $this->model->where($field, $operator, $value)->get($columns);
    }

    public function findWhere(array $where)
    {
        return $this->model->where($where);
    }

    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereIn($field, $values)->get($columns);
    }

    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        return $this->model->whereNotIn($field, $values)->get($columns);
    }

    public function findWhereBetween($field, array $values, $columns = ['*'])
    {
        return $this->model->whereBetween($field, $values)->get($columns);
    }

    public function exists(array $where){
        return $this->findWhere($where)->exists();
    }

    public function when($value, callable $callback){
        return $this->model->when($value, $callback);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        return $this->model->find($id)->update($attributes);
    }

    public function delete(...$ids)
    {
        return $this->model->destroy(...$ids);
    }

    public function deleteWhere(array $where)
    {
        return $this->model->where($where)->destroy();
    }

    public function orderBy($column, $direction = 'asc')
    {
        return $this->model->orderBy($column, $direction);
    }

    public function with(array|string $relations)
    {
        return $this->model->with($relations);
    }

    public function has(string $relation): bool
    {
        return $this->model->has($relation);
    }

    public function whereHas(string $relation, closure $closure)
    {
        return $this->model->whereHas($relation, $closure)->get();
    }

}
