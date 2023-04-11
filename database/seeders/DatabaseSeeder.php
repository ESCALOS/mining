<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = User::factory()->create([
             'name' => 'Carlos Escate Roman',
             'email' => 'stornblood6969@gmail.com',
        ]);

        $role = \Spatie\Permission\Models\Role::create(['name' => 'administrador']);
        $user->assignRole($role);
    }
}
