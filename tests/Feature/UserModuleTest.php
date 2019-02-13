<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Rol;
class UserModuleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @test
     */
    public function user_list_page()
    {
        $user = new User;
        $user->username='keyrus';
        $user->name='David Torrez';
        $user->email='ltorrez@gmail.com';
        $user->password= bcrypt('123456');
        $user->save();

        $this->get('users')
             ->assertStatus(200)
             ->assertSee('David Torrez')
             ->assertSee('Usuarios');
        $this->assertTrue(true);
    }

    /** @test */
    public function user_detail_page(){
        
        $user = new User;
        $user->username='keyrus';
        $user->name='David Torrez';
        $user->email='ltorrez@gmail.com';
        $user->password= bcrypt('123456');
        $user->save();

        $role = new Rol();
        $role->name='Medico';
        $role->description='Medico de la clinica';
        $role->save();

        $user->roles()->attach($role->id);

        $this->get('users/'.$user->id)
             ->assertStatus(200)
             ->assertSee('David Torrez')
             ->assertSee('keyrus')
             ->assertSee('ltorrez@gmail.com')
             ->assertSee('Medico');
        $this->assertTrue(true);

    }
}
