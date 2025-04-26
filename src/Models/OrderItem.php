<?php

namespace Smarttech\StripePayment\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity','price'];
}
