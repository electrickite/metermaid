<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function meter()
    {
        return $this->belongsTo('App\Model\Meter');
    }
}