<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataObject extends Model
{
    protected $fillable = [
        'key', 'value',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->revision = 1;
        });

        // save one copy to history when a record is updated
        self::saved(function ($model) {
            DataObjectHistory::create([
                'key' => $model->key,
                'value' => $model->value,
                'revision' => $model->revision,
            ]);
        });
    }
}
