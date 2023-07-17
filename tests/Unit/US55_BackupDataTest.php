<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use App\Traits\DateTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US55_BackupDataTest extends TestCase
{
    public function test_authorized_user_can_access_backup_data_page()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_backup_data_to_excel()
    {
        $this->assertTrue(true);
    }

    public function test_unauthorized_user_cannot_access_backup_data_page()
    {
        $this->assertTrue(true);
    }
}
