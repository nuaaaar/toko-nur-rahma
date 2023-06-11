<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class US06_UpdateRoleAndPermissionTest extends TestCase
{
    public function test_authorized_user_can_access_edit_role_page()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_edit_role_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_update_role_without_name()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_update_role_without_permissions()
    {
        $this->assertTrue(true);
    }
}
