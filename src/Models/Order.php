<?php

namespace Smarttech\StripePayment\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address', 'city', 'state','order_status','order_total'];
}
