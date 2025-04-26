{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light"> --}}
@extends(config('cartstripe.models.layout'))
@section(config('cartstripe.models.hasMainContent'))
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <h2 class="mb-4 text-center">Shipping Information</h2>

                        <form action="{{ route('cartstripe.process') }}" method="POST">
                            @csrf
                            {{-- @dd($product_id) --}}
                            @foreach ($product_id as $product)
                                <input type="hidden" name="product_id[]" value="{{ $product ?? '' }}">
                            @endforeach
                            <input type="hidden" name="grandTotal" value="{{ $amount ?? '' }}">
                            @foreach ($quantity as $qty)
                                <input type="hidden" name="quantity[]" value="{{ $qty ?? '' }}">
                            @endforeach
                            @foreach ($prices as $price)
                                <input type="hidden" name="price[]" value="{{ $price ?? '' }}">
                            @endforeach
                            {{-- <input type="hidden" name="quantity[]" value="{{ $quantity ?? '' }}"> --}}

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" id="phone" required>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="address" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" class="form-control" id="city" required>
                            </div>

                            <div class="mb-4">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" class="form-control" id="state" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Continue to Payment</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--
</body>
</html> --}}
