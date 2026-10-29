<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categorías iniciales
        $categorias = [
            'Bebidas' => 'Refrescos, aguas y jugos',
            'Botanas' => 'Papas, frituras y galletas',
            'Panadería' => 'Pan de caja, bollería y repostería',
            'Lácteos' => 'Leche, quesos y huevos',
            'Limpieza' => 'Artículos para el hogar y cuidado personal',
        ];

        $categoriasMap = [];
        foreach ($categorias as $nombre => $descripcion) {
            $categoriasMap[$nombre] = Categoria::firstOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => $descripcion]
            );
        }

        // 2. Productos iniciales de ejemplo
        $productos = [
            [
                'codigo' => '001',
                'nombre' => 'Coca Cola 600ml',
                'categoria' => 'Bebidas',
                'precio' => 18.00,
                'stock' => 25,
                'stock_max' => 50,
            ],
            [
                'codigo' => '002',
                'nombre' => 'Sabritas Original',
                'categoria' => 'Botanas',
                'precio' => 15.00,
                'stock' => 40,
                'stock_max' => 50,
            ],
            [
                'codigo' => '003',
                'nombre' => 'Pan Bimbo Grande',
                'categoria' => 'Panadería',
                'precio' => 45.00,
                'stock' => 10,
                'stock_max' => 50,
            ],
            [
                'codigo' => '004',
                'nombre' => 'Leche Lala 1L',
                'categoria' => 'Lácteos',
                'precio' => 26.00,
                'stock' => 18,
                'stock_max' => 50,
            ],
            [
                'codigo' => '005',
                'nombre' => 'Galletas Marías',
                'categoria' => 'Botanas',
                'precio' => 22.00,
                'stock' => 30,
                'stock_max' => 50,
            ],
            [
                'codigo' => '006',
                'nombre' => 'Agua Ciel 1L',
                'categoria' => 'Bebidas',
                'precio' => 12.00,
                'stock' => 4,
                'stock_max' => 50,
            ],
            [
                'codigo' => '007',
                'nombre' => 'Jabón Zote',
                'categoria' => 'Limpieza',
                'precio' => 20.00,
                'stock' => 0,
                'stock_max' => 50,
            ],
            [
                'codigo' => '008',
                'nombre' => 'Huevo (docena)',
                'categoria' => 'Lácteos',
                'precio' => 48.00,
                'stock' => 12,
                'stock_max' => 50,
            ],
        ];

        foreach ($productos as $p) {
            Producto::updateOrCreate(
                ['codigo' => $p['codigo']],
                [
                    'nombre' => $p['nombre'],
                    'categoria_id' => $categoriasMap[$p['categoria']]->id ?? null,
                    'precio' => $p['precio'],
                    'stock' => $p['stock'],
                    'stock_max' => $p['stock_max'],
                ]
            );
        }
    }
}
