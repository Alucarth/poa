<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Rol;
class RoleModuleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @test
     */
    

    function role_list_page()
    {
        $rol = new Rol();
        $rol->name='administrador';
        $rol->description='Administrador del sistema';
        $rol->save();

        $rol = new Rol();
        $rol->name='doctor';
        $rol->description='Medico de la clinica';
        $rol->save();
        
        $this->get('roles')
             ->assertStatus(200)
             ->assertSee("administrador")
             ->assertSee("doctor");
        
        
    }
    // /** @test */
    // function role_view_detail(){

    //     $this->get('roles/1')
    //     ->assertStatus(200)
    //     ->assertSee("Mostrando 1");
    //    //  ->assertSee("Mostrando XD");
    //     $this->assertTrue(true);
    // }
    // /** @test */
    // function role_detail_page()
    // {

    //     $role = new Rol();
    //     $role->name='Medico';
    //     $role->description='Medico de la clinica';
    //     $role->save();
        
    //     $this->get('roles/'.$role->id)
    //          ->assertStatus(200)
    //          ->assertSee("Medico");
    //         //  ->assertSee("Mostrando XD");
    //     $this->assertTrue(true);
    // }

   
}
