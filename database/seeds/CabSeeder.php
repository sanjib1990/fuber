<?php

use App\Models\Cab;
use App\Utils\Database;
use Illuminate\Database\Seeder;

/**
 * Class CabSeeder
 */
class CabSeeder extends Seeder
{
    const TABLE = 'cabs';

    /**
     * @var \Illuminate\Database\Connection
     */
    public $database;

    /**
     * CabSeeder constructor.
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
        factory(Cab::class)->times(20)->create();
    }
}
