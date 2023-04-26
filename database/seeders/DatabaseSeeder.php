<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        /*$user = User::create([
            'name' => 'Carlos Escate Roman',
            'email' => 'stornblood6969@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);
        $user2 = User::create([
            'name' => 'Administrador',
            'email' => 'prinmig70@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Clari'), // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);
        $user3 = User::create([
            'name' => 'Rubén Tipiani',
            'email' => 'rtipiani@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);*/
        //$role = \Spatie\Permission\Models\Role::create(['name' => 'administrador']);
        $role2 = \Spatie\Permission\Models\Role::create(['name' => 'colaborador']);
        /*$user->assignRole($role);
        $user2->assignRole($role);
        $user3->assignRole($role);*/
    }
}
