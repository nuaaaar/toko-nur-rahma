<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReturnItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function customerReturn()
    {
        return $this->belongsTo(CustomerReturn::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
