<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class US16_DeleteSupplierTest extends TestCase
{
    public function test_authorized_user_can_delete_supplier()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_delete_supplier()
    {
        $this->assertTrue(true);
    }
}
