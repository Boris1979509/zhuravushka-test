<?php

namespace Tests\Unit\Models\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testNew(): void
    {
        $user = User::new('name', 'email', 'phone');
        $this->assertNotEmpty($user);
    }
}
