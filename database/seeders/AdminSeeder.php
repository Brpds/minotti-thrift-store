<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@admin.com',
                'nome' => 'Admin',
                'password' => bcrypt('admin'),
                'role' => 'admin'
            ],
        );

        User::updateOrCreate(
            [
                'email' => 'developer@developer.com',
                'nome' => 'Dev01',
                'password' => bcrypt('developer'),
                'role' => 'admin'
            ],
        );

    }
}
