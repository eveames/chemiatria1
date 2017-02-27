<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use chemiatria\User;
use chemiatria\Helpers\SessionPlanHelper;

class SessionPlanHelperTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
      $user = new User([
          'name' => 'John Doe',
          'auth_type' => 'teacher',
      ]);
      //$this->be($user);
      $this->assertTrue(FormatProgress($user) === 'John Doe');
    }
}
