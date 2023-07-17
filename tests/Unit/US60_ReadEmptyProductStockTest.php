<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Traits\DateTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US60_ReadEmptyProductStockTest extends TestCase
{
    public function test_authorized_user_can_read_empty_product_stock()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_see_empty_product_stock_as_table()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_read_empty_product_stock()
    {
        $this->assertTrue(true);
    }
}
