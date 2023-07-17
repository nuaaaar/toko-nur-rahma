<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US50_ReadCustomerReturnTest extends TestCase
{
    public function test_authorized_user_can_read_customer_return()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_read_customer_return()
    {
        $this->assertTrue(true);
    }
}
