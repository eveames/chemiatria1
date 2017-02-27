<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use chemiatria\User;

class RoutesTest extends TestCase
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
}
