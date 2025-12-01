# Patient Management System - CHT2520 Assignment 2

## Introduction

This Laravel 12 patient management system builds on top of my Assignment 1 submission by adding loads of advanced
features that make it way more professional and actually usable in a real healthcare setting. I've gone from a basic
CRUD app with just patients to a full-blown system with doctors, appointments, medications, medical records, proper user
roles, activity logging, and loads more.

The main focus of this README is to explain three big chunks of work I've done: Bootstrap 5 with DataTables for the
frontend, Spatie packages for security and compliance, and search/reporting features using Laravel Scout and Chart.js.
I'll talk about what I did, why I picked these tools, how I implemented them, and most importantly, what problems they
actually solve and where they fall short.

## Installation & Setup

To get this running on your machine, follow these steps:

```bash
# Install all the PHP dependencies
composer install

# Copy the environment file and generate app key
cp .env.example .env
php artisan key:generate

# Set up your database in the .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Configure Scout to use database driver
SCOUT_DRIVER=database

# Create the database (using custom command)
php artisan db:create

# Run migrations and seed the database with test data
php artisan migrate:fresh --seed

# Create storage link for file uploads
php artisan storage:link

# Start the development server
php artisan serve
```

**Demo Login Credentials:**

- Admin: admin@hospital.com / password
- Doctor: doctor@hospital.com / password
- Receptionist: receptionist@hospital.com / password
- Nurse: nurse@hospital.com / password

## Key Technologies & Features

### 1. Bootstrap 5 and DataTables.js

I completely ditched my custom CSS from Assignment 1 and rebuilt everything using Bootstrap. On top of that, I
integrated DataTables into every major table in the system, patients, doctors, medications, appointments,
medical records, and users.

I loaded everything via CDN in the main layout file app.blade.php:

```html
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
```

The 12 column layout that Bootstrap is based on adjusts according to the screen size. Using classes like col-md-3
implements a sizing of 3 columns wide of 12 (25%)
on medium screens and above, but reverts to stack vertically on smaller screens which is responsive design heaven. This
class approach eliminates @media queries which is great.
I used this approach on the dashboard to create the stat cards that show 4 evenly across the container, but then stack
on mobile:

```html
<!-- Dashboard Quick Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h3 class="text-primary">{{ $totalPatients }}</h3>
                <p class="mb-0">Total Patients</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h3 class="text-success">{{ $totalDoctors }}</h3>
                <p class="mb-0">Total Doctors</p>
            </div>
        </div>
    </div>
</div>
```

Bootstrap comes with a cards feature too which is great as it brings consistency and structure. They split similar to
HTML structure i.e. header/body/footer sections so they're organised. Not only that, they have utility classes like
bg-primary,
text-white, and border success that apply colour schemes in-line saving you writing any CSS. Another feature of
Bootstrap
is bits like mb-3 which adds
margin bottom and also text-center which centres the content:

```html

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">User Details</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Name:</div>
                    <div class="col-md-9">{{ $user->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Role:</div>
                    <div class="col-md-9">
                        <span class="badge bg-info">{{ $user->role_names }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit User</a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
```

Above is another snippet example of Bootstrap, the col-md-8 mx-auto give the card a width of 8 of 12 columns on medium
screens.
The mx-auto class centres block elements with margin-left/right: auto. In the card body a nest another Bootstrap grid
with widths of 3 and 9
to structure the labels and values nicely again these stack on mobile. I've used Badges which are small coloured labels
to display the roles.
These do come with predefined colours but I have modified them in the CSS to show further understanding. I've also used
buttons too which work very similar to badges.

```css
/* Custom Badge Colors */
.badge {
    display: inline-block;
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.badge.bg-primary {
    background-color: #3498db;
}

.badge.bg-success {
    background-color: #27ae60;
}

.badge.bg-danger {
    background-color: #e74c3c;
}
```

Bootstrap can also handles flash messages that are returned to the view which also have animation and dismiss features.

```html
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
```

The alert-dismissible class adds the dismiss button, and fade show provides animations when the alert appears
and disappears. The btn-close is handled by Bootstrap's JavaScript, clicking it closes the alert from the DOM with no
extra code.

DataTables was integrated to enhance every table with sorting, searching, pagination, and export functionality.

Here's the initialisation in patients/index.blade.php:

DataTables was integrated to enhance every table with sorting, searching, pagination, and export functionality. Here's
the initialization in patients/index.blade.php:

```javascript
$(document).ready(function () {
    $('#patientsTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy',    // Copy to clipboard
            'csv',     // Export as CSV
            'excel',   // Export as Excel
            'pdf',     // Export as PDF
            'print',   // Print view
            'colvis'   // Toggle column visibility
        ],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        responsive: true,
        order: [[0, 'asc']],
        language: {
            search: "Search patients:",
            searchPlaceholder: "Name, blood type, phone..."
        }
    });
});
```

Datatables is one of the best javascript libraries. This small section of code creates a professional table with a host
of features.
dom: 'Bfrtip' configures the layout, B represents buttons, f for filter, r for processing the display, t for table, i is
for information,
and p is for pagination. The buttons array give you access to export functionality in a vast array of options without
any coding at all.
Length menu controls how many records to display, and responsive: true makes the table responsive.

The two solutions above solves a lot of problems for developers. Bootstrap obviously cuts down the amount of CSS that
has to be written and enables all the simple problems to be solved quickly. DataTables solves even more complex problems which 
can be time consuming and repetitive, search, exports, 
even sorting, are all painful complex problems to manual write and this library literally does it. The only downside to
my implementation in this app is that I've used cdn's which is okay here as an example. But in the real world when theres 50,000 records and not
300, a proper AJAX like backend would have to be implemented for it to work. The way I've used it here all the records are passed straight to 
the front end which is not only a safety concern but also a UX/processing speed problem. Also if the internet connection is compromised in any 
way it wouldn't work so installed libraries are a must really.

### 2. Spatie Permission & Activity Log

I've used laravel-permission to create role based access control within the application, and I've also implemented laravel-activitylog to record
an audit trail of who, when, what, and how. There are four roles within the app, they are Admin, Doctor, Receptionist, and Nurse. Within the four
roles there are 25 different permissions to control who can access what across the entire application. This is set up from a migration and seeder classes.

Here's how I set up the seeder RolePermissionSeeder.php:

```php
// Create Doctor role with specific permissions
$doctorRole = Role::create(['name' => 'Doctor']);
$doctorRole->givePermissionTo([
    'view-patients',
    'create-patients',
    'edit-patients',
    'view-appointments',
    'create-appointments',
    'edit-appointments',
    'delete-appointments',
    'view-medical-records',
    'upload-medical-records',
    'download-medical-records',
]);
```

The package creates database tables roles, permissions, and model_has_roles, role_has_permissions, and model_has_permissions.
Polymorphic relationships are used to attach permissions and roles to any model. When $user->hasRole('Admin') or $user->
can('delete-patients')is called, pivot tables are queried to check if they are authorised to implement the action called.

It also creates protections through the middleware that can be used in the web.php file as shown below:

```php
// Only admins can manage users
Route::middleware(['role:Admin'])->resource('users', UserController::class);

// Authenticated users can access these
Route::middleware('auth')->group(function () {
    Route::resource('patients', PatientController::class);
    Route::resource('appointments', AppointmentController::class);
});
```

The same principle applies, the users auth level is checked before the request is sent to the controller.
If approved it is sent if it is denied a 403 error is thrown and the user is denied access.

Another great use of this package is that it can be used in blade views to show/hide elements of the page which should only be seen by
people with permissions to do so.

```blade
@can('create-patients')
    <a href="{{ route('patients.create') }}" class="btn btn-success">
        Add New Patient
    </a>
@endcan

@can('delete-patients')
    <form method="POST" action="{{ route('patients.destroy', $patient->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
    </form>
@endcan
```

When @can is used Spatie hooks into Laravels gate system and checks the authentication before rendering to the host.

For activity logging, I just added a trait to all my models:

```php
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Patient extends Model
{
    use LogsActivity;
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'age', 'sex', 'blood_type', 'phone'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Patient was {$eventName}");
    }
}
```

The above method enables tracking of changes to any patient model. In the return statement logOnly specifies which
attributes to track changes of. logOnlyDirty sets the system to only log actual changes and not updates where nothing has changed. I'd like to think
dontSubmitEmptyLogs was self explanatory, and the setDescriptionForEvent uses an arrow function to create custom descriptions. Event names
created, updated, and deleted are taken and inserted into the statement to make it more readable inside the DB table.

These two packages I've used a seriously impressive and solve problems that would take an eternity to solve. Again this
is all great within this application logging everything inside a table but a well used system would produce a massive table over time so some pruning and
commands to delete old logs would be needed, queueing the logging at high traffic times may be needed too.

### 3. Search and Reporting

This system also has global search implemented with Laravel Scout across the five main areas of patients, doctors, appointments, medications,
and medical records. For the reporting I've used Chart.js for data visualisation.

Each model has a searchable trait and defines which fields are searchable:

```php
use Laravel\Scout\Searchable;

class Patient extends Model
{
    use Searchable;
    
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'blood_type' => $this->blood_type,
            'phone' => $this->phone,
            'age' => $this->age,
        ];
    }
}
```

The SearchService then calls Scout's search method across all the models:

```php
protected function searchPatients(string $query): Collection
{
    return Patient::search($query)
        ->get()
        ->map(function ($patient) {
            return [
                'type' => 'Patient',
                'title' => $patient->name,
                'subtitle' => "Blood Type: {$patient->blood_type}",
                'url' => route('patients.show', $patient->id)
            ];
        });
}
```

Laravel scout normalises search across the different models so you can always call Model::search($query). The database
driver uses the LIKE eloquent under the hood, but we could swap the SCOUT_DRIVER in the .env file to Algolia or Meilisearch and it would
still work.

For the reports I created a reportService class that aggregates data:

```php
public function getPatientStatistics()
{
    return [
        'bloodTypeStats' => Patient::selectRaw('blood_type, COUNT(*) as count')
            ->groupBy('blood_type')
            ->get(),
        'ageGroups' => [
            '0-18' => Patient::whereBetween('age', [0, 18])->count(),
            '19-35' => Patient::whereBetween('age', [19, 35])->count(),
            '36-50' => Patient::whereBetween('age', [36, 50])->count(),
            '51-65' => Patient::whereBetween('age', [51, 65])->count(),
            '65+' => Patient::where('age', '>', 65)->count(),
        ],
        'sexStats' => Patient::selectRaw('sex, COUNT(*) as count')
            ->groupBy('sex')
            ->get(),
    ];
}
```
The above method gets all the data for the patients report section in three groups, bloodTypeStats, ageGroups, and sexStats.
The first group which collects blood types uses raw SQL and counts all the blood types, it then uses the groupBy method, and is finally executed
by the get() command. Age groups is driven by 5 eloquent commands and collected as inside an array, one for each group. Each command uses the 
whereBetween method to set a min and max for each count except for the 65+ where it isn't needed. The sex stats method works similar to
the blood type except it counts from a different column. The controller then passes the data to the view where Chart.js takes over to process.


When the data hits the view these constant variables are created. They receive PHP collection arrays, and the json_encode converts them to 
javascript arrays using the pluck method to extract the data it needs. Using {!! !!} instead of {{ }} outputs raw JSON with HTML encoding.

```javascript
const bloodTypeLabels = {!! json_encode($bloodTypeStats->pluck('blood_type')) !!};
const bloodTypeData = {!! json_encode($bloodTypeStats->pluck('count')) !!};

const ageGroupLabels = {!! json_encode(array_keys($ageGroups)) !!};
const ageGroupData = {!! json_encode(array_values($ageGroups)) !!};

const sexLabels = {!! json_encode($sexStats->pluck('sex')) !!};
const sexData = {!! json_encode($sexStats->pluck('count')) !!};
```
Once that data is collected and converted, I use the data to create three charts for each data set collection.

```javascript
const bloodTypeCtx = document.getElementById('bloodTypeChart').getContext('2d');
new Chart(bloodTypeCtx, {
    type: 'pie',
    data: {
        labels: bloodTypeLabels,
        datasets: [{
            data: bloodTypeData,
            backgroundColor: ['#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#e67e22', '#34495e']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {position: 'bottom'}
        }
    }
});
```
First, a new const is created which grabs the id and sets the context of the chart library. We then create a new chart object with the bloodTypeCtx 
variable and set the type to pie chart. The data variables are then embedded into the chart, one that sets the label which in this case is all the blood 
types in the system, and then the second variable bloodTypeData, which has all the counts of each blood type. The colour of each section is also set
in the backgroundColor option here too. In the last section options, I use responsive true to make the chart resize and stack on smaller screens, and
also set the legend in the bottom position so that it sits underneath the pie chart.

Laravel scout solves so many problems in terms of global searching, and the implementation reduces the implementation time tenfold. Without it
there would be repeated query logic all over models and controllers. Chart.js is another fantastic bit of kit and is on par with datatables in
value. It would literally take forever to implement this in backend/frontend logic, and this literally gives you it for free solving so many 
problems for users in the process.

## Other Features Worth Mentioning

### Database Relationships

I've expanded the database and its tables to represent a more realistic setting. I've added pivot tables that also hold extra bits of information
and also set the relationships within the models so that it all works together nicely. I know this maybe seen as advanced for the scope of this 
project, but it is something I have been working with on a daily and is pretty much a standard working practice.

### File Upload System

Medical records can be uploaded in PDF and image formats, file type and size validation implemented and stored in storage/app/medical-records.
Filenames are prefixed with timestamps to avoid conflicts, with automatic file deletes when the record is removed. Also has file download functionality.

### Calendar View

FullCalendar.js implemented in the appointments section with colour coded status. Details can be accessed by clicking on an appointment to see
details appear in a model where you can quick update without leaving the calendar. Filters have also been included.

### Laravel Breeze Authentication

Added login with Breeze, this is a free feature as its already built in. Nothing fancy about this but it works. The password reset sends to logs
the produced link in the logs works but i haven't structured the password reset page. Works perfectly for this assignment.
