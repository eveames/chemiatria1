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

    public function testWordsCreateRedirection() {
        $this->call('GET', '/words/create');
        $this->assertRedirectedTo('login');
    }

    public function testWordsUpdateRedirection() {
        $this->call('GET', '/words/1/edit');
        $this->assertRedirectedTo('login');
    }

    public function testTeacherCanCreateWord() {
        $user = new User([
            'name' => 'John Doe',
            'auth_type' => 'teacher',
        ]);
        $this->be($user);
        $this->call('GET', '/words/create');
        $this->assertResponseOk();
    }

    public function testTeacherCantEditWord() {
        $user = new User([
            'name' => 'John Doe',
            'auth_type' => 'teacher',
        ]);
        $this->be($user);
        $this->call('GET', '/word/1/edit');
        $this->assertRedirectedTo('/words/1');
        $this->assertSessionHas('error');
    }
}
