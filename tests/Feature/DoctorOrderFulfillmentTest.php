<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\District;

class DoctorOrderFulfillmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_can_view_and_update_product_orders()
    {
        $district = District::create(['name' => 'Ernakulam']);

        $doctor = Doctor::create([
            'name' => 'Dr. Vishnu Doctor',
            'email' => 'vishnu@doctor.com',
            'password' => 'password123',
            'phone' => '9876543201',
            'district_id' => $district->id,
            'is_active' => true,
            'specialization_category' => 'Kayachikitsa',
        ]);

        $product = Product::create([
            'doctor_id' => $doctor->id,
            'name' => 'Doctor Formulation Churna',
            'category' => 'Ayurvedic Churna',
            'subcategory' => 'General Wellness',
            'price' => 450,
            'stock' => 15,
        ]);

        $user = User::create([
            'name' => 'Patient Buyer',
            'email' => 'patient@buyer.com',
            'phone' => '9876543210',
            'password' => 'password123',
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'delivery_name' => 'Patient Buyer',
            'delivery_phone' => '9876543210',
            'delivery_district' => 'Ernakulam',
            'delivery_pincode' => '682001',
            'delivery_address' => 'Sample Clinic Address 456',
            'total_price' => 450,
            'payment_method' => 'COD',
            'payment_status' => 'Pending',
            'order_status' => 'Placed',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 450,
        ]);

        // Doctor views orders list
        $responseIndex = $this->actingAs($doctor, 'doctor')->get(route('doctor.orders.index'));
        $responseIndex->assertStatus(200);

        // Doctor views single order detail
        $responseShow = $this->actingAs($doctor, 'doctor')->get(route('doctor.orders.show', $order->id));
        $responseShow->assertStatus(200);

        // Doctor updates order status to Shipped
        $responseUpdate = $this->actingAs($doctor, 'doctor')->post(route('doctor.orders.update_status', $order->id), [
            'order_status' => 'Shipped',
            'payment_status' => 'Pending',
        ]);

        $responseUpdate->assertStatus(302);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_status' => 'Shipped',
        ]);
    }
}
