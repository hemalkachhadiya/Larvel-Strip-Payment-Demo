{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> {{  \Illuminate\Support\Str::ucfirst(auth()->user()->name)  }} Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .cart-table th, .cart-table td {
            vertical-align: middle;
            text-align: center;
        }
        .empty-cart-msg {
            padding: 3rem
        }
    </style>
</head>
<body> --}}

    @extends(config('cartstripe.models.layout'))
    @section(config('cartstripe.models.hasMainContent'))
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">🛒 {{  \Illuminate\Support\Str::ucfirst(auth()->user()->name)  }} Cart</h2>
                </div>
                <div class="card-body">

                    @if(count($cartDetails))
                    <form action="{{ route('cartstripe.checkout') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered cart-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartDetails as $index => $item)

                                    <tr>
                                        <td>
                                            {{ $item['product']->name }}
                                            <input type="hidden" name="product_ids[]" value="{{ $item['product']->id }}">
                                        </td>
                                        <td class="price">₹<span>{{ number_format($item['product']->price, 2) }}</span></td>
                                        <input type="hidden" name="price[]" value="{{ $item['product']->price }}">
                                        <td>
                                            <input type="number" name="qty[]" value="{{ $item['quantity'] }}" class="form-control qty-input" data-index="{{ $index }}">
                                        </td>
                                        <td class="row-total">₹{{ number_format($item['item']->total, 2) }}</td>
                                        <td class="row-delete">

                                                <button type="button" class="btn btn-danger remove-item-btn" data-id="{{ $item['product']->id }}">
                                                    Remove
                                                </button>


                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                <h4 class="text-primary fw-bold">
                                    Grand Total:
                                    <span class="grand-total" id="grandTotalDisplay">₹{{ number_format($grandTotal, 2) }}</span>
                                </h4>
                            </div>
                            <input type="hidden" name="grandTotal" id="grandTotalInput" value="{{ number_format($grandTotal, 2, '.', '') }}">

                        </div>

                        <div class="d-flex justify-content-center align-items-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg shadow">
                                Proceed to Checkout &rarr;
                            </button>
                        </div>
                    </form>


                    @else
                    <div class="text-center empty-cart-msg">
                        <p class="text-muted fs-5">🛍️ Your cart is empty</p>
                        <a href="{{ url(config('cartstripe.redirect_success')) }}" class="btn btn-outline-primary mt-3">Continue Shopping</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section(config('cartstripe.models.hasscript'))
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

//    $(document).on('input', '.qty-input', function () {
//     var row = $(this).closest('tr');
//     var qty = parseInt($(this).val()) || 0;
//     var price = parseFloat(row.find('.price span').text().replace(/,/g, ''));

//     var total = (qty * price).toFixed(2);
//     row.find('.row-total').text('₹' + total);

//     let grandTotal = 0;
//     $('.row-total').each(function () {
//         let value = parseFloat($(this).text().replace(/[₹,]/g, '')) || 0;
//         grandTotal += value;
//     });
//     $('.grand-total').text('₹' + grandTotal.toFixed(2));
//     $('#grandTotalInput').val(grandTotal.toFixed(2));
// });


//         document.querySelectorAll('.remove-item-btn').forEach(function (button) {
//             button.addEventListener('click', function () {
//                 let productId = this.getAttribute('data-id');
//                 let row = this.closest('tr');

//                 fetch(`/cart/remove/${productId}`, {
//                     method: 'POST',
//                     headers: {
//                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
//                         'Accept': 'application/json',
//                         'Content-Type': 'application/json'
//                     },
//                 })
//                 .then(res => res.json())
//                 .then(data => {
//                     if (data.success) {
//                         row.remove(); // remove row from table
//                         // optionally update totals here
//                     }
//                 });
//             });
//         });

    function updateGrandTotal() {
        let grandTotal = 0;
        $('.row-total').each(function () {
            let value = parseFloat($(this).text().replace(/[₹,]/g, '')) || 0;
            grandTotal += value;
        });
        $('.grand-total').text('₹' + grandTotal.toFixed(2));
        $('#grandTotalInput').val(grandTotal.toFixed(2));
    }

    $(document).on('input', '.qty-input', function () {
        var row = $(this).closest('tr');
        var qty = parseInt($(this).val()) || 0;
        var price = parseFloat(row.find('.price span').text().replace(/,/g, ''));

        var total = (qty * price).toFixed(2);
        row.find('.row-total').text('₹' + total);

        updateGrandTotal();
    });

    document.querySelectorAll('.remove-item-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            let productId = this.getAttribute('data-id');
            let row = this.closest('tr');

            fetch(`/cart/remove/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    row.remove();       // remove row
                    updateGrandTotal(); // update totals after removal

                    // If no rows left, show empty cart message
                    if ($('.cart-table tbody tr').length === 0) {
                        location.reload(); // or dynamically hide table and show "empty cart" message
                    }
                }
            });
        });
    });


</script>
@endsection
 {{-- </body>
 </html> --}}
