<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackupDataController extends Controller
{
    public function index()
    {
        return view('dashboard.backup-data.index');
    }
}
