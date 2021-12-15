<?php

namespace App\Treasures\Illuminate;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Activable
{
    /**
     * Boot the activable trait for a model.
     *
     * @return void
     */
    public static function bootActivable()
    {
        static::addGlobalScope(new ActivableScope);
    }

    /**
     * Determine if the model instance has been inactivated.
     *
     * @return bool
     */
    public function inactivated()
    {
        return $this->{$this->getActiveIdentifierColumn()} == 0;
    }

    /**
     * Get the name of the "active identifier" column.
     *
     * @return string
     */
    public function getActiveIdentifierColumn()
    {
        return defined('static::ACTIVE_IDENTIFIER')
            ? static::ACTIVE_IDENTIFIER
            : 'flag_aktif';
    }

    /**
     * Get the fully qualified "active identifier" column.
     *
     * @return string
     */
    public function getQualifiedActiveIdentifierColumn()
    {
        return $this->qualifyColumn($this->getActiveIdentifierColumn());
    }
}
