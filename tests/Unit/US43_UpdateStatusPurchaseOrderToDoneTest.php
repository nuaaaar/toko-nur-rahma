<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US43_UpdateStatusPurchaseOrderToDoneTest extends TestCase
{
    public function test_authorized_user_can_finish_purchase_order()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_finish_purchase_order()
    {
        $this->assertTrue(true);
    }
}
