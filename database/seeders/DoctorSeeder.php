<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_GB');

        $specialties = [
            'General Practice',
            'Cardiology',
            'Dermatology',
            'Neurology',
            'Pediatrics',
            'Orthopedics',
            'Psychiatry',
            'Oncology',
            'Radiology',
            'Anesthesiology'
        ];

        for ($i = 0; $i < 20; $i++) {
            $sex = $faker->randomElement(['male', 'female']);
            $firstName = $faker->firstName($sex);
            $lastName = $faker->lastName;

            DB::table('doctors')->insert([
                'name' => "Dr. {$firstName} {$lastName}",
                'specialty' => $faker->randomElement($specialties),
                'phone' => '07' . $faker->numerify('#########'),
                'email' => strtolower($firstName . '.' . $lastName . '@hospital.nhs.uk'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
