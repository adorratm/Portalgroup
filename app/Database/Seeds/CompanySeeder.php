<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        // Create Starbucks and Portal Group Companies
        $data = [
            [
                'name' => "Starbucks",
                'email' => "starbucks@gmail.com",
                'password' => password_hash("Starbucks12345", PASSWORD_BCRYPT)
            ],
            [
                'name' => "Portal Group",
                'email' => "portalgroup@gmail.com",
                'password' => password_hash("Portalgroup12345", PASSWORD_BCRYPT)
            ],
        ];
        $this->db->table("companies")->insertBatch($data);
    }
}
