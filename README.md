# Larvel-Strip-Payment-Demo

<!-- <p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a> -->


<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" height="80">
  &nbsp;&nbsp;&nbsp;
  <img src="https://stripe.com/img/v3/home/twitter.png" alt="Stripe Logo" height="80">
  &nbsp;&nbsp;&nbsp;
  <img src="https://cdn-icons-png.flaticon.com/512/1170/1170627.png" alt="Order Icon" height="80">
</p>
<!-- </p> -->

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🚀 Laravel Stripe Order Payment Package by SmartTech

A plug-and-play Laravel package to manage and make an order for any e com web site and integrate the Stripe payment  with ease. This package includes routes, controllers, config files, components, views, and stubs — everything you need to get started with a blog section in your Laravel app.

---

## 📦 Features

- Fully flow fo striper payment with cart order and payment check pages 
- with order migration order, order items, cart items and many more 
- Slug-based routing
- Publishable views using stubs
- Blade components for easy integration
- Easy customization support

---


## 🔧 Technologies Used
- Laravel: The backend framework.
- MySQL: For database management.
- Bootstrap: For styling.

## ✅ **Requirements**

To run this project, ensure that the following prerequisites are met:

###  **PHP 8.0+**
- This project requires **PHP version 8.0** or higher for optimal performance and compatibility.

###  **Laravel 8+**
- The application is built using **Laravel 8** or newer, ensuring you have access to the latest Laravel features.

###  **Composer**
- **Composer** is required to manage PHP dependencies. If you haven't already, [download and install Composer](https://getcomposer.org/).

###  **Local Server (Laragon, XAMPP, WAMP)**
- A local server environment is needed for running the application:
  - **[Laragon](https://laragon.org/)** (Recommended for Windows users)
  - **[XAMPP](https://www.apachefriends.org/index.html)**
  - **[WAMP](http://www.wampserver.com/en/)**

###  **MySQL 5+**
- **MySQL version 5** or higher is required for database management and running migrations.


## 📦 Install this package 
### add in  your project Composer.json file 
```bash
    "repositories": [ { "type": "vcs", "url": "git@github.com:hemalkachhadiya/Larvel-Strip-Payment-Demo.git" } ],
```
### Install the package Via Composer
```bash
composer require smarttech/stripe-payment:@dev
```
### add the sercive Provider
**Note :** add the service provider path into the config;/app.php in the provider object
```bash
Smarttech\StripePayment\StripeServiceProvider::class,
```
### Publish the configuration 
```bash 
php artisan vendor:publish --tag=config
```
### clear the optimize 
```bash 
php artisan optimize:clear
```
### Run the Migration
```bash 
php artisan migrate
```
### Dump the composer 
```bash 
composer dump-autoload
```

## For addition Configuartion for this package 
###  Add The cart buttn and buy now buttn 
```bash 
    <form action="{{ route('cartstripe.add') }}" method="POST" style="display: inline;">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="amount" value="{{ $product->price }}">
        <input type="hidden" name="quantity" value="2">
        {{-- <button type="submit" class="btn btn-primary">Add to cart</button> --}}
        <button type="submit" class="btn btn-outline-dark btn-square" style="border: none; background: transparent;">
            <i class="fa fa-shopping-cart"></i>
        </button>
    </form>

```
**Note :** you can add the class but remember there existing class dont remove it.

###  search the cart icon and add the route for the cart 

```bash 
  <form action="{{ route('cartstripe.checkout') }}" method="POST" style="display: inline;">
        @csrf
        <input type="hidden" name="product_ids" value="{{ $product->id }}">
        <input type="hidden" name="price" value="{{ $product->price }}">
        <input type="hidden" name="qty" value="1">
        <input type="hidden" name="grandTotal" value="{{ $product->price }}">
        <button type="submit"  class="btn btn-outline-dark btn-square" >
            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
        </button>
    </form>
```
**Note :** you can add the class but remember there existing class dont remove it.




### cart icon have a count for the cart count add it 
```bash 
 {{ $cartItemCount }}
```
**Note :** now this add where you wnat the cart item count display the cart items 

**Note :** Please check out the cartItem.php in the config Folder where you customise the configuration for more reliablity.

## 🤝 Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## ⚖️ Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## 🛡️ Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## 📜 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
