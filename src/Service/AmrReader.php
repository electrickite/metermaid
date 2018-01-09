<?php

namespace App\Service;

use App\Model\Meter;
use App\Model\Reading;

class AmrReader
{
    protected $binary_path = '/usr/local/bin/rtlamr';

    public function __construct($path = null)
    {
        if ($path) { $this->binary_path = $path; }
    }

    public function read($meter)
    {
        $this->findMeter($meter);
        if ($meter->disabled) { return; }

        $value = $this->getMeterReading($meter);

        if ($value !== false) {
            return $meter->takeReading($value);
        } else {
            return false;
        }
    }

    public function readAll()
    {
        $result = true;
        foreach (Meter::all() as $meter) {
            if (!$this->read($meter)) {
                $result = false;
            }
        }
        return $result;
    }

    protected function findMeter(&$meter)
    {
        if (is_int($meter)) {
            $meter = Meter::find($meter);
        }
    }

    protected function getMeterReading($meter)
    {
        $msg = $meter->protocolString();
        $id = $meter->identifier;
        $type = $meter->type;
        $key = $this->consumptionMessageKey($meter->protocol);

        try {
            for ($i = 0; $i <= 1; $i++) {
                exec("{$this->binary_path} -msgtype={$msg} -format=json -filterid={$id} -filtertype={$type} -single=true -duration=3m 2>/dev/null", $output);
                $result = json_decode(implode("\n", $output), true);
                if (!empty($result)) { break; }
            }

            if (isset($result['Message'][$key]) && $result['Message'][$key] > 0) {
                return $result['Message'][$key];
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    protected function consumptionMessageKey($protocol)
    {
        switch ($protocol) {
            case Meter::PROTOCOL_IDM:
                return 'LastConsumptionCount';
            default:
                return 'Consumption';
        }
    }
}
