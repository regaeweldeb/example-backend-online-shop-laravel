<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Darryldecode\Cart\Facades\Cart;

class ProductController extends Controller
{
    // Метод для отображения списка продуктов
    public function index()
    {
        $products = Product::all(); // Получаем все продукты из базы данных
        return response()->json($products);
    }

    // Метод для создания нового продукта
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'description' => 'required',
            'availability' => 'required|numeric|in:0,1',
        ]);

        $product = Product::create($validatedData);

        return response()->json($product, 201);
    }

    // Метод для отображения информации о конкретном продукте
    public function show(Product $product)
    {
        return response()->json($product);
    }

    // Метод для обновления информации о продукте
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'description' => 'required',
            'availability' => 'required|boolean',
        ]);

        $product->update($validatedData);

        return response()->json($product, 200);
    }

    // Метод для удаления продукта
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }

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

    // Метод для фильтрации продуктов
    public function filter(Request $request)
    {
        $filteredProducts = Product::where('name', 'like', '%' . $request->input('search') . '%')
            ->where('price', '>=', $request->input('min_price'))
            ->where('price', '<=', $request->input('max_price'))
            ->get();

        return response()->json($filteredProducts);
    }
}
