<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_GB');

        // Get all patient and doctor IDs
        $patientIds = DB::table('patients')->pluck('id')->toArray();
        $doctorIds = DB::table('doctors')->pluck('id')->toArray();

        if (empty($patientIds) || empty($doctorIds)) {
            $this->command->warn('No patients or doctors found. Please seed patients and doctors first.');
            return;
        }

        $reasons = [
            'General Checkup',
            'Follow-up Consultation',
            'Blood Pressure Check',
            'Vaccination',
            'Lab Results Discussion',
            'Chronic Disease Management',
            'New Patient Consultation',
            'Prescription Renewal',
            'Physical Examination',
            'Minor Surgery Consultation',
            'Diabetes Review',
            'Asthma Review',
            'Mental Health Consultation',
            'Skin Condition Review',
            'Joint Pain Assessment',
        ];

        $statuses = ['scheduled', 'completed', 'cancelled'];
        $statusWeights = [60, 30, 10]; // 60% scheduled, 30% completed, 10% cancelled

        // Create 50 appointments
        for ($i = 0; $i < 50; $i++) {
            // Generate random date (past 30 days to future 60 days)
            $daysOffset = $faker->numberBetween(-30, 60);
            $appointmentDate = Carbon::now()->addDays($daysOffset);

            // Generate appointment time (9 AM to 5 PM, 30-minute intervals)
            $hour = $faker->numberBetween(9, 16);
            $minute = $faker->randomElement([0, 30]);
            $appointmentTime = sprintf('%02d:%02d:00', $hour, $minute);

            // Weighted random status
            $status = $faker->randomElement(
                array_merge(
                    array_fill(0, $statusWeights[0], $statuses[0]),
                    array_fill(0, $statusWeights[1], $statuses[1]),
                    array_fill(0, $statusWeights[2], $statuses[2])
                )
            );

            // If appointment is in the past, it should be completed or cancelled
            if ($appointmentDate->isPast() && $status === 'scheduled') {
                $status = $faker->randomElement(['completed', 'cancelled']);
            }

            // If appointment is in the future, it should be scheduled
            if ($appointmentDate->isFuture() && $status !== 'scheduled') {
                $status = 'scheduled';
            }

            DB::table('appointments')->insert([
                'patient_id' => $faker->randomElement($patientIds),
                'doctor_id' => $faker->randomElement($doctorIds),
                'appointment_date' => $appointmentDate->format('Y-m-d'),
                'appointment_time' => $appointmentTime,
                'reason' => $faker->randomElement($reasons),
                'status' => $status,
                'notes' => $status === 'completed' ? $faker->optional(0.7)->sentence(10) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('50 appointments created successfully!');

        // Display statistics
        $scheduled = DB::table('appointments')->where('status', 'scheduled')->count();
        $completed = DB::table('appointments')->where('status', 'completed')->count();
        $cancelled = DB::table('appointments')->where('status', 'cancelled')->count();

        $this->command->info("  - Scheduled: {$scheduled}");
        $this->command->info("  - Completed: {$completed}");
        $this->command->info("  - Cancelled: {$cancelled}");
    }
}
