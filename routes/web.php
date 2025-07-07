<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Settings
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Policy
    Volt::route('policy/application', 'Policy.policy-application')->name('policy.application');
    Volt::route('policy/types', 'Policy.policy-types')->name('policy.types');
    Volt::route('policy/renewal', 'Policy.policy-renewal')->name('policy.renewal');
    Volt::route('policy/tracking', 'Policy.policy-tracking')->name('policy.tracking');
    Volt::route('policy/documents', 'Policy.policy-documents')->name('policy.documents');

    // Payments
    Volt::route('payments/form', 'Payments.payment-form')->name('payments.form');
    Volt::route('payments/history', 'Payments.payment-history')->name('payments.history');
    Volt::route('payments/reminders', 'Payments.payment-reminders')->name('payments.reminders');
    Volt::route('payments/premium-calculator', 'Payments.premium-calculator')->name('payments.premium-calculator');

    // Dashboards
    Volt::route('dashboard/admin', 'Admin.admin-dashboard')->name('dashboard.admin');
    Volt::route('dashboard/company', 'Company.company-official-dashboard')->name('dashboard.company');

    // Reports
    Volt::route('reports/claims', 'Reports.claims-reports')->name('reports.claims');
    Volt::route('reports/financial', 'Reports.financial-reports')->name('reports.financial');
    Volt::route('reports/user-analytics', 'Reports.user-analytics')->name('reports.user-analytics');

    // Communication
    Volt::route('communication/email', 'Communication.email-notifications')->name('communication.email');
    Volt::route('communication/sms', 'Communication.sms-integration')->name('communication.sms');
    Volt::route('communication/in-app', 'Communication.in-app-notifications')->name('communication.in-app');
    Volt::route('communication/feedback', 'Communication.feedback-system')->name('communication.feedback');
});

require __DIR__.'/auth.php';
