<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Doctor;
use App\Models\PharmaCompany;
use App\Models\Admin;
use App\Models\District;
use Illuminate\Support\Facades\Hash;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_is_redirected_to_home()
    {
        $user = User::create([
            'name' => 'Patient User',
            'email' => 'patient@example.com',
            'phone' => '9876543210',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'patient@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user, 'web');
    }

    public function test_doctor_can_login_and_is_redirected_to_doctor_dashboard()
    {
        $district = District::create(['name' => 'Ernakulam']);
        $doctor = Doctor::create([
            'name' => 'Dr. Smith',
            'email' => 'doctor@example.com',
            'phone' => '9876543211',
            'password' => Hash::make('password123'),
            'password_plain' => 'password123',
            'medical_registration_no' => 'KMC/12345/2020',
            'specialization_category' => 'Ayurveda',
            'district_id' => $district->id,
            'address' => 'Sample Clinic Address 123',
            'qualification' => 'BAMS',
            'experience' => 5,
            'consultation_fee' => 500,
            'consultation_type' => 'Both',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'doctor@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('doctor.dashboard'));
        $this->assertAuthenticatedAs($doctor, 'doctor');
    }

    public function test_pharma_can_login_and_is_redirected_to_pharma_dashboard()
    {
        $district = District::create(['name' => 'Kottayam']);
        $pharma = PharmaCompany::create([
            'company_name' => 'AyurPharma Ltd',
            'email' => 'pharma@example.com',
            'phone' => '9876543212',
            'password' => 'password123',
            'password_plain' => 'password123',
            'drug_license_no' => 'DL-20B/12345/2025',
            'gst_number' => '29AAAAA0000A1Z5',
            'contact_person' => 'Manager John',
            'address' => 'Registered Office Address 123',
            'district_id' => $district->id,
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'pharma@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('pharma.dashboard'));
        $this->assertAuthenticatedAs($pharma, 'pharma');
    }

    public function test_admin_can_login_and_is_redirected_to_admin_dashboard()
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'adminpassword',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_registration_and_otp_verification_flow()
    {
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'phone' => '9876543219',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);

        $response->assertRedirect(route('register.verify_otp'));
        $this->assertTrue(session()->has('registration_otp'));

        $otp = session('registration_otp');

        $verifyResponse = $this->post('/register/verify-otp', [
            'otp' => $otp,
        ]);

        $verifyResponse->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);
    }

    public function test_doctor_registration_with_medical_astrology()
    {
        $category = \App\Models\DoctorCategory::create(['name' => 'Kayachikitsa']);

        $response = $this->post(route('doctor.register.submit'), [
            'name' => 'Dr. Astro Doctor',
            'email' => 'astrodoc@example.com',
            'phone' => '9876543299',
            'password' => 'password123',
            'medical_registration_no' => 'KMC/99999/2022',
            'qualification' => 'BAMS, Jyotish Acharya',
            'specialization_category' => $category->id,
            'specialization_subcategory' => 'General Medicine',
            'state_name' => 'Kerala',
            'district_name' => 'Ernakulam',
            'experience' => 7,
            'consultation_fee' => 600,
            'consultation_type' => 'Both',
            'address' => 'Sample Astro Clinic Address 123',
            'knows_medical_astrology' => '1',
            'astrology_details' => 'Nadi pariksha and planetary dosha correlation',
            'astrology_qualification' => 'Jyotish Acharya (Vedic Astrology)',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('doctors', [
            'email' => 'astrodoc@example.com',
            'knows_medical_astrology' => 1,
            'astrology_qualification' => 'Jyotish Acharya (Vedic Astrology)',
        ]);
    }
}
