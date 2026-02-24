<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DoctorToken;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctors = Doctor::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        if (empty($doctors) || empty($users)) {
            $this->command->error('Please ensure you have doctors and users seeded first.');
            return;
        }

        $date = Carbon::today();

        for ($i = 0; $i < 50; $i++) {
            DoctorToken::create([
                'user_id' => $users[array_rand($users)],
                'doctor_id' => $doctors[array_rand($doctors)],
                'booking_date' => $date->format('Y-m-d'),
                'booking_time' => sprintf('%02d:00:00', rand(9, 16)), // Random hour between 9 AM and 4 PM
                'status' => 'Booked'
            ]);

            // Add 1 day gap (every day)
            $date->addDay();
        }

        $this->command->info('Created 50 daily appointments starting from today.');
    }
}
