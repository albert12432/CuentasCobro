<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar el rol de ordenador_gasto
        $ordenadorRole = Role::where('name', 'ordenador_gasto')->first();

        if (!$ordenadorRole) {
            $this->command->error('El rol de ordenador_gasto no existe. Ejecuta primero el RoleSeeder.');
            return;
        }

        // Crear usuario administrador como ordenador del gasto
        $admin = User::firstOrCreate(
            ['email' => 'daniel00250@hotmail.com'],
            [
                'name' => 'Daniel Ramirez',
                'email' => 'daniel00250@hotmail.com',
                'password' => Hash::make('cosita1225*'),
                'role_id' => $ordenadorRole->id,
                'email_verified_at' => now(),
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('✅ Usuario creado exitosamente como Ordenador del Gasto:');
            $this->command->info('   👤 Nombre: Daniel Ramirez');
            $this->command->info('   📧 Email: daniel00250@hotmail.com');
            $this->command->info('   🔑 Contraseña: cosita1225*');
            $this->command->info('   👑 Rol: Ordenador del Gasto');
        } else {
            $this->command->info('ℹ️  El usuario ya existe.');

            // Actualizar el rol si es necesario
            if ($admin->role_id !== $ordenadorRole->id) {
                $admin->update(['role_id' => $ordenadorRole->id]);
                $this->command->info('✅ Rol actualizado a Ordenador del Gasto.');
            }
        }
    }
}
