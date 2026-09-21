<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Patients
    Route::resource('patients', PatientController::class);

    // Doctors
    Route::resource('doctors', DoctorController::class);

    // Departments
    Route::resource('departments', DepartmentController::class);

    // Appointments
    Route::resource('appointments', AppointmentController::class)->except(['edit']);

    // Medical Records
    Route::resource('medical-records', MedicalRecordController::class);

    // Prescriptions
    Route::resource('prescriptions', PrescriptionController::class)->except(['edit', 'update']);

    // Lab Tests
    Route::resource('lab-tests', LabTestController::class)->except(['edit', 'update']);
    Route::post('/lab-tests/{labTest}/results', [LabTestController::class, 'updateResults'])->name('lab-tests.results');

    // Invoices
    Route::resource('invoices', InvoiceController::class)->except(['edit', 'update']);
    Route::post('/invoices/{invoice}/payment', [InvoiceController::class, 'updatePayment'])->name('invoices.payment');

    // Rooms
    Route::resource('rooms', RoomController::class);

    // Beds / Admissions
    Route::resource('beds', BedController::class, ['parameters' => ['beds' => 'bedAdmission']])->except(['edit', 'update']);
    Route::post('/beds/{bedAdmission}/discharge', [BedController::class, 'discharge'])->name('beds.discharge');

    // Inventory
    Route::resource('inventory', InventoryController::class);
    Route::post('/inventory/{inventory}/adjust', [InventoryController::class, 'adjustStock'])->name('inventory.adjust');

    // Users (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/patients', [ReportController::class, 'patients'])->name('patients');
        Route::get('/appointments', [ReportController::class, 'appointments'])->name('appointments');
        Route::get('/revenue', [ReportController::class, 'revenue'])->name('revenue');
    });
});
