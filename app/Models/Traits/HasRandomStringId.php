<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasRandomStringId
{
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = self::generateRandomStringId($model);
            }
        });
    }

    public static function generateRandomStringId($model): string
    {
        $id = Str::random(24);

        if ($model::find($id) !== null) {
            self::generateRandomStringId($model);
        }

        return $id;
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }
}
