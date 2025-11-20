<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contrato;
use App\Models\User;
use Illuminate\Support\Carbon;

class ContratosDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (Contrato::count() > 0) {
            $this->command?->info('Contratos ya existen, se omite demo.');
            return;
        }

        $tipos = [
            'Prestación de servicios',
            'Obra',
            'Suministro',
            'Interadministrativo',
            'Consultoría',
        ];

        $users = User::pluck('id')->all();
        if (empty($users)) {
            $this->command?->warn('No hay usuarios para asociar contratos.');
            return;
        }

        $baseDate = now()->startOfMonth();

        foreach (range(1, 5) as $i) {
            Contrato::create([
                'numero' => sprintf('CT-%04d', $i),
                'tipo_contrato' => $tipos[array_rand($tipos)],
                'objeto' => 'Objeto del contrato de ejemplo #' . $i,
                'valor' => 10000000 * $i,
                'fecha_inicio' => $baseDate->copy()->subMonths(6 - $i)->toDateString(),
                'fecha_fin' => $baseDate->copy()->addMonths($i)->toDateString(),
                'user_id' => $users[array_rand($users)],
                'estado' => 'vigente',
            ]);
        }

        $this->command?->info('Contratos demo creados (con tipos).');
    }
}
