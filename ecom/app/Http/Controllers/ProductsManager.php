<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Products;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class ProductsManager extends Controller
{
    public function index()
    {
        $products = Products::paginate(5);
        return view('products', compact('products'));
    }

    public function details($slug) 
    {
        $product = Products::where('slug', $slug)->first();
        return view('details', compact('product'));
    }

    public function addToCart($id)
    {
        $cart = new Cart();
        $cart->user_id = auth()->user()->id;
        $cart->product_id = $id;

        if($cart->save()) {
            return redirect()->back()->with('success', 'Product added to cart successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to add product to cart');
        }
    }

    public function showCart()
{
    $cartItems = DB::table('cart')
        ->select('cart.product_id', 
        Db::raw("MIN(cart.id) as cart_id"),
        DB::raw('count(*) as quantity'))
        ->where('user_id', auth()->user()->id)
        ->groupBy('product_id')
        ->get();

    $productIds = $cartItems->pluck('product_id')->toArray();

    $products = Products::whereIn('id', $productIds)->get();
    

    return view('cart', compact('cartItems', 'products'));
}

function deleteCartItem($id)
{
    $item = Cart::where('user_id', auth()->user()->id)
        ->where('id', $id) // <- Aqui é o ID do registro (cart_id)
        ->first();

    if ($item) {
        $item->delete();
        return redirect()->back()->with('success', 'Item removido com sucesso.');
    }

    return redirect()->back()->with('error', 'Item não encontrado.');
}

}
