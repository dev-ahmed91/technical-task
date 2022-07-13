<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price_include_vat',
        'vat_value',
        'shipping_cost',
        'merchant_id'
    ];

    public function merchant()
    {
        $this->belongsTo(Merchant::class);
    }
}
