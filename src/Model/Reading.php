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

    public function scopeFromMeter($query, $meter)
    {
        return $query->where('meter_id', $meter->id);
    }

    public function scopeHourOf($query, $time)
    {
        return $query->where('created_at', '>', date('Y-m-d H:00:00', $time))
                     ->where('created_at', '<=', date('Y-m-d H:59:59', $time));
    }

    public function scopeDayOf($query, $time)
    {
        return $query->where('created_at', '>', $this->toDateTime(strtotime('midnight', $time)))
                     ->where('created_at', '<', $this->toDateTime(strtotime('tomorrow', $time)));
    }

    public function scopeWeekOf($query, $time)
    {
        return $query->where('created_at', '>', $this->toDateTime(strtotime('this week', $time)))
                     ->where('created_at', '<', $this->toDateTime(strtotime('next week', $time)));
    }

    public function scopeMonthOf($query, $time)
    {
        return $query->where('created_at', '>', $this->toDateTime(strtotime('first day of this month', $time)))
                     ->where('created_at', '<', $this->toDateTime(strtotime('first day of next month', $time)));
    }

    public function scopeLast($query)
    {
        return $query->orderBy('created_at', 'desc')->first();
    }

    protected function toDateTime($time)
    {
        return date('Y-m-d H:i:s', $time);
    }
}
