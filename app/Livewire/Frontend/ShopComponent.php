<?php

namespace App\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use App\Models\WishList;
use Livewire\WithPagination;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Session\Session;

class ShopComponent extends Component
{
    use WithPagination;
    public $perPage = 12;

    public function loadMore()
    {
        $this->perPage = $this->perPage + 12;
    }

    public function CartStore($product_id, $product_name, $product_price)
    {

        Cart::instance('cart')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        Session()->flash('success_message', 'Product added in cart');
        return redirect()->route('cart');
    }
 
    public function AddToWishlist($product_id, $product_name, $product_price)
{
    // Add the product to the wishlist cart
    Cart::instance('wishlist')->add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');

    // Insert the product into the wish_lists table
    $wishList = new WishList();
    $wishList->user_id = auth()->user()->id; // Assuming you have user authentication
    $wishList->product_id = $product_id;
    $wishList->save();

    Session()->flash('success_message', 'Product added to wishlist');
    return redirect()->route('wishlist');
}

    public function render()
    {
        $products = Product::orderBy('created_at', 'desc')->take($this->perPage)->get();
        return view('livewire.frontend.shop-component', compact('products'));
    }
}
