<?php

namespace UIIGateway\Castle\Http\Resources;

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
    public static function collection($resource)
    {
        return new AnonymousResourceCollection($resource, get_called_class());
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
        if (is_array($this->resource)) {
            unset($this->resource[$key]);
        } else {
            unset($this->resource->{$key});
        }
    }

    /**
     * @inheritdoc
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
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
    protected function whenLoaded($relationship, $value = null, $default = null)
    {
        if (func_num_args() < 3) {
            $default = new MissingValue;
        }

        if (! $this->relationLoaded($this->resource, $relationship)) {
            return value($default);
        }

        $relationship = $this->formatRelationship($this->resource, $relationship);

        $relationshipValue = data_get($this->resource, $relationship);

        if (func_num_args() === 1) {
            return $relationshipValue;
        }

        if ($relationshipValue === null) {
            return null;
        }

        return value($value);
    }

    protected function relationLoaded($data, $relationship)
    {
        $relationship = $this->formatRelationship($data, $relationship);

        return (is_object($data) && method_exists($data, 'relationLoaded') &&
                $data->relationLoaded($relationship)) ||
            (is_object($data) && isset($data->{$relationship})) ||
            (is_array($data) && Arr::has($data, $relationship));
    }

    protected function formatRelationship($data, $relationship)
    {
        return (is_object($data) &&
            method_exists($data, 'relationLoaded') &&
            method_exists($data, 'getRelation'))
            ? $relationship
            : Str::snake($relationship);
    }

    protected function getRelation($relation, $data = null)
    {
        if (is_null($data)) {
            $data = $this->resource;
        }

        return data_get($data, $this->formatRelationship($data, $relation));
    }
}
