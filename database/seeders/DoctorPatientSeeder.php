<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DoctorPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_GB');

        $specialties = [
            'Cardiology',
            'Dermatology',
            'Endocrinology',
            'Gastroenterology',
            'Neurology',
            'Oncology',
            'Orthopedics',
            'Pediatrics',
            'Psychiatry',
            'Radiology',
            'Surgery',
            'Urology',
        ];

        $usedEmails = [];

        for ($i = 0; $i < 20; $i++) {
            // Generate unique email
            do {
                $firstName = $faker->firstName;
                $lastName = $faker->lastName;
                $email = strtolower($firstName . '.' . $lastName . '@hospital.nhs.uk');
            } while (in_array($email, $usedEmails));

            $usedEmails[] = $email;

            DB::table('doctors')->insert([
                'name' => 'Dr. ' . $firstName . ' ' . $lastName,
                'specialty' => $faker->randomElement($specialties),
                'phone' => '07' . $faker->numerify('#########'),
                'email' => $email,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('10 doctors created successfully!');
    }
}
