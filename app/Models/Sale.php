<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = ['product_id', 'store_id', 'quantity', 'sold_at', 'branch_id'];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
