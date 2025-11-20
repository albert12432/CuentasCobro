<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuentaCobro;
use App\Models\ItemCuentaCobro;

class CuentaCobroDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (CuentaCobro::count() > 0) {
            $this->command?->info('Cuentas de cobro ya existen, se omite demo.');
            return;
        }

        $cuenta = CuentaCobro::create([
            'numero' => 'CC-0001',
            'fecha_emision' => now()->toDateString(),
            'valor_total' => 0, // se recalcula luego
            'departamento' => 'Cundinamarca',
            'municipio' => 'Bogotá',
            'descripcion' => 'Cuenta de cobro de ejemplo',
            'tipo_identificacion' => 'CC',
            'identificacion' => '1234567890',
            'tipo_cliente' => 'natural',
            'nombre_beneficiario' => 'Usuario Demo',
            'plazo_pago' => 30,
        ]);

        $items = [
            ['item' => 'Servicio profesional', 'detalle' => 'Consultoría', 'cantidad' => 1, 'precio_unitario' => 1500000],
            ['item' => 'Gastos administrativos', 'detalle' => 'Transporte', 'cantidad' => 2, 'precio_unitario' => 50000],
        ];

        $total = 0;
        foreach ($items as $it) {
            ItemCuentaCobro::create(array_merge($it, ['cuenta_cobro_id' => $cuenta->id]));
            $total += $it['cantidad'] * $it['precio_unitario'];
        }

        $cuenta->update(['valor_total' => $total]);
        $this->command?->info('Cuenta de cobro demo creada.');
    }
}
