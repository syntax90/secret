<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class DataObjectHistory extends Model
{
    protected $table = 'data_objects_history';
    
    protected $fillable = [
        'key', 'value', 'revision', 'object_id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
