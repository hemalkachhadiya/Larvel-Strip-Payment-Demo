@extends(config('cartstripe.models.layout'))
@section(config('cartstripe.models.hasstyle'))

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f2f6fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-card {
            max-width: 500px;
            width: 100%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border: none;
            animation: fadeIn 0.6s ease-in-out;
        }
        .card-header {
            background-color: #28a745;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 1rem;
        }
        .card-body {
            text-align: center;
            padding: 2rem;
        }
        .card-body h1 {
            color: #28a745;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .card-body p {
            font-size: 1.1rem;
            color: #555;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @endsection

    @section(config('cartstripe.models.hasMainContent'))
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card success-card">
            <div class="card-header">
                Stripe Payment
            </div>
            <div class="card-body">
                <h1>Payment Successful 🎉</h1>
                <p>Your order has been paid successfully.</p>
                <p>You will be redirected shortly...</p>
            </div>
        </div>
    </div>
    @endsection
    @section(config('cartstripe.models.hasscript'))
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function () {
            window.location.href = "{{ url(config('cartstripe.redirect_success')) }}";
        }, 3000);
    </script>
    @endsection
{{--
</body>
</html> --}}
