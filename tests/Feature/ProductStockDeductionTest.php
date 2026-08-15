<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\PharmaCompany;
use App\Models\District;
use Illuminate\Support\Facades\Hash;

class ProductStockDeductionTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchasing_product_automatically_reduces_product_stock()
    {
        $user = User::create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
            'phone' => '9876543210',
            'password' => Hash::make('password123'),
        ]);

        $district = District::create(['name' => 'Ernakulam']);
        $pharma = PharmaCompany::create([
            'company_name' => 'Pharma Ltd',
            'email' => 'pharma@test.com',
            'phone' => '9876543212',
            'password' => 'password123',
            'district_id' => $district->id,
            'is_active' => true,
        ]);

        $product = Product::create([
            'pharma_company_id' => $pharma->id,
            'name' => 'Ayurvedic Cough Syrup',
            'category' => 'Herbal Formulation',
            'subcategory' => 'Syrup',
            'price' => 200,
            'stock' => 50,
        ]);

        // Add 3 units to cart
        $cart = Cart::create(['user_id' => $user->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'price' => 200,
        ]);

        // Submit checkout order
        $response = $this->actingAs($user)->post(route('orders.store'), [
            'delivery_name' => 'Buyer User',
            'delivery_phone' => '9876543210',
            'delivery_district' => 'Ernakulam',
            'delivery_pincode' => '682001',
            'delivery_address' => 'Full Street Address 123',
            'payment_method' => 'COD',
        ]);

        $response->assertStatus(302);

        // Verify product stock is decremented from 50 to 47
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 47,
        ]);
    }
}
