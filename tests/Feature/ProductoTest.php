<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Database\Seeders\ProductoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    private function usuarioAutenticado(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    public function test_usuario_puede_ver_catalogo(): void
    {
        $this->usuarioAutenticado();
        $this->seed(ProductoSeeder::class);

        $response = $this->get('/catalogo');
        $response->assertStatus(200);
        $response->assertSee('Catálogo de productos');
        $response->assertSee('Coca Cola 600ml');
    }

    public function test_usuario_puede_crear_producto(): void
    {
        $this->usuarioAutenticado();

        $categoria = Categoria::create(['nombre' => 'Bebidas']);

        $response = $this->post('/catalogo', [
            'codigo' => 'TEST-999',
            'nombre' => 'Producto Prueba Test',
            'categoria_id' => $categoria->id,
            'precio' => 29.50,
            'stock' => 15,
            'stock_max' => 50,
        ]);

        $response->assertRedirect('/catalogo');
        $this->assertDatabaseHas('productos', [
            'codigo' => 'TEST-999',
            'nombre' => 'Producto Prueba Test',
        ]);
    }
}
