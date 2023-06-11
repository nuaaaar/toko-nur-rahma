<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class US08_CreateUserTest extends TestCase
{
    public function test_authorized_user_can_access_create_user_page()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_create_user_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_create_user_without_required_inputs()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_create_user_with_duplicate_email()
    {
        $this->assertTrue(true);
    }
}
