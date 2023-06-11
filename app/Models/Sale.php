<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerReturns()
    {
        return $this->hasMany(CustomerReturn::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function customerReturnItems()
    {
        return $this->hasManyThrough(CustomerReturnItem::class, CustomerReturn::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
