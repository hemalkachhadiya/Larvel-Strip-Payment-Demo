<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment</title>
</head>
<body>
@if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
<form action="{{ route('stripe.payment') }}" method="post" id="payment-form">
    @csrf
    <input type="hidden" name="amount" value="{{ $amount }}">
    
    <input type="hidden" name="product_id" value="{{ $product_id }}">
    <!-- Include Stripe Elements and Token script here -->
    <script
        src="https://checkout.stripe.com/checkout.js"
        class="stripe-button"
        data-key="{{ env('STRIPE_KEY') }}"
        data-amount="{{ $amount }}"
        data-name="SmartTech"
        data-description="Test payment"
        data-currency="inr">
    </script>
    {{-- <button type="submit">Pay ₹{{ $amount }}</button> --}}
</form>

</body>
</html>
