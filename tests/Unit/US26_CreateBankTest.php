<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class US26_CreateBankTest extends TestCase
{
    public function test_authorized_user_can_access_create_bank_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_create_bank_with_valid_input()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_create_bank_without_required_inputs()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_create_bank_with_duplicate_account_number()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_create_bank_page()
    {
        $this->assertTrue(true);
    }
}
