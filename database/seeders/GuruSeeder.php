<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        Guru::create([
            'username' => 'guru',
            'password' => Hash::make('123456'), // password akan di-hash
        ]);
    }
}
