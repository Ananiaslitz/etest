<?php

namespace Core\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @codeCoverageIgnore
 */
class Sale extends Model
{
    protected $fillable = ['amount'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product')->withPivot('amount');
    }
}
