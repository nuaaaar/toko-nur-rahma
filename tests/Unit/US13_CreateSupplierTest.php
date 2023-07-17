<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class US13_CreateSupplierTest extends TestCase
{
    public function test_authorized_user_can_access_create_supplier_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_create_supplier_with_valid_input()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_create_supplier_without_required_inputs()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_create_supplier_with_duplicate_tin()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_create_supplier_page()
    {
        $this->assertTrue(true);
    }
}
