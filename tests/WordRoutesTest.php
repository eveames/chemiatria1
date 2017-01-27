<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use chemiatria\User;

class WordRoutesTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testWelcomeRoute()
    {
        $this->visit('/')
             ->see('Chemiatria');
    }

    public function testHomePageRedirection() {
        $this->call('GET', '/home');
        $this->assertRedirectedTo('login');
    }

    public function testWordsCreateRedirection() {
        $this->call('GET', '/words/create');
        $this->assertRedirectedTo('login');
    }

    public function testWordsUpdateRedirection() {
        $this->call('GET', '/words/1/edit');
        $this->assertRedirectedTo('login');
    }

    public function testTeacherCanViewCreateWord() {
        $user = new User([
            'name' => 'John Doe',
            'auth_type' => 'teacher',
        ]);
        $this->be($user);
        $this->call('GET', '/words/create');
        $this->assertResponseOk();
    }

    public function testTeacherCantViewEditWord() {
        $user = new User([
            'name' => 'John Doe',
            'auth_type' => 'teacher',
        ]);
        $this->be($user);
        $this->call('GET', '/words/1/edit');
        $this->assertRedirectedTo('/words/1');
        //$this->assertSessionHas('error');
    }

    public function testAdminCanViewEditWord() {
        $user = new User([
            'name' => 'Jane Doe',
            'auth_type' => 'admin',
        ]);
        $this->be($user);
        $response = $this->call('GET', '/words/1/edit');
        $this->assertEquals('302', $response->getStatusCode());
        $this->assertEquals(URL::to('/words/1/edit'));
        //$this->assertResponseOk();
    }

}
