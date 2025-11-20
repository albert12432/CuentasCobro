<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersRolesSeeder extends Seeder
{
    public function run(): void
    {
        $usersToSeed = [
            [
                'name' => 'Contratista Demo',
                'email' => 'contratista@example.com',
                'password' => 'Demo1234*',
                'role' => 'contratista',
            ],
            [
                'name' => 'Ordenador del Gasto',
                'email' => 'ordenador@example.com',
                'password' => 'Demo1234*',
                'role' => 'ordenador_gasto',
            ],
            [
                'name' => 'Contratación',
                'email' => 'contratacion@example.com',
                'password' => 'Demo1234*',
                'role' => 'contratacion',
            ],
            [
                'name' => 'Tesorería',
                'email' => 'tesoreria@example.com',
                'password' => 'Demo1234*',
                'role' => 'tesoreria',
            ],
            [
                'name' => 'Supervisor',
                'email' => 'supervisor@example.com',
                'password' => 'Demo1234*',
                'role' => 'supervisor',
            ],
            [
                'name' => 'Alcalde',
                'email' => 'alcalde@example.com',
                'password' => 'Demo1234*',
                'role' => 'alcalde',
            ],
        ];

        foreach ($usersToSeed as $data) {
            $role = Role::where('name', $data['role'])->first();
            if (!$role) {
                $this->command->warn("Rol no encontrado: {$data['role']}. Omite usuario {$data['email']}");
                continue;
            }
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role_id' => $role->id,
                    'email_verified_at' => now(),
                ]
            );

            // Ensure role assignment
            if ($user->role_id !== $role->id) {
                $user->update(['role_id' => $role->id]);
            }

            $this->command->info("Usuario listo: {$data['email']} ({$data['role']})");
        }
    }
}
