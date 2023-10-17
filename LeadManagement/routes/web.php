<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;



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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/***************************************************/

//Home Controller
Route::get('home',[AuthController::class,'AuthFn'])->middleware('auth')->name('home');

//Executive routes--

//Adding Leads by Executive
Route::get('/add_lead_page',[CrudController::class,'addLeadPage'])->middleware('auth')->name('addLeadPage');
Route::post('add_lead',[CrudController::class,'addLead'])->name('addLead');

//Editing Leads by Executive
Route::get('/edit_lead/{id}',[CrudController::class,'editLeadPage'])->middleware('auth')->name('editLeadPage');
Route::post('/editing_lead/{id}',[CrudController::class,'editLead'])->name('editLead');

//Deleting Leads for both Admin and Executive
Route::get('/delete_lead/{id}',[CrudController::class,'deleteLead'])->name('deleteLead');


//Duplication Handling routes
Route::get('add_duplicate',[CrudController::class,'addDuplicate'])->middleware('auth')->name('addDuplicate');
Route::get('reject_duplicate',[CrudController::class,'rejectDuplicate'])->name('rejectDuplicate');

//Admin routes--

//Setting Executive Status by Admin
Route::post('/set_status',[CrudController::class,'setStatus'])->name('setStatus');


//Setting Contact Type
Route::post('/set_option',[CrudController::class,'setOption'])->name('setOption');


//filter
Route::post('/filter_category',[CrudController::class,'filterCategory'])->name('filterCategory');
Route::post('/filter_executive',[CrudController::class,'filterExecutive'])->name('filterExecutive');
Route::post('/filter_higher',[CrudController::class,'filterByHigher'])->name('filterByHigher');
Route::post('/filter_lower',[CrudController::class,'filterByLower'])->name('filterByLower');

    

//Admin Middleware
Route::middleware(['admin','auth'])->group(function () {
    Route::get('leads',[CrudController::class,'leadPage'])->name('leadPage');
    Route::get('/add_lead_admin',[CrudController::class,'addLeadPageAdmin'])->middleware(['admin'])->name('addLeadPageAdmin');
    Route::post('/adding_lead_admin',[CrudController::class,'addLeadAdmin'])->name('addLeadAdmin');
    Route::get('/edit_lead_admin/{id}',[CrudController::class,'editLeadPageAdmin'])->name('editLeadPageAdmin');
    Route::post('/editing_lead_admin/{id}',[CrudController::class,'editLeadAdmin'])->name('editLeadAdmin');
    Route::get('/edit_executive/{id}',[CrudController::class,'executiveEdit'])->name('executiveEdit');
    Route::post('/editing_executive/{id}',[CrudController::class,'editExecutive'])->name('editExecutive');
});


