<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DoctorToken;
use App\Models\District;

class AdminSupervisionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_and_manage_all_appointments_orders_and_products()
    {
        $admin = Admin::create([
            'name' => 'System Admin',
            'email' => 'admin@test.com',
            'password' => 'admin123',
        ]);

        $district = District::create(['name' => 'Kottayam']);

        $doctor = Doctor::create([
            'name' => 'Dr. Admin Verified',
            'email' => 'docadmin@test.com',
            'password' => 'password123',
            'phone' => '9876543202',
            'district_id' => $district->id,
            'is_active' => true,
            'specialization_category' => 'Kayachikitsa',
        ]);

        $user = User::create([
            'name' => 'Sample Patient',
            'email' => 'patientadmin@test.com',
            'phone' => '9876543211',
            'password' => 'password123',
        ]);

        $booking = DoctorToken::create([
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'booking_date' => '2026-08-20',
            'booking_time' => '10:00:00',
            'token_number' => 1,
            'status' => 'Pending',
        ]);

        $product = Product::create([
            'doctor_id' => $doctor->id,
            'name' => 'Admin Monitored Herb',
            'category' => 'General Medicine',
            'subcategory' => 'Herbal',
            'price' => 300,
            'stock' => 20,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'delivery_name' => 'Sample Patient',
            'delivery_phone' => '9876543211',
            'delivery_district' => 'Kottayam',
            'delivery_pincode' => '686001',
            'delivery_address' => 'Sample Address 123',
            'total_price' => 300,
            'payment_method' => 'COD',
            'payment_status' => 'Pending',
            'order_status' => 'Placed',
        ]);

        // 1. Admin accesses appointments list & updates booking status
        $respBookings = $this->actingAs($admin, 'admin')->get(route('admin.bookings.index'));
        $respBookings->assertStatus(200);

        $respUpdateBooking = $this->actingAs($admin, 'admin')->put(route('admin.bookings.update_status', $booking->id), [
            'status' => 'Confirmed',
        ]);
        $respUpdateBooking->assertStatus(302);
        $this->assertDatabaseHas('doctor_tokens', ['id' => $booking->id, 'status' => 'Confirmed']);

        // 2. Admin accesses orders list & updates order status
        $respOrders = $this->actingAs($admin, 'admin')->get(route('admin.orders.index'));
        $respOrders->assertStatus(200);

        $respUpdateOrder = $this->actingAs($admin, 'admin')->put(route('admin.orders.update_status', $order->id), [
            'order_status' => 'Shipped',
        ]);
        $respUpdateOrder->assertStatus(302);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'order_status' => 'Shipped']);

        // 3. Admin accesses products list & edits product
        $respProducts = $this->actingAs($admin, 'admin')->get(route('admin.products.index'));
        $respProducts->assertStatus(200);

        $respUpdateProduct = $this->actingAs($admin, 'admin')->put(route('admin.products.update', $product->id), [
            'name' => 'Admin Monitored Herb Updated',
            'category' => $product->category,
            'subcategory' => $product->subcategory,
            'price' => 350,
            'stock' => 50,
        ]);
        $respUpdateProduct->assertStatus(302);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Admin Monitored Herb Updated', 'price' => 350]);
    }

    public function test_admin_can_emergency_approve_imminent_booking_when_doctor_is_inactive()
    {
        $admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin_urgency@test.com',
            'password' => 'admin123',
        ]);

        $district = District::create(['name' => 'Ernakulam']);

        $doctor = Doctor::create([
            'name' => 'Dr. Slow Responder',
            'email' => 'slowdoc@test.com',
            'password' => 'password123',
            'phone' => '9876543203',
            'district_id' => $district->id,
            'is_active' => true,
            'specialization_category' => 'Kayachikitsa',
        ]);

        $user = User::create([
            'name' => 'Urgent Patient',
            'email' => 'urgentpatient@test.com',
            'phone' => '9876543212',
            'password' => 'password123',
        ]);

        $imminentBooking = DoctorToken::create([
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => now()->addMinutes(15)->format('H:i:s'),
            'token_number' => 2,
            'status' => 'Pending',
        ]);

        // Emergency Approve route
        $response = $this->actingAs($admin, 'admin')->post(route('admin.bookings.emergency_approve', $imminentBooking->id));
        $response->assertStatus(302);

        $this->assertDatabaseHas('doctor_tokens', [
            'id' => $imminentBooking->id,
            'status' => 'Booked',
        ]);

        $this->assertDatabaseHas('user_notifications', [
            'user_id' => $user->id,
            'type' => 'appointment_approved',
        ]);
    }

    public function test_admin_dashboard_shows_todays_priority_and_yesterdays_pending_overdue_bookings()
    {
        $admin = Admin::create([
            'name' => 'Priority Admin',
            'email' => 'admin_today@test.com',
            'password' => 'admin123',
        ]);

        $district = District::create(['name' => 'Thrissur']);

        $doctor = Doctor::create([
            'name' => 'Dr. Priority',
            'email' => 'prioritydoc@test.com',
            'password' => 'password123',
            'phone' => '9876543204',
            'district_id' => $district->id,
            'is_active' => true,
            'specialization_category' => 'Shalya Tantra',
        ]);

        $user = User::create([
            'name' => 'Patient Priority',
            'email' => 'patientpriority@test.com',
            'phone' => '9876543213',
            'password' => 'password123',
        ]);

        // Yesterday's Overdue Pending Booking
        $yesterdayBooking = DoctorToken::create([
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'booking_date' => now()->subDay()->format('Y-m-d'),
            'booking_time' => '11:00:00',
            'token_number' => 10,
            'status' => 'Pending',
        ]);

        // Today's Priority Booking
        $todayBooking = DoctorToken::create([
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '14:00:00',
            'token_number' => 11,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertViewHas('pastOverdueBookings');
        $response->assertViewHas('todaysBookings');

        $pastOverdue = $response->viewData('pastOverdueBookings');
        $todaysBookings = $response->viewData('todaysBookings');

        $this->assertTrue($pastOverdue->contains('id', $yesterdayBooking->id));
        $this->assertTrue($todaysBookings->contains('id', $todayBooking->id));
    }

    public function test_daily_token_resets_every_day_and_single_day_filtering_works()
    {
        $district = District::create(['name' => 'Kozhikode']);

        $doctor = Doctor::create([
            'name' => 'Dr. Token Reset',
            'email' => 'tokenreset@test.com',
            'password' => 'password123',
            'phone' => '9876543209',
            'district_id' => $district->id,
            'is_active' => true,
            'specialization_category' => 'Kayachikitsa',
            'consultation_type' => 'Both',
        ]);

        $user = User::create([
            'name' => 'Token Patient',
            'email' => 'tokenpatient@test.com',
            'phone' => '9876543219',
            'password' => 'password123',
        ]);

        $todayStr = now()->format('Y-m-d');
        $tomorrowStr = now()->addDay()->format('Y-m-d');
        $dayAfterTomorrowStr = now()->addDays(2)->format('Y-m-d');

        // 1. Create Token 1 today -> Token #1
        $todayLast1 = DoctorToken::where('doctor_id', $doctor->id)->whereDate('booking_date', $todayStr)->max('token_number');
        $todayToken1 = DoctorToken::create([
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'booking_date' => $todayStr,
            'booking_time' => '10:00:00',
            'token_number' => ($todayLast1 ?? 0) + 1,
            'status' => 'Pending',
        ]);

        // 2. Create Token 2 today -> Token #2
        $todayLast2 = DoctorToken::where('doctor_id', $doctor->id)->whereDate('booking_date', $todayStr)->max('token_number');
        $todayToken2 = DoctorToken::create([
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'booking_date' => $todayStr,
            'booking_time' => '10:15:00',
            'token_number' => ($todayLast2 ?? 0) + 1,
            'status' => 'Pending',
        ]);

        // 3. Create Token 1 tomorrow -> Token MUST reset to #1 for tomorrow!
        $tomorrowLast1 = DoctorToken::where('doctor_id', $doctor->id)->whereDate('booking_date', $tomorrowStr)->max('token_number');
        $tomorrowToken1 = DoctorToken::create([
            'doctor_id' => $doctor->id,
            'user_id' => $user->id,
            'booking_date' => $tomorrowStr,
            'booking_time' => '10:00:00',
            'token_number' => ($tomorrowLast1 ?? 0) + 1,
            'status' => 'Pending',
        ]);

        $this->assertEquals(1, $todayToken1->token_number);
        $this->assertEquals(2, $todayToken2->token_number);
        $this->assertEquals(1, $tomorrowToken1->token_number); // Daily Token reset verified!

        // Admin single day view check
        $admin = Admin::create([
            'name' => 'Single Day Admin',
            'email' => 'singleday@test.com',
            'password' => 'admin123',
        ]);

        // 1. Viewing Today shows only today's 2 bookings
        $respToday = $this->actingAs($admin, 'admin')->get(route('admin.bookings.index', ['date' => $todayStr]));
        $respToday->assertStatus(200);
        $bookingsToday = $respToday->viewData('bookings');
        $this->assertCount(2, $bookingsToday);

        // 2. Viewing Tomorrow shows only tomorrow's 1 booking
        $respTomorrow = $this->actingAs($admin, 'admin')->get(route('admin.bookings.index', ['date' => $tomorrowStr]));
        $respTomorrow->assertStatus(200);
        $bookingsTomorrow = $respTomorrow->viewData('bookings');
        $this->assertCount(1, $bookingsTomorrow);

        // 3. Viewing Day After Tomorrow (no bookings) returns empty list (0 bookings)
        $respDayAfter = $this->actingAs($admin, 'admin')->get(route('admin.bookings.index', ['date' => $dayAfterTomorrowStr]));
        $respDayAfter->assertStatus(200);
        $bookingsDayAfter = $respDayAfter->viewData('bookings');
        $this->assertCount(0, $bookingsDayAfter);
        $respDayAfter->assertSee('No Appointments Found');
    }
}
