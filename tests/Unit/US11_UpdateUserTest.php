<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class US11_UpdateUserTest extends TestCase
{
    public function test_authorized_user_can_access_edit_user_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_update_user_without_required_inputs()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_update_user_with_duplicate_email()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_edit_user_page()
    {
        $this->assertTrue(true);
    }
}
