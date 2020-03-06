<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::insert(["name" => "Daniel Pérez", "email" => "daniel.perez@swarm.cl", "join_date" => Carbon\Carbon::now()]);
    }
}
