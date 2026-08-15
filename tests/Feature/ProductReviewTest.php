<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PharmaCompany;
use App\Models\District;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Hash;

class ProductReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_rate_and_review_delivered_product()
    {
        $user = User::create([
            'name' => 'Reviewer User',
            'email' => 'reviewer@example.com',
            'phone' => '9876543210',
            'password' => Hash::make('password123'),
        ]);

        $district = District::create(['name' => 'Ernakulam']);
        $pharma = PharmaCompany::create([
            'company_name' => 'Pharma Corp',
            'email' => 'pharma@corp.com',
            'phone' => '9876543211',
            'password' => 'password123',
            'district_id' => $district->id,
            'is_active' => true,
        ]);

        $product = Product::create([
            'pharma_company_id' => $pharma->id,
            'name' => 'Kottakkal Chyawanprash',
            'category' => 'Wellness',
            'subcategory' => 'General',
            'price' => 350,
            'stock' => 20,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'delivery_name' => 'Reviewer User',
            'delivery_phone' => '9876543210',
            'delivery_district' => 'Ernakulam',
            'delivery_pincode' => '682001',
            'delivery_address' => 'Sample Address',
            'total_price' => 350,
            'payment_method' => 'COD',
            'payment_status' => 'Completed',
            'order_status' => 'Delivered',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 350,
        ]);

        // Submit Rating & Review
        $response = $this->actingAs($user)->post(route('products.reviews.store', $product->id), [
            'order_id' => $order->id,
            'rating' => 5,
            'review' => 'Excellent authentic product! Very effective for immunity.',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('product_reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => 5,
            'review' => 'Excellent authentic product! Very effective for immunity.',
        ]);

        $this->assertEquals(5.0, $product->fresh()->average_rating);
        $this->assertEquals(1, $product->fresh()->reviews_count);
    }
}
