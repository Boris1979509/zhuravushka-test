<?php

namespace Tests\Models\User\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testChangeRole(): void
    {
        /**
         * @var User $user
         */
        $user = create_user(['role' => User::ROLE_USER]);
        self::assertFalse($user->isAdmin());
        $user->changeRole(User::ROLE_ADMIN);
        self::assertTrue($user->isAdmin());
    }

    /**
     * @return void
     */
    public function testAlready(): void
    {
        /**
         * @var User $user
         */
        $user = create_user(['role' => User::ROLE_ADMIN]);
        $this->expectExceptionMessage('Role is already assigned.');
        $user->changeRole(User::ROLE_ADMIN);
    }

    /**
     * @return void
     */
    public function testUndefined(): void
    {
        $user = create_user(['role' => User::ROLE_MODERATOR]);
        $this->expectExceptionMessage('Undefined role "' . $user->role . '"'); // Проверка сообщения в исключении.
        $user->changeRole(User::ROLE_MODERATOR);
    }
}
