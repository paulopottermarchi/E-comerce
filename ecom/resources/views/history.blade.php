@extends("includes.header")
@section('title', 'Ecom - Histórico de Pedidos')
@section('content')

    <main class="container" style="max-width: 1000px">
        <section class="py-4">
            <h2 class="mb-4 fw-bold">Order History</h2>

            @forelse ($orders as $order)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <strong>Order #{{ $order->id }}</strong> -
                        <span>Status: <span
                                class="badge bg-{{ $order->status === 'payment_completed' ? 'success' : 'secondary' }}">
                                {{ ucfirst($order->status ?? 'pending') }}
                            </span></span>
                    </div>
                    <div class="card-body">
                        <p><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Address:</strong> {{ $order->address }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</p>

                        <h5 class="mt-3">Itens:</h5>
                        <ul class="list-group">
                            @foreach ($order->products_details as $product)
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-9">
                                            <a href="{{ route('products.details', $product['slug']) }}" class="fw-semibold d-block">
                                                {{ $product['title'] }}
                                            </a>
                                            <span class="text-muted">
                                                {{ $product['quantity'] }} x ${{ $product['price'] }}
                                            </span>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <img src="{{ $product['image'] }}"
                                                 alt="{{ $product['title'] }}"
                                                 class="img-fluid"
                                                 style="max-width: 120px; max-height: 80px; object-fit: cover; border-radius: 5px;">
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        
                        
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Nenhum pedido encontrado.</div>
            @endforelse
        </section>
    </main>

@endsection
