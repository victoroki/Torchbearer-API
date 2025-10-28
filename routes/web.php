<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return 'Cache cleared!';
});

Route::get('/test-mail-config', function () {
    return [
        'MAIL_MAILER' => config('mail.mailers.smtp.host'),
        'MAIL_HOST' => config('mail.mailers.smtp.host'),
        'MAIL_PORT' => config('mail.mailers.smtp.port'),
        'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
        'MAIL_FROM' => config('mail.from'),
    ];
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/certicate/view', function () {
    $logoBase64 = 'https://i.postimg.cc/nhdkjKJr/image-removebg-preview-1.png';
    $stampBase64 = 'https://i.postimg.cc/DwBTSN0H/Untitled-design.png';
    $recipientName = 'Victor Mongare';
    $certificateId = 'CERT-ABCDEFGHIJ';
    $issueDate = now()->format('Y-m-d');
    $courseName = '30 hours solar design masterclass';
    $courseDescription = 'Has successfully completed 30 hours solar design masterclass using pvsyst, sketch up and AUTO CAD';
    return view('certificates.certificate_pdf', compact('recipientName', 'courseDescription', 'courseName', 'issueDate', 'certificateId', 'courseDescription'));
})->name('certificate.view');

Route::get('/create-storage-link', function () {
    try {
        Artisan::call('storage:link');
        return '✅ Storage link created successfully!';
    } catch (\Exception $e) {
        return '❌ Error creating link: ' . $e->getMessage();
    }
});

// Communication Module Routes
Route::middleware(['auth'])->group(function () {
    
    // Communications routes
    Route::prefix('communications')->name('communications.')->group(function () {
        Route::get('/', [App\Http\Controllers\CommunicationController::class, 'index'])->name('index');
        
        // Contacts management
        Route::resource('contacts', App\Http\Controllers\CommunicationContactController::class);
        
        // Email Communications
        Route::prefix('email')->name('email.')->group(function () {
            Route::get('/', [App\Http\Controllers\EmailCommunicationController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\EmailCommunicationController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\EmailCommunicationController::class, 'store'])->name('store');
            Route::get('/{communication}', [App\Http\Controllers\EmailCommunicationController::class, 'show'])->name('show');
            Route::post('/{communication}/send', [App\Http\Controllers\EmailCommunicationController::class, 'send'])->name('send');
        });
        
        // WhatsApp Communications
        Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
            Route::get('/', [App\Http\Controllers\WhatsAppController::class, 'index'])->name('index');
            
            // Contacts
            Route::get('/contacts', [App\Http\Controllers\WhatsAppController::class, 'contacts'])->name('contacts');
            Route::post('/contacts', [App\Http\Controllers\WhatsAppController::class, 'storeContact'])->name('contacts.store');
            Route::put('/contacts/{id}', [App\Http\Controllers\WhatsAppController::class, 'updateContact'])->name('contacts.update');
            Route::delete('/contacts/{id}', [App\Http\Controllers\WhatsAppController::class, 'destroyContact'])->name('contacts.destroy');
            
            // Send Message
            Route::get('/send', [App\Http\Controllers\WhatsAppController::class, 'sendForm'])->name('send');
            Route::post('/send', [App\Http\Controllers\WhatsAppController::class, 'sendMessage'])->name('send.store');
            
            // Broadcast
            Route::get('/broadcast', [App\Http\Controllers\WhatsAppController::class, 'broadcastForm'])->name('broadcast');
            Route::post('/broadcast', [App\Http\Controllers\WhatsAppController::class, 'broadcast'])->name('broadcast.store');
            
            // History
            Route::get('/history', [App\Http\Controllers\WhatsAppController::class, 'history'])->name('history');
            
            // Balance Check
            Route::get('/balance', [App\Http\Controllers\WhatsAppController::class, 'checkBalance'])->name('balance');
        });
        

    });
});

// Other Resource Routes
Route::resource('certificates', App\Http\Controllers\CertificateController::class);
Route::resource('courses', App\Http\Controllers\CourseController::class);
Route::post('courses/{id}/toggle-status', [App\Http\Controllers\CourseController::class, 'toggleStatus'])->name('courses.toggleStatus');
Route::resource('events', App\Http\Controllers\EventController::class);
Route::resource('form-submissions', App\Http\Controllers\FormSubmissionController::class);
Route::resource('gallery-items', App\Http\Controllers\GalleryItemController::class);
Route::resource('involvement-submissions', App\Http\Controllers\InvolvementSubmissionController::class);
Route::resource('license-classes', App\Http\Controllers\LicenseClassController::class);
Route::resource('resources', App\Http\Controllers\ResourceController::class);
Route::resource('trainers', App\Http\Controllers\TrainerController::class);
Route::resource('training-programs', App\Http\Controllers\TrainingProgramController::class);
Route::resource('useful-links', App\Http\Controllers\UsefulLinkController::class);
Route::resource('users', App\Http\Controllers\UserController::class);
