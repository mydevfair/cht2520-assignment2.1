<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medications = [
            [
                'name' => 'Paracetamol',
                'type' => 'Analgesic',
                'manufacturer' => 'GSK',
                'description' => 'Pain relief and fever reducer',
            ],
            [
                'name' => 'Ibuprofen',
                'type' => 'NSAID',
                'manufacturer' => 'Pfizer',
                'description' => 'Anti-inflammatory and pain relief',
            ],
            [
                'name' => 'Amoxicillin',
                'type' => 'Antibiotic',
                'manufacturer' => 'Sandoz',
                'description' => 'Treats bacterial infections',
            ],
            [
                'name' => 'Omeprazole',
                'type' => 'Proton Pump Inhibitor',
                'manufacturer' => 'AstraZeneca',
                'description' => 'Reduces stomach acid production',
            ],
            [
                'name' => 'Metformin',
                'type' => 'Antidiabetic',
                'manufacturer' => 'Bristol-Myers Squibb',
                'description' => 'Controls blood sugar levels in diabetes',
            ],
            [
                'name' => 'Atorvastatin',
                'type' => 'Statin',
                'manufacturer' => 'Pfizer',
                'description' => 'Lowers cholesterol levels',
            ],
            [
                'name' => 'Amlodipine',
                'type' => 'Calcium Channel Blocker',
                'manufacturer' => 'Pfizer',
                'description' => 'Treats high blood pressure',
            ],
            [
                'name' => 'Salbutamol',
                'type' => 'Bronchodilator',
                'manufacturer' => 'GSK',
                'description' => 'Relieves asthma symptoms',
            ],
            [
                'name' => 'Levothyroxine',
                'type' => 'Thyroid Hormone',
                'manufacturer' => 'Accord',
                'description' => 'Treats hypothyroidism',
            ],
            [
                'name' => 'Sertraline',
                'type' => 'SSRI',
                'manufacturer' => 'Pfizer',
                'description' => 'Treats depression and anxiety',
            ],
            [
                'name' => 'Warfarin',
                'type' => 'Anticoagulant',
                'manufacturer' => 'Bristol-Myers Squibb',
                'description' => 'Prevents blood clots',
            ],
            [
                'name' => 'Codeine',
                'type' => 'Opioid Analgesic',
                'manufacturer' => 'GSK',
                'description' => 'Pain relief for moderate pain',
            ],
            [
                'name' => 'Prednisolone',
                'type' => 'Corticosteroid',
                'manufacturer' => 'Actavis',
                'description' => 'Reduces inflammation',
            ],
            [
                'name' => 'Ciprofloxacin',
                'type' => 'Antibiotic',
                'manufacturer' => 'Bayer',
                'description' => 'Treats bacterial infections',
            ],
            [
                'name' => 'Ramipril',
                'type' => 'ACE Inhibitor',
                'manufacturer' => 'Sanofi',
                'description' => 'Treats high blood pressure and heart failure',
            ],
            [
                'name' => 'Aspirin',
                'type' => 'Antiplatelet',
                'manufacturer' => 'Bayer',
                'description' => 'Prevents heart attacks and strokes',
            ],
            [
                'name' => 'Gabapentin',
                'type' => 'Anticonvulsant',
                'manufacturer' => 'Pfizer',
                'description' => 'Treats nerve pain and seizures',
            ],
            [
                'name' => 'Losartan',
                'type' => 'ARB',
                'manufacturer' => 'Merck',
                'description' => 'Treats high blood pressure',
            ],
            [
                'name' => 'Furosemide',
                'type' => 'Diuretic',
                'manufacturer' => 'Sanofi',
                'description' => 'Removes excess fluid from the body',
            ],
            [
                'name' => 'Citalopram',
                'type' => 'SSRI',
                'manufacturer' => 'Lundbeck',
                'description' => 'Treats depression and anxiety',
            ],
        ];

        foreach ($medications as $medication) {
            DB::table('medications')->insert([
                'name' => $medication['name'],
                'type' => $medication['type'],
                'manufacturer' => $medication['manufacturer'],
                'description' => $medication['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('20 medications created successfully!');
    }
}
