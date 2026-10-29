<?php

namespace Tests\Feature;

use App\Models\Torta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TortaStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_formulario_muestra_campo_stock_con_etiqueta(): void
    {
        $response = $this->get('/tortas/nuevo');

        $response->assertStatus(200);
        $response->assertSee('Stock');
        $response->assertSee('name="stock"', false);
    }

    public function test_validacion_stock_requerido_y_mensajes_en_castellano(): void
    {
        $response = $this->post('/tortas/nuevo', [
            'sabor' => 'Chocolate',
            'precio' => 50,
            // stock omitido
        ]);

        $response->assertSessionHasErrors([
            'stock' => 'Indica el stock de la torta.',
        ]);

        $responseInvalid = $this->post('/tortas/nuevo', [
            'sabor' => 'Chocolate',
            'precio' => 50,
            'stock' => 'no-es-numero',
        ]);

        $responseInvalid->assertSessionHasErrors([
            'stock' => 'El stock debe ser un número entero.',
        ]);
    }

    public function test_se_crea_torta_con_stock_y_se_muestra_en_la_lista(): void
    {
        // Crear una torta previa con stock 0
        Torta::create([
            'sabor' => 'Tres Leches',
            'precio' => 45,
            'stock' => 0,
        ]);

        // Registrar nueva torta a través del formulario con stock asignado
        $response = $this->post('/tortas/nuevo', [
            'sabor' => 'Selva Negra',
            'precio' => 60,
            'stock' => 12,
        ]);

        $response->assertRedirect('/tortas');

        $this->assertDatabaseHas('tortas', [
            'sabor' => 'Selva Negra',
            'precio' => 60,
            'stock' => 12,
        ]);

        // Verificar la lista
        $responseLista = $this->get('/tortas');
        $responseLista->assertStatus(200);
        $responseLista->assertSee('Selva Negra');
        $responseLista->assertSee('Stock: 12');
        $responseLista->assertSee('Stock: 0');
    }
}
