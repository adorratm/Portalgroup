<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Add 10 Client To Starbucks Company Without Mernis
        for ($i = 0; $i < 10; $i++) {
            $this->db->table('clients')->insert($this->generateClient());
            $clientID = $this->db->insertID();
            $this->db->table("client_w_company")->insert(["client_id" => $clientID, "company_id" => 1]);
        }
        // Add 10 Client To Portal Group Company Without Mernis
        for ($i = 0; $i < 10; $i++) {
            $this->db->table('clients')->insert($this->generateClient());
            $clientID = $this->db->insertID();
            $this->db->table("client_w_company")->insert(["client_id" => $clientID, "company_id" => 2]);
        }
    }

    private function generateClient(): array
    {
        helper("text");
        $faker = Factory::create('tr_TR');
        return [
            'name' => $faker->name(),
            'email' => $faker->email,
            'identity' => str_pad(rand(0, pow(10, 11)-1), 11, '0', STR_PAD_LEFT),
            'birth_date' => $faker->date()
        ];
    }
}
