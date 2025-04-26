@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $user = Auth::user();

    $orders = $user
        ? DB::table('orders')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
        : collect();

    $orderItems = $user ? DB::table('order_items')->whereIn('order_id', $orders->pluck('id'))->get() : collect();

    $productTable = config('cartstripe.product_table');

    $products = DB::table($productTable)
        ->whereIn('id', $orderItems->pluck('product_id')->filter())
        ->get()
        ->keyBy('id');
@endphp

@if ($user && $orders->count())
    <div class="order-list">
        <h3 class="mb-4">🧾 Your Orders</h3>
        @foreach ($orders as $order)
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <strong>Order #{{ $order->id }}</strong>
                        <small class="text-muted ms-2">
                            📅 {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                        </small>
                    </div>

                    <div class="d-flex flex-wrap">
                        <div class="d-flex mr-5">
                            <strong>Order Status:</strong>
                            <span class="badge
                                @if($order->order_status == 'complete') bg-success
                                @elseif($order->order_status == 'pending') bg-warning
                                @else bg-secondary
                                @endif text-white fw-semibold px-3 py-2 fs-6 rounded-pill">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>

                        <div class="d-flex">
                            <strong>Payment Status:</strong>
                            <span class="badge
                                @if($order->payment_status == 'paid') bg-success
                                @elseif($order->payment_status == 'pending') bg-warning
                                @else bg-secondary
                                @endif text-white fw-semibold px-3 py-2 fs-6 rounded-pill">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">📦 Shipping Address</h6>
                            <p class="mb-1">📞 Phone: {{ $order->phone }}</p>
                            <p class="mb-1">🏠 Address: {{ $order->address }}</p>
                            <p class="mb-1">🏙️ City: {{ $order->city }}</p>
                            <p class="mb-0">🗺️ State: {{ $order->state }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">🛒 Products Ordered</h6>
                            <ul class="list-group list-group-flush">
                                @foreach ($orderItems->where('order_id', $order->id) as $item)
                                    @php
                                        $product = $products->get($item->product_id);
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-start px-0">
                                        <div>
                                            <strong>{{ $product->name ?? '🗑️ Product Removed' }}</strong><br>
                                            <small>Qty: {{ $item->quantity }} | Price: ₹{{ number_format($item->price, 2) }}</small>
                                        </div>
                                        <span class="badge bg-primary text-light fw-bold px-3 py-2 fs-6 rounded-pill">
                                            ₹{{ number_format($item->price * $item->quantity, 2) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <span class="badge bg-dark text-light fw-bold px-3 py-2 fs-6">
                            🧮 Grand Total: ₹{{ number_format($order->order_total, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@elseif($user)
    <p class="text-muted text-center">📭 You haven’t placed any orders yet.</p>
@else
    <p class="text-danger text-center">⚠️ You must be logged in to view orders.</p>
@endif
