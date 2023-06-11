<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
