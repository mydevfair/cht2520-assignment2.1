<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Patient Permissions
            'view-patients',
            'create-patients',
            'edit-patients',
            'delete-patients',

            // Doctor Permissions
            'view-doctors',
            'create-doctors',
            'edit-doctors',
            'delete-doctors',

            // Medication Permissions
            'view-medications',
            'create-medications',
            'edit-medications',
            'delete-medications',

            // Appointment Permissions
            'view-appointments',
            'create-appointments',
            'edit-appointments',
            'delete-appointments',
            'view-calendar',

            // Medical Record Permissions
            'view-medical-records',
            'upload-medical-records',
            'download-medical-records',
            'delete-medical-records',

            // Report Permissions
            'view-reports',
            'export-reports',

            // Search Permissions
            'use-advanced-search',

            // Activity Log Permissions
            'view-activity-log',

            // User Management Permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'manage-roles',

            // Settings Permissions
            'manage-settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


        // 1. Admin Role - Full Access
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 2. Doctor Role - Can manage patients, appointments, medical records
        $doctorRole = Role::create(['name' => 'Doctor']);
        $doctorRole->givePermissionTo([
            'view-patients',
            'create-patients',
            'edit-patients',

            'view-doctors',

            'view-medications',

            'view-appointments',
            'create-appointments',
            'edit-appointments',
            'delete-appointments',
            'view-calendar',

            'view-medical-records',
            'upload-medical-records',
            'download-medical-records',

            'view-reports',
            'export-reports',

            'use-advanced-search',
        ]);

        // 3. Receptionist Role - Can manage appointments, view patients
        $receptionistRole = Role::create(['name' => 'Receptionist']);
        $receptionistRole->givePermissionTo([
            'view-patients',
            'create-patients',
            'edit-patients',

            'view-doctors',

            'view-medications',

            'view-appointments',
            'create-appointments',
            'edit-appointments',
            'delete-appointments',
            'view-calendar',

            'view-medical-records',

            'use-advanced-search',
        ]);

        // 4. Nurse Role - Can view and update patient records
        $nurseRole = Role::create(['name' => 'Nurse']);
        $nurseRole->givePermissionTo([
            'view-patients',
            'edit-patients',

            'view-doctors',

            'view-medications',
            'create-medications',
            'edit-medications',

            'view-appointments',
            'view-calendar',

            'view-medical-records',
            'upload-medical-records',
            'download-medical-records',

            'use-advanced-search',
        ]);

        // 5. Viewer Role - Read only access for demos and recruiters
        $viewerRole = Role::create(['name' => 'Viewer']);
        $viewerRole->givePermissionTo([
            'view-patients',
            'view-doctors',
            'view-medications',
            'view-appointments',
            'view-calendar',
            'view-medical-records',
            'view-reports',
            'use-advanced-search',
        ]);

        // Create Demo Users with Roles

        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

        // Doctor User
        $doctor = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'doctor@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $doctor->assignRole('Doctor');

        // Receptionist User
        $receptionist = User::create([
            'name' => 'Emily Brown',
            'email' => 'receptionist@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $receptionist->assignRole('Receptionist');

        // Nurse User
        $nurse = User::create([
            'name' => 'James Wilson',
            'email' => 'nurse@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $nurse->assignRole('Nurse');

        // Viewer User
        $viewer = User::create([
            'name' => 'Demo Viewer',
            'email' => 'demo@hospital.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $viewer->assignRole('Viewer');

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Demo users created:');
        $this->command->info('Admin: admin@hospital.com / password');
        $this->command->info('Doctor: doctor@hospital.com / password');
        $this->command->info('Receptionist: receptionist@hospital.com / password');
        $this->command->info('Nurse: nurse@hospital.com / password');
        $this->command->info('Viewer: demo@hospital.com / password');
    }
}
