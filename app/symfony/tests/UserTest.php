<?php

use App\Domain\ObjectMother\UserExample;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        $this->user = UserExample::adminUser();
    }

    public function test_that_GetEmail_works(): void
    {
        $email = $this->user->getEmail();
        $this->assertEquals($email, 'adminUser@test.com');
    }
}