<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\PharmaCompany;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PharmaAuthPasswordTest extends TestCase
{
    public function test_pharma_registration_stores_a_hashed_password_for_guard_login(): void
    {
        District::query()->create([
            'name' => 'Ernakulam',
        ]);

        $email = 'pharma-' . uniqid() . '@example.com';
        $plainPassword = 'StrongPass123';

        $response = $this->post(route('pharma.register.submit'), [
            'company_name' => 'Test Pharma Co',
            'drug_license_no' => 'DL-20B/12345/2025',
            'gst_number' => '29AAAAA0000A1Z5',
            'contact_person' => 'Ravi Kumar',
            'email' => $email,
            'phone' => '9876543210',
            'password' => $plainPassword,
            'state_name' => 'Kerala',
            'district_name' => 'Ernakulam',
            'address' => 'Test registered office address for pharma company',
            'license_document' => null,
        ]);

        $response->assertRedirect(route('login'));

        $pharma = PharmaCompany::query()->where('email', $email)->firstOrFail();

        $this->assertNotSame($plainPassword, $pharma->password);
        $this->assertTrue(Hash::check($plainPassword, $pharma->password));
    }
}
