<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MedicationPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_GB');

        $patientIds = DB::table('patients')->pluck('id')->toArray();
        $medicationIds = DB::table('medications')->pluck('id')->toArray();

        $frequencies = [
            'Once daily',
            'Twice daily',
            'Three times daily',
            'Four times daily',
            'Every 4 hours',
            'Every 6 hours',
            'Every 8 hours',
            'Once weekly',
            'As needed',
            'Before bed',
            'With meals'
        ];

        $assignedPairs = [];

        foreach ($patientIds as $patientId) {
            $numberOfMedications = $faker->numberBetween(0, 4);

            if ($numberOfMedications > 0) {
                $selectedMedications = $faker->randomElements($medicationIds, $numberOfMedications);

                foreach ($selectedMedications as $medicationId) {
                    $pairKey = "{$medicationId}-{$patientId}";

                    if (!in_array($pairKey, $assignedPairs)) {
                        $assignedPairs[] = $pairKey;

                        $startDate = $faker->dateTimeBetween('-1 year', 'now');

                        $hasEnded = $faker->boolean(30);
                        $endDate = $hasEnded
                            ? $faker->dateTimeBetween($startDate, 'now')->format('Y-m-d')
                            : null;

                        DB::table('medication_patient')->insert([
                            'medication_id' => $medicationId,
                            'patient_id' => $patientId,
                            'frequency' => $faker->randomElement($frequencies),
                            'start_date' => $startDate->format('Y-m-d'),
                            'end_date' => $endDate,
                            'instructions' => $faker->optional(0.5)->sentence(10),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
