<?php

namespace App\Repositories\Eloquent;

use Exception;
use Prettus\Repository\Eloquent\BaseRepository as PrettusBaseRepository;
use Prettus\Repository\Contracts\PresenterInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Presentable;

abstract class BaseRepository extends PrettusBaseRepository
{

    /**
     * Wrapper result data
     *
     * @param mixed $result Result
     *
     * @return mixed
     */
    public function parserResult($result)
    {
        if ($this->presenter instanceof PresenterInterface) {
            if ($result instanceof Collection || $result instanceof LengthAwarePaginator) {
                $result->each(function ($model) {
                    if ($model instanceof Presentable) {
                        $model->setPresenter($this->presenter);
                    }

                    return $model;
                });
            } elseif ($result instanceof Presentable) {
                $result = $result->setPresenter($this->presenter);
            }

            if (!$this->skipPresenter) {
                return $this->presenter->present($result);
            }
        }

        if ($result instanceof LengthAwarePaginator) {
            $response = $result->toArray();
            $response['items'] = $response['data'];
            unset($response['data']);
            $result = $response;
        }

        return $result;
    }

    /**
     * Find by Id
     *
     * @param type $id      Id
     * @param type $columns Column
     *
     * @return type
     */
    public function findWithoutFail($id, $columns = ['*'])
    {
        try {
            return $this->find($id, $columns);
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * First data by multiple fields
     *
     * @param array $where   List condition
     * @param array $columns Columns
     *
     * @return mixed
     */
    public function firstWhere(array $where, $columns = ['*'])
    {
        $this->applyScope();
        $this->applyCriteria();
        $this->applyConditions($where);
        $model = $this->model->select($columns)->first();
        $this->resetModel();
        return $this->parserResult($model);
    }

    /**
     * First data by multiple fields and throw exception if not found
     *
     * @param array $where   List condition
     * @param array $columns Columns
     *
     * @return mixed
     */
    public function firstOrFailWhere(array $where, $columns = ['*'])
    {
        $this->applyScope();
        $this->applyCriteria();
        $this->applyConditions($where);
        $model = $this->model->select($columns)->firstOrFail();
        $this->resetModel();
        return $this->parserResult($model);
    }

    /**
     * Create
     *
     * @param array $attributes Aattributes
     *
     * @return type
     */
    public function create(array $attributes)
    {
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::create($attributes);
        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attributes);
        $model->save();

        return $this->parserResult($model);
    }

    /**
     * Update
     *
     * @param array $attributes Attibutes
     * @param type  $id         Id
     *
     * @return type
     */
    public function update(array $attributes, $id)
    {
        $this->applyScope();
        $this->applyCriteria();

        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::update($attributes, $id);
        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attributes);
        $model->save();

        return $this->parserResult($model);
    }

    /**
     * Group by
     *
     * @param array|string $columns Columns
     *
     * @return \App\Repositories\Eloquent\AbstractRepository
     */
    public function groupBy($columns)
    {
        $this->model = $this->model->groupBy($columns);
        return $this;
    }

    /**
     * Update relation
     *
     * @param type $model      Model
     * @param type $attributes Attributes
     *
     * @return type
     */
    public function updateRelations($model, $attributes)
    {
        foreach ($attributes as $key => $val) {
            if (isset($model) &&
                method_exists($model, $key) &&
                is_a(@$model->$key(), 'Illuminate\Database\Eloquent\Relations\Relation')
            ) {
                $methodClass = get_class($model->$key($key));
                switch ($methodClass) {
                    case 'Illuminate\Database\Eloquent\Relations\BelongsToMany':
                        $newValues = array_get($attributes, $key, []);
                        if (array_search('', $newValues) !== false) {
                            unset($newValues[array_search('', $newValues)]);
                        }
                        $model->$key()->sync(array_values($newValues));
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\BelongsTo':
                        $modelKey = $model->$key()->getForeignKey();
                        $newValue = array_get($attributes, $key, null);
                        $newValue = $newValue == '' ? null : $newValue;
                        $model->$modelKey = $newValue;
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasOne':
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasOneOrMany':
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasMany':
                        $newValues = array_get($attributes, $key, []);
                        if (array_search('', $newValues) !== false) {
                            unset($newValues[array_search('', $newValues)]);
                        }

                        list($temp, $modelKey) = explode('.', $model->$key($key)->getForeignKey());

                        foreach ($model->$key as $rel) {
                            if (!in_array($rel->id, $newValues)) {
                                $rel->$modelKey = null;
                                $rel->save();
                            }
                            unset($newValues[array_search($rel->id, $newValues)]);
                        }

                        if (count($newValues) > 0) {
                            $related = get_class($model->$key()->getRelated());
                            foreach ($newValues as $val) {
                                $rel = $related::find($val);
                                $rel->$modelKey = $model->id;
                                $rel->save();
                            }
                        }
                        break;
                }
            }
        }

        return $model;
    }

    /**
     * Get the SQL representation of the query.
     *
     * @return string
     */
    public function toSql()
    {
        $this->applyScope();
        $this->applyCriteria();

        $sql = $this->model->toSql();

        $this->resetModel();

        return $sql;
    }

    /**
     * Get a fresh query builder instance for the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQuery()
    {
        $this->applyScope();
        $this->applyCriteria();

        $builder = $this->model->getQuery();

        $this->resetModel();

        return $builder;
    }
}
