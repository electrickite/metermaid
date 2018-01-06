<?php

use Phinx\Seed\AbstractSeed;

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
        $reading1 = ['value' => 1015000];
        $reading2 = ['value' => 475500];

        for ($i = 0; $i < 8760; $i++) {
            $current_time = ($i * 3600) + $start_time;
            $value1 = intval($reading1['value'] + $this->getRandomValue(125, 50));
            $value2 = intval($reading2['value'] + $this->getRandomValue(170, 50));
            $date1 = date('Y-m-d H:i:s', $this->getRandomValue($current_time, 420));
            $date2 = date('Y-m-d H:i:s', $this->getRandomValue($current_time, 420));

            $reading1 = [
                'meter_id'    => 1,
                'value'       => $value1,
                'consumption' => $value1 - $reading1['value'],
                'interval'    => 0,
                'reset'       => false,
                'inferred'    => false,
                'created_at'  => $date1,
                'updated_at'  => $date1,
            ];

            $reading2 = [
                'meter_id'    => 2,
                'value'       => $value2,
                'consumption' => $value2 - $reading2['value'],
                'interval'    => 0,
                'reset'       => false,
                'inferred'    => false,
                'created_at'  => $date2,
                'updated_at'  => $date2,
            ];

            $readings->insert([$reading1, $reading2])
                     ->save();
        }
    }

    protected function getRandomValue($start, $var)
    {
        $modifier = rand(-100, 100) * 0.01;
        return $start + ($modifier * $var);
    }
}
