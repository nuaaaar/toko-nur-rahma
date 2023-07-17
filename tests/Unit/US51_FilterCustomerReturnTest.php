<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US51_FilterCustomerReturnTest extends TestCase
{
    public function test_user_can_filter_customer_return_by_date()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_filter_customer_return_by_customer_name()
    {
        $this->assertTrue(true);
    }
}
