<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Product Table Name
    |--------------------------------------------------------------------------
    |
    | User can specify their own product table name used in their application.
    | You can use this to dynamically query the product details.
    |
    */

    'product_table' => 'tbl_products',
    'models' => [
        'order'      => Smarttech\StripePayment\Models\Order::class,
        'order_item' => Smarttech\StripePayment\Models\OrderItem::class,
        'cart_item'  => Smarttech\StripePayment\Models\CartItem::class,
        'product'    => App\Models\Product::class, // Make this customizable too
        'layout' => 'layout.app',
        'hasMainContent' => 'content',
    ],
    'redirect_success' => 'product',
];
