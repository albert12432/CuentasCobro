<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;
use App\Models\Municipio;

class DepartamentosMunicipiosSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Amazonas' => ['Leticia'],
            'Antioquia' => ['Medellín', 'Bello', 'Envigado', 'Itagüí'],
            'Arauca' => ['Arauca', 'Arauquita'],
            'Atlántico' => ['Barranquilla', 'Soledad'],
            'Bolívar' => ['Cartagena', 'Magangué'],
            'Boyacá' => ['Tunja', 'Duitama'],
            'Caldas' => ['Manizales', 'Villamaría'],
            'Caquetá' => ['Florencia', 'Belén de los Andaquíes'],
            'Casanare' => ['Yopal', 'Aguazul'],
            'Cauca' => ['Popayán', 'Santander de Quilichao'],
            'Cesar' => ['Valledupar', 'Aguachica'],
            'Chocó' => ['Quibdó', 'Istmina'],
            'Córdoba' => ['Montería', 'Lorica'],
            'Cundinamarca' => ['Bogotá', 'Soacha', 'Chía'],
            'Guainía' => ['Inírida'],
            'Guaviare' => ['San José del Guaviare'],
            'Huila' => ['Neiva', 'Pitalito'],
            'La Guajira' => ['Riohacha', 'Maicao'],
            'Magdalena' => ['Santa Marta', 'Ciénaga'],
            'Meta' => ['Villavicencio', 'Acacías'],
            'Nariño' => ['Pasto', 'Ipiales'],
            'Norte de Santander' => ['Cúcuta', 'Ocaña'],
            'Putumayo' => ['Mocoa', 'Puerto Asís'],
            'Quindío' => ['Armenia', 'Calarcá'],
            'Risaralda' => ['Pereira', 'Dosquebradas'],
            'San Andrés y Providencia' => ['San Andrés'],
            'Santander' => ['Bucaramanga', 'Floridablanca'],
            'Sucre' => ['Sincelejo', 'Corozal'],
            'Tolima' => ['Ibagué', 'Espinal'],
            'Valle del Cauca' => ['Cali', 'Palmira', 'Buenaventura'],
            'Vaupés' => ['Mitú'],
            'Vichada' => ['Puerto Carreño'],
        ];

        foreach ($data as $depName => $municipios) {
            // Evitar duplicados si ya existen en base de datos importada
            $dep = Departamento::firstOrCreate(['nombre' => $depName]);
            foreach ($municipios as $mun) {
                Municipio::firstOrCreate([
                    'nombre' => $mun,
                    'departamento_id' => $dep->id
                ]);
            }
        }
    }
}
