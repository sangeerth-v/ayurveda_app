<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\Doctor;
use App\Models\DoctorCategory;
use App\Models\DoctorSubcategory;
use App\Models\PharmaCompany;
use App\Models\District;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Districts
        $districts = [
            'Thiruvananthapuram', 'Kollam', 'Pathanamthitta', 'Alappuzha',
            'Kottayam', 'Idukki', 'Ernakulam', 'Thrissur', 'Palakkad',
            'Malappuram', 'Kozhikode', 'Wayanad', 'Kannur', 'Kasaragod'
        ];

        $districtMap = [];
        foreach ($districts as $d) {
            $districtMap[$d] = District::firstOrCreate(['name' => $d]);
        }

        $ernakulamId = $districtMap['Ernakulam']->id;
        $kozhikodeId = $districtMap['Kozhikode']->id;
        $tvmId       = $districtMap['Thiruvananthapuram']->id;
        $thrissurId  = $districtMap['Thrissur']->id;

        // 2. Admins
        Admin::updateOrCreate(
            ['email' => 'sindu@gmail.com'],
            [
                'name' => 'sindu',
                'password' => Hash::make('12341234'),
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12341234'),
            ]
        );

        // 3. Users (Patients)
        User::updateOrCreate(
            ['email' => 'nivedcnivedc8@gmail.com'],
            [
                'name' => 'Nived C',
                'phone' => '9876543210',
                'password' => Hash::make('12341234'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'patient@example.com'],
            [
                'name' => 'Patient User',
                'phone' => '9876543211',
                'password' => Hash::make('12341234'),
            ]
        );

        // 4. Doctor Categories & Subcategories
        $panchakarma = DoctorCategory::firstOrCreate(['name' => 'Panchakarma']);
        DoctorSubcategory::firstOrCreate(['doctor_category_id' => $panchakarma->id, 'name' => 'Uzhichil']);
        DoctorSubcategory::firstOrCreate(['doctor_category_id' => $panchakarma->id, 'name' => 'Shirodhara']);
        DoctorSubcategory::firstOrCreate(['doctor_category_id' => $panchakarma->id, 'name' => 'Nasyam']);

        $kayachikitsa = DoctorCategory::firstOrCreate(['name' => 'Kayachikitsa']);
        DoctorSubcategory::firstOrCreate(['doctor_category_id' => $kayachikitsa->id, 'name' => 'General Medicine']);
        DoctorSubcategory::firstOrCreate(['doctor_category_id' => $kayachikitsa->id, 'name' => 'Chronic Care']);

        $shalya = DoctorCategory::firstOrCreate(['name' => 'Shalya Tantra']);

        // 5. Doctors
        Doctor::updateOrCreate(
            ['email' => 'sai@gmail.com'],
            [
                'name' => 'sai',
                'password' => Hash::make('12341234'),
                'password_plain' => '12341234',
                'phone' => '9876543201',
                'medical_registration_no' => 'KMC/10001/2021',
                'specialization_category' => 'Panchakarma',
                'specialization_subcategory' => 'Uzhichil',
                'district_id' => $ernakulamId,
                'address' => 'Ayurvedic Wellness Clinic, Ernakulam',
                'qualification' => 'BAMS',
                'experience' => 8,
                'consultation_fee' => 500,
                'consultation_type' => 'Both',
                'available_time' => '09:00 AM to 01:00 PM',
                'online_available_time' => '04:00 PM to 08:00 PM',
                'is_active' => true,
                'knows_medical_astrology' => true,
                'astrology_qualification' => 'Jyotish Acharya',
                'astrology_details' => 'Specializes in Nadi Pariksha and planetary influence analysis on Tridoshas.',
            ]
        );

        Doctor::updateOrCreate(
            ['email' => 'loki@gmail.com'],
            [
                'name' => 'loki',
                'password' => Hash::make('12341234'),
                'password_plain' => '12341234',
                'phone' => '9876543202',
                'medical_registration_no' => 'KMC/10002/2020',
                'specialization_category' => 'Panchakarma',
                'specialization_subcategory' => 'Uzhichil, Shirodhara',
                'district_id' => $kozhikodeId,
                'address' => 'Healing Hands Center, Kozhikode',
                'qualification' => 'BAMS, MD, CA',
                'experience' => 10,
                'consultation_fee' => 600,
                'consultation_type' => 'Both',
                'available_time' => '10:00 AM to 02:00 PM',
                'online_available_time' => '05:00 PM to 09:00 PM',
                'is_active' => true,
                'knows_medical_astrology' => true,
                'astrology_qualification' => 'Certificate in Medical Astrology',
                'astrology_details' => 'Combines Marma therapy with planetary alignment diagnostics.',
            ]
        );

        Doctor::updateOrCreate(
            ['email' => 'ananya@gmail.com'],
            [
                'name' => 'Ananya R',
                'password' => Hash::make('12341234'),
                'password_plain' => '12341234',
                'phone' => '9876543203',
                'medical_registration_no' => 'KMC/10003/2019',
                'specialization_category' => 'Kayachikitsa',
                'specialization_subcategory' => 'General Medicine',
                'district_id' => $tvmId,
                'address' => 'Vaidya Bhavan, Thiruvananthapuram',
                'qualification' => 'BAMS, MD (Ayurveda)',
                'experience' => 12,
                'consultation_fee' => 700,
                'consultation_type' => 'Online',
                'online_available_time' => '02:00 PM to 06:00 PM',
                'is_active' => true,
            ]
        );

        Doctor::updateOrCreate(
            ['email' => 'vishnu@gmail.com'],
            [
                'name' => 'Vishnu Namboothiri',
                'password' => Hash::make('12341234'),
                'password_plain' => '12341234',
                'phone' => '9876543204',
                'medical_registration_no' => 'KMC/10004/2018',
                'specialization_category' => 'Shalya Tantra',
                'specialization_subcategory' => 'Ayurvedic Surgery',
                'district_id' => $thrissurId,
                'address' => 'Sree Kerala Varma Clinic, Thrissur',
                'qualification' => 'BAMS, MS (Ayurveda)',
                'experience' => 15,
                'consultation_fee' => 800,
                'consultation_type' => 'Offline',
                'available_time' => '09:30 AM to 01:30 PM',
                'is_active' => true,
            ]
        );

        // 6. Pharma Companies
        PharmaCompany::updateOrCreate(
            ['email' => 'pharma@example.com'],
            [
                'company_name' => 'Test Pharma Co',
                'phone' => '9876543212',
                'password' => Hash::make('12341234'),
                'password_plain' => '12341234',
                'drug_license_no' => 'DL-20B/12345/2025',
                'gst_number' => '29AAAAA0000A1Z5',
                'contact_person' => 'Manager John',
                'address' => 'Main Road, Kochi',
                'district_id' => $ernakulamId,
                'is_active' => true,
            ]
        );

        // 7. Product Categories
        $herbCat = ProductCategory::firstOrCreate(['name' => 'Herbal Formulation']);
        ProductSubcategory::firstOrCreate(['product_category_id' => $herbCat->id, 'name' => 'Churnam']);
        ProductSubcategory::firstOrCreate(['product_category_id' => $herbCat->id, 'name' => 'Thailam']);

        $pharmaCo = PharmaCompany::where('email', 'pharma@example.com')->first();

        // 8. Products
        Product::firstOrCreate(
            ['name' => 'Triphala Churnam Organic'],
            [
                'pharma_company_id' => $pharmaCo ? $pharmaCo->id : null,
                'category' => 'Herbal Formulation',
                'subcategory' => 'Churnam',
                'price' => 250,
                'stock' => 50,
                'description' => 'Pure Ayurvedic digestion & detoxification powder.',
                'image' => null,
            ]
        );

        Product::firstOrCreate(
            ['name' => 'Ksheerabala Thailam 200ml'],
            [
                'pharma_company_id' => $pharmaCo ? $pharmaCo->id : null,
                'category' => 'Herbal Formulation',
                'subcategory' => 'Thailam',
                'price' => 380,
                'stock' => 35,
                'description' => 'Traditional Ayurvedic oil for neuromuscular health and joint relief.',
                'image' => null,
            ]
        );
    }
}
