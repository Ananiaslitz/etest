<?php

namespace Core\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @codeCoverageIgnore
 */
class Product extends Model
{
    protected $fillable = ['name', 'price', 'description'];

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_product')->withPivot('amount');
    }
}
