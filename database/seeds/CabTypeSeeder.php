<?php

use Carbon\Carbon;
use App\Utils\Database;
use Illuminate\Database\Seeder;

/**
 * Class CabTypeSeeder
 */
class CabTypeSeeder extends Seeder
{
    const TABLE = 'cab_types';

    /**
     * @var \Illuminate\Database\Connection
     */
    public $database;

    /**
     * Available type of cabs.
     *
     * @var array
     */
    private $types  = [
        'pink'      => [
            'per_min'   => 6,
            'per_km'    => 7
        ],
        'general'   => [
            'per_min'   => 1,
            'per_km'    => 2
        ]
    ];

    /**
     * CabTypeSeeder constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database->mysql();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // truncate before insert.
        $this
            ->database
            ->table(self::TABLE)
            ->truncate();

        // Insert the data.
        $this
            ->database
            ->table(self::TABLE)
            ->insert($this->getData());
    }

    /**
     * Get Data to insert.
     *
     * @return array
     */
    private function getData()
    {
        $data   = [];

        foreach ($this->types as $type => $price) {
            $data[] = [
                'type'              => $type,
                'price_per_km'      => $price['per_km'],
                'price_per_minute'  => $price['per_min'],
                'created_at'        => Carbon::now()
            ];
        }

        return $data;
    }
}
