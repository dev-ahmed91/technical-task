<?php

namespace App\Models;

use App\Enums\TranslationType;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id'
    ];

    public function getName(string $locale)
    {
        return $this->hasOne(ProductTranslation::class)
            ->where('type', TranslationType::$NAME)
            ->where('locale', $locale)->first()->text;
    }

    public function getDescription(string $locale)
    {
        return $this->hasOne(ProductTranslation::class)
            ->where('type', TranslationType::$DESCRIPTION)
            ->where('locale', $locale)->first()->text;
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
