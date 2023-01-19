<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CmsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/check/profile/{id}', function() {
	$id = \Request::segment(3);
    
	\App\Services\ProfileService::checkProfile($id); 
}); 

Route::get('/', [AuthController::class, 'index']);

Route::group(['middleware' => ['lock', 'visitor', 'xss']], function() {
    Route::get('/form', [HomeController::class, 'index'] );
    Route::get('/form/{keyword}', [HomeController::class, 'index'] );
});

Route::group(['middleware' => ['lock', 'xss']], function() {
    Route::post('/profile/details', [HomeController::class, 'details']);
    Route::post('/save', [HomeController::class, 'save'])->name('save');
    Route::post('/generate/qr-code', [HomeController::class, 'codes']);
    Route::post('/send', [HomeController::class, 'sendNotification']);
    Route::get('/send', [HomeController::class, 'testNotification']);
});

Route::group(['middleware' => 'xss'], function() {
    Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/503', [AuthController::class, 'error503']);

Route::get('/offline', function () {    
    return view('vendor.laravelpwa.offline');
});

Route::get('/clear', function() {
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');

    dd('Done!');
});

Route::get('/db-dump', function () {    
    \Artisan::call('migrate');

    dd('Done!');
});

Route::get('/dump-users', function() {
    \App\Models\User::create([
        'name'     => 'Igor M. Lucmayon',
        'email'    => 'eighore04@gmail.com',
        'password' => '$2y$10$neaDLp9Xbr4iZ3Y/LVtlkefHLsIyv86.jesA6i./91BewObEB1fni',
        'status'   => 1,
        'group_id' => 1,
        'group_name' => 'Administrator',
        'created_at' => \Carbon\Carbon::now()
    ]);

    \App\Models\User::create([
        'name'     => 'Ana Lyn V. Magsombol',
        'email'    => 'analyn.magsombol@motolite.com',
        'password' => '$2y$10$neaDLp9Xbr4iZ3Y/LVtlkefHLsIyv86.jesA6i./91BewObEB1fni',
        'status'   => 1,
        'group_id' => 2,
        'group_name' => 'Human Resource ',
        'created_at' => \Carbon\Carbon::now()
    ]);
});

Route::get('/edit-users', function() {
    $user = \App\Models\User::find(1);
    $user->update([
        'name'     => 'Patrick Lo',
        'email'    => 'patrick.lo@motolite.com',
        'password' => '$2y$10$neaDLp9Xbr4iZ3Y/LVtlkefHLsIyv86.jesA6i./91BewObEB1fni',
        'status'   => 1,
        'group_id' => 1,
        'group_name' => 'Administrator',
        'updated_at' => \Carbon\Carbon::now()
    ]);
});

Route::get('/dump-group', function() {
    \App\Models\UserGroup::create([
        'group_name' => 'Administrator',
        'created_at' => \Carbon\Carbon::now()
    ]);

    \App\Models\UserGroup::create([
        'group_name' => 'Human Resource',
        'created_at' => \Carbon\Carbon::now()
    ]);

    \App\Models\UserGroup::create([
        'group_name' => 'Life Care',
        'created_at' => \Carbon\Carbon::now()
    ]);

    \App\Models\UserGroup::create([
        'group_name' => 'Guard',
        'created_at' => \Carbon\Carbon::now()
    ]);
});

Route::get('/dump/employee-type-data', function () {    
    \App\Models\EmployeeType::create([
        'type_name'  => 'Elixer', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

    \App\Models\EmployeeType::create([
        'type_name'  => 'Topspot', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

    \App\Models\EmployeeType::create([
        'type_name'  => 'Firstcore', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

    \App\Models\EmployeeType::create([
        'type_name'  => 'Local Hire', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

    \App\Models\EmployeeType::create([
        'type_name'  => 'Direct Hire', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

    \App\Models\EmployeeType::create([
        'type_name'  => 'Whiteshield', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

    \App\Models\EmployeeType::create([
        'type_name'  => 'Matrix', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

    \App\Models\EmployeeType::create([
        'type_name'  => 'El Tigre', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
});

Route::get('/dump-data', function () {    
    \App\Models\Company::create([
        'company'    => 'AGUS DEVELOPMENT CORPORATION', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'AMARELA INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'BARDSTOWN INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'BARTLE BEYL INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'CORPORATE HR & CONSULTING SERVICES',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'DELISCENTS INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'EL TIGRE',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'ELIXER MULTI-PURPOSE COOPERATIVE',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'EVERGREEN ENVIRONMENTAL RESOURCES INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'FIRSTCORE MULTI-PURPOSE COOPERATIVE',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'FRONTLAKE INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'GRANTLINE INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'HANSBURY INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'ITALIA GUSTO INC',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'JANTRO SECURITY AGENCY',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'KAISA CONSULTING',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'KNOXPORT INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'MATRIX',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'MULTI-LIFECARE FOUNDATION INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'NEW VENTURES',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'NORTHPOINT INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'NUTRI FOR YOU',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'NUTRIDOUGH INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'OFFICE OF THE CHAIRMAN BOARD',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'ONE FOOD GROUP MANAGEMENT SERVICES  INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'ORIENTAL AND MOTOLITE MARKETING CORP.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'ORIENTAL YUASA BATTERY CORP',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'PHILIPPINE BATTERIES INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'PHILIPPINE RECYCLER`S INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'POULTRYMAX OMNIS INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'QUANTUS BUSINESS SERVICES INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'RAMCAR BATTERIES INTERNATIONAL LIMITED',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'RAMCAR TECHNOLOGY INC',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'SANTIAGO & SANTIAGO LAW OFFICE',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'SOLUTIONS EXPERTS AND ENABLERS INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'SPECAL PROJECT DEVELOPMENT',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'STA. MARIA INDUSTRIAL PARK CORP.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'TOPSPOT MULTI-PURPOSE COOPERATIVE',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'UBER DELI',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'UMALAG INC.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Company::create([
        'company'    => 'WHITESHIELD SECURITY & INVESTIGATION AGENCY CORP.',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

    \App\Models\Checklist::create([
        'checklist'  => 'Diarrhea (Pagtatae)', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Cough (Ubo)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Anorexia (Walang gana sa pagkain)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Decreased sense of smell (Bawas ang pang-amoy)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Sore Throat (Pananakit ng lalamunan)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Decreased sense of taste (Bawas ang panlasa)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Shortness of breath/Dyspnea (Hirap sa paghinga)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Myalgia (Sakit sa kalamnan)', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Headache (Pananakit ng ulo)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Colds (Sipon)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Fever (Lagnat)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Nausea/Vomiting (Pagsusuka)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Body Pains (Pananakit ng katawan)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'General Weakness/Fatigue (Panghihina)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Coryza (Baradong ilong)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
    \App\Models\Checklist::create([
        'checklist'  => 'Altered Mental Status (Pagbabago sa lagay ng kaisipan)',
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);

});

Route::get('/db-truncate', function(){
    \DB::table('profile_info')->truncate();
});

Route::get('/send/report', [DashboardController::class, 'sendReport']);

Route::group(['middleware' => ['checkuser', 'xss']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/show', [DashboardController::class, 'show']);
    Route::get('/dashboard/view/answer/{id}', [DashboardController::class, 'view'])->name('answer.view');
    Route::post('/dashboard/export', [DashboardController::class, 'exportReport']);

    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/show', [UserController::class, 'show']);
    Route::get('/user/add', [UserController::class, 'add'])->name('user.add');
    Route::post('/user/save', [UserController::class, 'save'])->name('user.save');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/status', [UserController::class, 'status'])->name('user.status');
    Route::post('/user/reset-password', [UserController::class, 'reset'])->name('user.reset.password');  
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('change.password');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update.password');

    Route::get('/employee', [ProfileController::class, 'index'])->name('employee');
    Route::get('/employee/show', [ProfileController::class, 'show']);
    Route::get('/employee/add', [ProfileController::class, 'add'])->name('employee.add');
    Route::post('/employee/save', [ProfileController::class, 'save'])->name('employee.save');
    Route::get('/employee/edit/{id}', [ProfileController::class, 'edit'])->name('employee.edit');
    Route::post('/employee/update', [ProfileController::class, 'update'])->name('employee.update');
    Route::post('/employee/status', [ProfileController::class, 'status'])->name('employee.status');
    Route::get('/employee/import', [ProfileController::class, 'importForm'])->name('employee.import');
    Route::post('/employee/import', [ProfileController::class, 'importData'])->name('employee.import.save');
    Route::get('/employee/export', [ProfileController::class, 'exportData'])->name('employee.export');


    Route::get('/cms/checklist', [CmsController::class, 'checklist'])->name('cms.checklist');
    Route::get('/cms/checklist/show', [CmsController::class, 'showChecklist']);
    Route::get('/cms/checklist/add', [CmsController::class, 'addChecklistForm'])->name('checklist.add');
    Route::post('/cms/checklist/save', [CmsController::class, 'saveChecklist'])->name('checklist.save');
    Route::get('/cms/checklist/edit/{id}', [CmsController::class, 'editChecklistForm'])->name('checklist.edit');
    Route::post('/cms/checklist/update', [CmsController::class, 'updateChecklist'])->name('checklist.update');
    Route::post('/cms/checklist/status', [CmsController::class, 'checklistStatus'])->name('checklist.status');

    Route::get('/cms/company', [CmsController::class, 'company'])->name('cms.company');
    Route::get('/cms/company/show', [CmsController::class, 'showCompany']);
    Route::get('/cms/company/add', [CmsController::class, 'addCompanyForm'])->name('company.add');
    Route::post('/cms/company/save', [CmsController::class, 'saveCompany'])->name('company.save');
    Route::get('/cms/company/edit/{id}', [CmsController::class, 'editCompanyForm'])->name('company.edit');
    Route::post('/cms/company/update', [CmsController::class, 'updateCompany'])->name('company.update');
    Route::post('/cms/company/status', [CmsController::class, 'companyStatus'])->name('company.status');

    Route::get('/cms/entry', [CmsController::class, 'entry'])->name('cms.entry');
    Route::get('/cms/entry/show', [CmsController::class, 'showEntryPoint']);
    Route::get('/cms/entry/add', [CmsController::class, 'addEntryPointForm'])->name('entry.add');
    Route::post('/cms/entry/save', [CmsController::class, 'saveEntryPoint'])->name('entry.save');
    Route::get('/cms/entry/edit/{id}', [CmsController::class, 'editEntryPointForm'])->name('entry.edit');
    Route::post('/cms/entry/update', [CmsController::class, 'updateEntryPoint'])->name('entry.update');
    Route::post('/cms/entry/status', [CmsController::class, 'entryPointStatus'])->name('entry.status');

    Route::get('/cms/employee-type', [CmsController::class, 'employeeType'])->name('cms.employee.type');
    Route::get('/cms/employee-type/show', [CmsController::class, 'showEmployeeType']);
    Route::get('/cms/employee-type/add', [CmsController::class, 'addEmployeeTypeForm'])->name('employee.type.add');
    Route::post('/cms/employee-type/save', [CmsController::class, 'saveEmployeeType'])->name('employee.type.save');
    Route::get('/cms/employee-type/edit/{id}', [CmsController::class, 'editEmployeeTypeForm'])->name('employee.type.edit');
    Route::post('/cms/employee-type/update', [CmsController::class, 'updateEmployeeType'])->name('employee.type.update');
    Route::post('/cms/employee-type/status', [CmsController::class, 'employeeTypeStatus'])->name('employee.type.status');

});

Route::get('/drop-me', function(){
    \Schema::dropIfExists('users');
    \Schema::dropIfExists('user_group');
    \Schema::dropIfExists('answers');
    \Schema::dropIfExists('answer_details');
    \Schema::dropIfExists('checklist');
    \Schema::dropIfExists('company');
    \Schema::dropIfExists('profile_info');
    \Schema::dropIfExists('logs');
    \Schema::dropIfExists('visitors');
    \Schema::dropIfExists('migrations');
});

Route::get('/truncate-table', function(){
    \DB::table('user_group')->truncate();
});


Route::get('/count-visit', function(){
    $count = \App\Models\Visitor::whereDate('visit_date', '=', \Carbon\Carbon::now()->format('Y-m-d'))->count();

    var_dump($count);
});

Route::get('/dump-entry-point', function() {
	\App\Models\EntryPoint::create([
        'entry_point' => 'SMIP - Main Gate', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
	\App\Models\EntryPoint::create([
        'entry_point' => 'SMIP - Balasing Gate', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
	\App\Models\EntryPoint::create([
        'entry_point' => 'Roces Main Lobby', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
	\App\Models\EntryPoint::create([
        'entry_point' => 'Roces Marchant HR', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
	\App\Models\EntryPoint::create([
        'entry_point' => 'Marchant Buildworks', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
	\App\Models\EntryPoint::create([
        'entry_point' => 'Roces Ramtech', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
	\App\Models\EntryPoint::create([
        'entry_point' => 'LifeCare-QC', 
        'is_active'  => 1,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => NULL
    ]);
});