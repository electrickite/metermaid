<?php

use Phinx\Seed\AbstractSeed;
use App\Model\Reading;

class MeterSeeder extends AbstractSeed
{
    public function run()
    {
        $start_time = time() - 31536000;

        $data = [
            [
                'id'         => 1,
                'name'       => 'Electric',
                'identifier' => '1234',
                'utility'    => 'Electricity',
                'protocol'   => 0,
                'type'       => 12,
                'unit'       => 'kWh',
                'multiplier' => 10.0,
                'disabled'   => false,
                'created_at' => date('Y-m-d H:i:s', $start_time),
                'updated_at' => date('Y-m-d H:i:s', $start_time),
            ],[
                'id'         => 2,
                'name'       => 'Gas',
                'identifier' => '5678',
                'utility'    => 'Natural gas',
                'protocol'   => 1,
                'type'       => 4,
                'unit'       => 'CuFt',
                'multiplier' => 1.0,
                'disabled'   => false,
                'created_at' => date('Y-m-d H:i:s', $start_time),
                'updated_at' => date('Y-m-d H:i:s', $start_time),
            ]
        ];

        $meters = $this->table('meters');
        $meters->insert($data)
               ->save();

        $readings = $this->table('readings');
        $value1 = 1015000;
        $value2 = 475500;

        for ($i = 0; $i < 8760; $i++) {
            $current_time = ($i * 3600) + $start_time;
            $value1 = intval($value1 + $this->getRandomValue(125, 50));
            $value2 = intval($value2 + $this->getRandomValue(170, 50));
            $date1 = date('Y-m-d H:i:s', $this->getRandomValue($current_time, 420, false));
            $date2 = date('Y-m-d H:i:s', $this->getRandomValue($current_time, 420, false));

            $data = [
                [
                    'meter_id'    => 1,
                    'value'       => $value1,
                    'reset'       => false,
                    'created_at'  => $date1,
                    'updated_at'  => $date1,
                ],[
                    'meter_id'    => 2,
                    'value'       => $value2,
                    'reset'       => false,
                    'created_at'  => $date2,
                    'updated_at'  => $date2,
                ]
            ];

            $readings->insert($data)
                     ->save();
        }
    }

    protected function getRandomValue($start, $var, $symmetric=true)
    {
        $min = $symmetric ? -100 : 0;
        $modifier = rand($min, 100) * 0.01;
        return $start + ($modifier * $var);
    }
}
