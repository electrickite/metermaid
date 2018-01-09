<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    const PROTOCOL_SCM = 0;
    const PROTOCOL_SCM_PLUS = 1;
    const PROTOCOL_IDM = 2;
    const PROTOCOL_R900 = 3;
    const PROTOCOL_R900BCD = 4;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function readings()
    {
        return $this->hasMany('App\Model\Reading');
    }

    public function takeReading($value)
    {
        $value = intval($value);
        $reading = new Reading(['value' => $value]);
        $reading->reset = $this->detectReset($value);
        return $this->readings()->save($reading);
    }

    public function consumptionForHour($time=null)
    {
        $time = $time ?: time();
        $last = $this->readings()->hourOf(strtotime('-1 hour', $time))->last();
        $current = $this->readings()->hourOf($time)->last();
        return $this->calculateConsumption($last, $current);
    }

    public function consumptionForDay($time=null)
    {
        $time = $time ?: time();
        $last = $this->readings()->dayOf(strtotime('-1 day', $time))->last();
        $current = $this->readings()->dayOf($time)->last();
        return $this->calculateConsumption($last, $current);
    }

    public function consumptionForWeek($time=null)
    {
        $time = $time ?: time();
        $last = $this->readings()->weekOf(strtotime('-1 week', $time))->last();
        $current = $this->readings()->weekOf($time)->last();
        return $this->calculateConsumption($last, $current);
    }

    public function consumptionForMonth($time=null)
    {
        $time = $time ?: time();
        $last = $this->readings()->monthOf(strtotime('-1 month', $time))->last();
        $current = $this->readings()->monthOf($time)->last();
        return $this->calculateConsumption($last, $current);
    }

    public function protocolString()
    {
        $strings = [
            self::PROTOCOL_SCM => 'scm',
            self::PROTOCOL_SCM_PLUS => 'scm+',
            self::PROTOCOL_IDM => 'idm',
            self::PROTOCOL_R900 => 'r900',
            self::PROTOCOL_R900BCD => 'r900bcd',
        ];

        return $strings[$this->protocol];
    }

    protected function calculateConsumption($last, $current)
    {
        if (!$last || !$current) { return 0; }
        return $current->value - $last->value;
    }

    protected function detectReset($value)
    {
        $last_reading = $this->readings()->last();
        return $last_reading && $value < $last_reading->value;
    }
}
