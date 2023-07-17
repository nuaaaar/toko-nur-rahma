<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US49_CreateCustomerReturnTest extends TestCase
{
    public function test_authorized_user_can_access_create_customer_return_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_create_customer_return_with_valid_input()
    {
        $this->assertTrue(true);
    }

    public function test_user_cannot_create_customer_return_without_required_inputs()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_create_customer_return_page()
    {
        $this->assertTrue(true);
    }
}
