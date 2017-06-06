<?php

use App\Utils\Database;
use App\Models\Customer;
use Illuminate\Database\Seeder;

/**
 * Class CustomerSeeder
 */
class CustomerSeeder extends Seeder
{
    const TABLE = 'customers';

    /**
     * @var \Illuminate\Database\Connection
     */
    public $database;

    /**
     * CustomerSeeder constructor.
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
        factory(Customer::class, 4)->create();
    }
}
