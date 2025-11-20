<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleSeeder::class);
    $this->call(UsersRolesSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(DepartamentosMunicipiosSeeder::class);
        $this->call(ContratosDemoSeeder::class);

        // Crear un usuario de prueba si no existe
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
        $this->call(CuentaCobroDemoSeeder::class);
    }
}
