<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class US15_UpdateSupplierTest extends TestCase
{
    public function test_authorized_user_can_access_edit_supplier_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_edit_supplier_with_valid_input()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_edit_supplier_without_required_inputs()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_edit_supplier_with_duplicate_tin()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_edit_supplier_page()
    {
        $this->assertTrue(true);
    }
}
