@extends(config('cartstripe.models.layout'))
    @section(config('cartstripe.models.hasMainContent'))
<h2>Payment</h2>
<form action="{{ route('cartstripe.stripe.payment') }}" method="POST" id="payment-form">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <div id="card-element"></div>
    <button type="submit">Pay</button>
</form>
@endsection
@section(config('cartstripe.models.hasscript'))
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');
</script>
@endsection
