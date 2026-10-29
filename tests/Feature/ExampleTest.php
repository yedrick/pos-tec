<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Prueba que la raíz redirija al login si no hay sesión.
     */
    public function test_root_redirects_to_login_when_guest(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}
