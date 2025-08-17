<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\DynamicContentManager;
use App\Http\Livewire\Admin\SectionManager;
use App\Http\Livewire\Admin\SolutionManager;
use App\Http\Livewire\Admin\FeatureManager;
use App\Http\Livewire\Admin\TechnologyManager;
use App\Http\Livewire\Admin\IndustryManager;
use App\Http\Livewire\Admin\TestimonialManager;
use App\Http\Livewire\Admin\TeamMemberManager;
use App\Http\Livewire\Admin\ContactManager;
use App\Http\Livewire\Admin\ProfileManager;
use App\Http\Livewire\Admin\SettingsManager;
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




// Route for fround-end pannel
Route::get('/', [UserController::class, 'index']);

// for admin panel
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/dynamic-content', DynamicContentManager::class)->name('admin.dynamic-content');
    Route::get('/sections', SectionManager::class)->name('admin.sections');
    Route::get('/solutions', SolutionManager::class)->name('admin.solutions');
    Route::get('/features', FeatureManager::class)->name('admin.features');
    Route::get('/technology', TechnologyManager::class)->name('admin.technology');
    Route::get('/industries', IndustryManager::class)->name('admin.industries');
    Route::get('/testimonials', TestimonialManager::class)->name('admin.testimonials');
    Route::get('/team', TeamMemberManager::class)->name('admin.team');
    Route::get('/contacts', ContactManager::class)->name('admin.contacts');
    Route::get('/settings', SettingsManager::class)->name('admin.settings');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/contact-submit', [\App\Http\Controllers\UserController::class, 'submitContact'])->name('contact.submit');
Route::post('/set-locale', function (\Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'fa', 'ps'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('setLocale');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile-manager', ProfileManager::class)->name('profile.admin.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
