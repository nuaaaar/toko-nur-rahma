<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerReturn extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerReturnItems()
    {
        return $this->hasMany(CustomerReturnItem::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
