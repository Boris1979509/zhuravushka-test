<?php

namespace Tests\Unit\Models\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @var $service
     */
    // private $sevice;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRegister(): void
    {
        $user = make_user()->getAttributes(); // functions.test.php
        $user = User::register($user);
        $this->assertNotEmpty($user);
        $this->assertEquals(User::ROLE_USER, $user->role); // user
        $this->assertFalse($user->isAdmin()); // not admin
        //$this->assertEquals(now()->format('Y-m-d H:i:s'), $user->email_verified_at);
    }
}
