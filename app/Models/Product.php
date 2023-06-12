<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function procurementItems()
    {
        return $this->hasMany(ProcurementItem::class);
    }

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function latestProductStock()
    {
        return $this->hasOne(ProductStock::class)->latestOfMany('date');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
