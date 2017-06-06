<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CabTypeSeeder::class);
        $this->call(CabSeeder::class);
        $this->call(CustomerSeeder::class);
    }
}
