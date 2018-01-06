<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function readings()
    {
        return $this->hasMany('App\Model\Reading');
    }
}
