<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;

class AssignRolesDynamicSeeder extends Seeder
{
    public function run(): void
    {
        // Definir roles por usuario (email => rol)
        $assignments = [
            'santisanchez21456@gmail.com' => 'alcalde',
            'daniel00250@hotmail.com' => 'supervisor',
            'dabenitez@gmail.com' => 'contratista',
            'storres@gmail.com' => 'ordenador_gasto',
            'jcalderon@gmail.com'=>'tesoreria',
        ];

        foreach ($assignments as $email => $roleName) {
            $user = User::where('email', $email)->first();
            $role = Roles::where('name', $roleName)->first();

            if ($user && $role) {
                $user->role_id = $role->id;
                $user->save();
                $this->command->info("✅ Rol '{$roleName}' asignado a: {$email}");
            } else {
                $this->command->warn("⚠️ Usuario o rol no encontrado para: {$email}");
            }
        }
    }
}
