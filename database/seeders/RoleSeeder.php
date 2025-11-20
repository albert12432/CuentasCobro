<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔹 Definir los permisos
        $permissions = [
            // Cuentas de cobro
            'create_cuenta_cobro',
            'view_own_cuenta_cobro',
            'edit_own_cuenta_cobro',
            'upload_documents',
            'view_contract_info',
            'view_cuenta_cobro',
            'review_cuenta_cobro',
            'approve_cuenta_cobro',
            'reject_cuenta_cobro',
            'add_comments',
            'request_corrections',
            'view_all_cuenta_cobro',
            'final_approval',
            'override_decisions',
            'view_reports',

            // Administración del sistema
            'manage_users',
            'system_admin',

            // Ordenador del gasto
            'authorize_payment',
            'view_budget',
            'manage_budget',
            'generate_payment_orders',
            'view_financial_reports',

            // Tesorería
            'process_payment',
            'generate_checks',
            'bank_transfers',
            'payment_confirmation',
            'financial_reports',

            // Contratación
            'manage_contracts',
            'manage_contractors',
            'contract_validation',
            'contractor_registration',
            'contract_reports',
        ];

        // 🔹 Crear permisos si no existen
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 🔹 Definir roles y sus permisos
        $rolesData = [
            'contratista' => [
                'permissions' => [
                    'create_cuenta_cobro',
                    'view_own_cuenta_cobro',
                    'edit_own_cuenta_cobro',
                    'upload_documents',
                    'view_contract_info'
                ],
                'description' => 'Contratista - Presenta cuentas de cobro'
            ],
            'supervisor' => [
                'permissions' => [
                    'view_cuenta_cobro',
                    'review_cuenta_cobro',
                    'approve_cuenta_cobro',
                    'reject_cuenta_cobro',
                    'add_comments',
                    'request_corrections'
                ],
                'description' => 'Supervisor - Revisa y valida las cuentas de cobro'
            ],
            'alcalde' => [
                'permissions' => [
                    'view_all_cuenta_cobro',
                    'final_approval'
                ],
                'description' => 'Alcalde - Autoriza decisiones finales sobre cuentas de cobro'
            ],
           'ordenador_gasto' => [
    'permissions' => [
        'view_cuenta_cobro',
        'authorize_payment',
        'view_budget',
        'manage_budget',
        'generate_payment_orders',
        'view_financial_reports',
        'manage_users',   // necesario para editar usuarios
        'manage_roles',   // necesario para editar roles
    ],
    'description' => 'Ordenador del Gasto - Autoriza pagos y gestiona roles de usuarios'
],


            'tesoreria' => [
                'permissions' => [
                    'view_cuenta_cobro',
                    'process_payment',
                    'generate_checks',
                    'bank_transfers',
                    'payment_confirmation',
                    'financial_reports'
                ],
                'description' => 'Tesorería - Procesa los pagos'
            ],
            'contratacion' => [
                'permissions' => [
                    'manage_contracts',
                    'manage_contractors',
                    'view_all_cuenta_cobro',
                    'contract_validation',
                    'contractor_registration',
                    'contract_reports'
                ],
                'description' => 'Contratación - Administra contratos y contratistas'
            ],
            'super_admin' => [
                'permissions' => [
                    'system_admin',
                    'manage_users',
                    'override_decisions'
                ],
                'description' => 'Administrador del sistema - Control total del software'
            ]
        ];

        // 🔹 Crear roles y asignar permisos
        foreach ($rolesData as $roleName => $data) {
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['description' => $data['description']]
            );

            $role->permissions()->sync(
                Permission::whereIn('name', $data['permissions'])->pluck('id')->toArray()
            );
        }

        $this->command->info('Roles y permisos creados exitosamente.');
    }
}
