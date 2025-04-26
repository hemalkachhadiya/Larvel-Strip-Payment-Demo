<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Canceled</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #fdf2f2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .cancel-card {
            max-width: 500px;
            width: 100%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border: none;
            animation: fadeIn 0.6s ease-in-out;
        }
        .card-header {
            background-color: #dc3545;
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
            color: #dc3545;
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
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card cancel-card">
            <div class="card-header">
                Payment Failed
            </div>
            <div class="card-body">
                <h1>Payment Canceled ❌</h1>
                <p>Your payment was canceled. Please try again.</p>
                <p>You will be redirected shortly...</p>
            </div>
            {{-- @dd($request) --}}
            {{-- @dd($response) --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function () {
            window.location.href = "{{ url('/product') }}";
        }, 3000); // redirect after 3 seconds
    </script>
</body>
</html>
