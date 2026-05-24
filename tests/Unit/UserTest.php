<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_user_has_correct_fillable_properties()
    {
        $user = new User;
        $this->assertEquals(
            ['name', 'email', 'password', 'phone', 'role', 'photo_path'],
            $user->getFillable()
        );
    }
}
