<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Darryldecode\Cart\Facades\Cart;

class CartController extends Controller
{
    // Метод для добавления продукта в корзину
    public function addToCart(Request $request, Product $product)
    {
        // Получаем текущую корзину пользователя
        $cart = Cart::session(auth()->id());

        // Добавляем продукт в корзину с указанным количеством
        $cart->add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->input('quantity', 1),
            'attributes' => [],
            'associatedModel' => $product,
        ]);

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    // Метод для удаления продукта из корзины
    public function removeFromCart(Request $request, Product $product)
    {
        // Получаем текущую корзину пользователя
        $cart = Cart::session(auth()->id());

        // Удаляем продукт из корзины по его идентификатору
        $cart->remove($product->id);

        return response()->json(['message' => 'Product removed from cart successfully']);
    }
}
