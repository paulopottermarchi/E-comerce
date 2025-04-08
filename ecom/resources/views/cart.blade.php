@extends("default")
@section("title", "Ecom - Carrinho")
@section("content")

<main class="container" style="max-width: 900px">
    <section>
        <h2 class="mb-4 fw-bold">Seu Carrinho</h2>

        {{-- Mensagens de feedback --}}
        @if(session()->has("success"))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session()->has("error"))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Lista de Produtos no Carrinho --}}
        @foreach($products as $product)
            @php
                $cartItem = $cartItems->firstWhere('product_id', $product->id);
            @endphp

            @if($cartItem)
                <div class="card mb-3 p-2 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ $product->image }}" alt="{{ $product->title }}" 
                                 style="width: 180px; height: 100px; object-fit: cover;" class="me-3 rounded">
                            <div>
                                <h5>
                                    <a href="{{ route('products.details', $product->slug) }}">
                                        {{ $product->title }}
                                    </a>
                                </h5>
                                <p class="mb-1"><strong>Preço:</strong> ${{ $product->price }}</p>
                                <p class="mb-0"><strong>Quantidade:</strong> {{ $cartItem->quantity }}</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('cart.delete', $cartItem->cart_id) }}"
                               class="btn btn-outline-danger btn-sm">Remover</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Botão de checkout --}}
        <div class="mt-4">
            <a class="btn btn-success px-4" href="{{ route('checkout.show') }}">Checkout</a>
        </div>
    </section>
</main>

@endsection
