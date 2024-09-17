<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'name' => 'Steffani',
            'last_name' => 'Castro',
            'email' => 'steffani.castro@codant.one',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $superadmin->assignRole('SuperAdmin');

        $admin = User::create([
            'name' => 'Admin',
            'last_name' => '',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $admin->assignRole('Administrador');

        $user_app = User::create([
            'name' => 'App',
            'last_name' => '',
            'email' => 'app@gmail.com',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $user_app->assignRole('App');

        $user_app_2 = User::create([
            'name' => 'Steffani',
            'last_name' => 'Castro',
            'email' => 'steffani.castro.useche@gmail.com',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $user_app_2->assignRole('App');


        $operator = User::create([
            'name' => 'Panelista',
            'last_name' => '',
            'email' => 'panelista@gmail.com',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $operator->assignRole('Panelista');
        
    }
}
