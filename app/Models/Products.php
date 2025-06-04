<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $fillable = ['name', 'sku', 'description', 'branch_id', 'store_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'stocks')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function getSalesCountAttribute()
    {
        return $this->sales()->count();
    }
    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
    public function getTransfersCountAttribute()
    {
        return $this->transfers()->count();
    }
}
