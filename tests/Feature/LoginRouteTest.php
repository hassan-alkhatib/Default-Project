<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginRouteTest extends TestCase
{
    public function test_login_page_uses_login_route(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $this->assertSame('http://localhost/login', route('login'));
    }
}
