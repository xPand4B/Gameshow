<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasRandomStringId
{
    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = self::generateRandomStringId($model);
            }
        });
    }

    public static function generateRandomStringId($model)
    {
        $id = Str::random(18);

        if ($model::find($id) !== null) {
            self::generateRandomStringId($model);
        }

        return $id;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
