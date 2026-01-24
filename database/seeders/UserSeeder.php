<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Rahim',
                'last_name' => 'Uddin',
                'dob' => '2000-05-12',
                'gender' => 'Male',
                'blood_group' => 'A+',
                'religion' => 'Islam',
                'nationality' => 'Bangladeshi',
                'national_id' => '1998123456789',
                'phone' => '01711111111',
                'email' => 'rahim@example.com',
                'password' => Hash::make('password'),
                'present_address' => 'Dhaka',
                'parmanent_address' => 'Dhaka',
                'father_name' => 'Abdul Karim',
                'father_contact' => '01722222222',
                'mother_name' => 'Ayesha Begum',
                'mother_contact' => '01733333333',
                'guardian_name' => 'Abdul Karim',
                'guardian_contact' => '01722222222',
                'role' => 'admin',
                'status' => 'active',
                'joining_date' => Carbon::now()->subYears(2),
                'remark' => 'Regular student',
                'photo' => null,
                'otp' => null,
                'otp_expires_at' => null,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'last_login_ip' => '127.0.0.1',
                'is_profile_completed' => true,
            ],
        ];

        // Clone + modify data to make 10 users
        for ($i = 2; $i <= 10; $i++) {
            $users[] = [
                'first_name' => 'User',
                'last_name' => 'No' . $i,
                'dob' => '2001-01-01',
                'gender' => $i % 2 === 0 ? 'Female' : 'Male',
                'blood_group' => 'O+',
                'religion' => 'Islam',
                'nationality' => 'Bangladeshi',
                'national_id' => '19990000000' . $i,
                'phone' => '0150000000' . $i,
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password'),
                'present_address' => 'Dhaka',
                'parmanent_address' => 'Dhaka',
                'father_name' => 'Father ' . $i,
                'father_contact' => '0181111111' . $i,
                'mother_name' => 'Mother ' . $i,
                'mother_contact' => '0182222222' . $i,
                'guardian_name' => 'Guardian ' . $i,
                'guardian_contact' => '0183333333' . $i,
                'role' => 'admin',
                'status' => 'active',
                'joining_date' => Carbon::now()->subMonths($i),
                'remark' => 'Seeder data',
                'photo' => null,
                'otp' => null,
                'otp_expires_at' => null,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'last_login_ip' => '127.0.0.1',
                'is_profile_completed' => true,
            ];
        }

        User::insert($users);
    }
}
