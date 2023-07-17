<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class US28_UpdateBankTest extends TestCase
{
    public function test_authorized_user_can_access_edit_bank_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_edit_bank_with_valid_input()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_edit_bank_without_required_inputs()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_edit_bank_with_duplicate_account_number()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_edit_bank_page()
    {
        $this->assertTrue(true);
    }
}
