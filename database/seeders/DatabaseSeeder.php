<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Crea un utente senza ruolo
        $this->createUserWithRoles([
            'name' => 'Steven Manson (User)',
            'email' => 'user@aulab.it',
            'password' => Hash::make('password'),
        ]);

        // Crea un utente con ruolo writer
        $this->createUserWithRoles([
            'name' => 'Daria Richardson (Writer)',
            'email' => 'writer@aulab.it',
            'password' => Hash::make('password'),
        ], [
            'is_writer' => true,
        ]);

        // Crea un utente con ruolo revisor
        $this->createUserWithRoles([
            'name' => 'Antony Delgado (Revisor)',
            'email' => 'revisor@aulab.it',
            'password' => Hash::make('password'),
        ], [
            'is_revisor' => true,
        ]);

        // Crea un amministratore
        $this->createUserWithRoles([
            'name' => 'Steve Lorren (Admin)',
            'email' => 'admin@aulab.it',
            'password' => Hash::make('password'),
        ], [
            'is_admin' => true,
        ]);

        // Crea un super amministratore con tutti i ruoli
        $this->createUserWithRoles([
            'name' => 'Mario Bianchi (Super admin)',
            'email' => 'super.admin@aulab.it',
            'password' => Hash::make('password'),
        ], [
            'is_writer' => true,
            'is_revisor' => true,
            'is_admin' => true,
        ]);

        // Crea un utente attacker senza ruoli
        $this->createUserWithRoles([
            'name' => 'Kevin Ross (Attacker)',
            'email' => 'kvrs@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }

    private function createUserWithRoles(array $userData, array $roles = []): User
    {
        $user = User::create($userData);

        $user->forceFill([
            'is_writer' => $roles['is_writer'] ?? false,
            'is_revisor' => $roles['is_revisor'] ?? false,
            'is_admin' => $roles['is_admin'] ?? false,
        ])->save();

        return $user;
    }
}
