<?php

namespace App\Treasures\Illuminate\Http\Resources;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Improvement, so the JsonResource can be used with array.
 */
trait JsonResourceOverride
{
    /**
     * @inheritdoc
     */
    protected function whenLoaded($relationship, $value = null, $default = null)
    {
        if (func_num_args() < 3) {
            $default = new MissingValue;
        }

        if (! $this->relationLoaded($this->resource, $relationship)) {
            return value($default);
        }

        $relationship = $this->formatRelationship($this->resource, $relationship);

        if (func_num_args() === 1) {
            return $this->resource[$relationship];
        }

        if ($this->resource[$relationship] === null) {
            return null;
        }

        return value($value);
    }

    protected function getRelation($relation, $data = null)
    {
        if (is_null($data)) {
            $data = $this->resource;
        }

        return data_get($data, $this->formatRelationship($data, $relation));
    }

    protected function relationLoaded($data, $relationship)
    {
        $relationship = $this->formatRelationship($data, $relationship);

        return (method_exists($data, 'relationLoaded') &&
                $data->relationLoaded($relationship)) ||
            (is_array($data) && Arr::has($data, $relationship));
    }

    protected function formatRelationship($data, $relationship)
    {
        return method_exists($data, 'relationLoaded') && method_exists($data, 'getRelation')
            ? $relationship
            : Str::snake($relationship);
    }

    /**
     * @inheritdoc
     */
    public static function collection($resource)
    {
        return new AnonymousResourceCollection($resource, get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return data_get($this->resource, $offset);
    }

    /**
     * @inheritdoc
     */
    public function __isset($key)
    {
        return ! is_null(data_get($this->resource, $key));
    }

    /**
     * @inheritdoc
     */
    public function __unset($key)
    {
        unset($this->resource[$key]);
    }

    /**
     * @inheritdoc
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }
}
