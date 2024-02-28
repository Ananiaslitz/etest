<?php

namespace Core\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * AbstractRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Create a new record in the database.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update record in the database.
     *
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function update(array $data, int $id): Model
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    /**
     * Delete record from the database.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }

    /**
     * Show the record with the given id.
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }
}
