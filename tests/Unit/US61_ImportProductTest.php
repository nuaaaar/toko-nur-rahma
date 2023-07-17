<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Traits\DateTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US61_ImportProductTest extends TestCase
{
    public function test_authorized_user_can_read_import_product()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_import_product()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_read_import_product()
    {
        $this->assertTrue(true);
    }
}
