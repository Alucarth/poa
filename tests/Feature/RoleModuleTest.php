<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleModuleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @test
     */
    public function role_list_page()
    {
        $this->get('/roles')
             ->assertStatus(200)
             ->assertSee("roles");
        // $this->assertTrue(true);
    }

    public function role_detail_page()
    {
        $this->get('/role/1')
             ->assertStatus(200)
             ->assertSee("mostrando rol 1");
    }
}
