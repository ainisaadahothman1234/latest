<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HOSController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\RemoveController;
use App\Http\Controllers\ChartJSController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckboxController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MonthlyReportController;

Route::post('password/new', [PasswordController::class, 'changePassword']);
Route::get('password/new', [PasswordController::class, 'index']);
Route::get('/', [AuthController::class, 'logout'])->name('logout');//for refresh session for new tab
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
Route::get('/reports', [MonthlyReportController::class,'index']);
Route::post('/generate-report', [MonthlyReportController::class,'generateReport'])->name('generateReport');


Route::middleware(['auth'])->group(function () {
    Route::get('/history', [HistoryController::class, 'show']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/staff/deactivate', [RemoveController::class, 'users']);
    Route::post('/staff/deactivate', [RemoveController::class, 'deactivate']);
    Route::get('/staff/activate', [RemoveController::class, 'users']);
    Route::post('/staff/activate', [RemoveController::class, 'activate']);
});

Route::middleware(['auth', 'role:ITadmin'])->group(function () {
    Route::get('/ITadmin/home', [AdminController::class, 'listStaff'])->name('ITadmin.home');
    Route::get('/ITadmin', [AdminController::class, 'listStaff'])->name('ITadmin.home');
});

Route::get('/register', [AuthController::class, 'viewRegister'])->name('register');
Route::post('register', [AuthController::class, 'registerPost']);

Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');
    Route::post('/assign', [HOSController::class, 'assignStaff']);
    Route::get('admin/apply/{trainingCode}', [StaffController::class, 'apply']);
    Route::get('/training/add', [AdminController::class, 'viewForm']);
    Route::post('/training/add', [AdminController::class, 'store']);
    Route::get('/training/req', [AdminController::class, 'training']);
    Route::get('/training/lists', [AdminController::class, 'show']);
    Route::get('/staff/lists', [AdminController::class, 'listStaff']);
    Route::get('/training/update', [AdminController::class, 'update']);
    Route::get('/training/delete', [AdminController::class, 'delete']);
    Route::get('/attendance/{Tcode}', [AdminController::class, 'attendanceStaff']);
    Route::post('/attendance/{Tcode}', [AdminController::class, 'updateAttend']);
    Route::get('/training/{code}', [AdminController::class, 'showForm']);
    Route::get('/print/{Tcode}', [AdminController::class, 'print']);
    Route::get('chart', [ChartJSController::class, 'index']);
    Route::get('tableChart', [AdminController::class, 'displayTableChart']); //table detail route
    Route::get('/training/approve/{Tcode}', [AdminController::class, 'trainingApprove']);
    Route::get('/training/reject/{Tcode}', [AdminController::class, 'trainingReject']);
    Route::post('/attendance/attend/{staff_id}', [AdminController::class, 'attend']);
    Route::post('/attendance/absent/{staff_id}', [AdminController::class, 'absent']);
    Route::get('/admin/getCardData', [AdminController::class, 'getCardData'])->name('admin.getCardData');
    Route::get('/admin/getChartData', [AdminController::class, 'getChartData'])->name('admin.getChartData');

});


Route::middleware(['auth', 'role:hos'])->group(function () {

    Route::get('/hos/home', [HOSController::class, 'index'])->name('hos.home');
    Route::get('hos/training/list', [FilterController::class, 'sideFilter'])->name('sideFilter');
    Route::get('/assign', [FilterController::class, 'sideFilter'])->name('filter');
    Route::get('/assign/{code}', [FilterController::class, 'fetch']);
    Route::post('assign', [HOSController::class, 'assignStaff']);
    Route::post('hos/assign/{trainingCode}', [StaffController::class, 'apply']);
    Route::get('hos/apply/{trainingCode}', [StaffController::class, 'apply']);
    Route::get('/lists', [FilterController::class, 'listByService']);// show list of staff under their own services
    Route::get('form', [HOSController::class, 'showForm']);
    Route::post('external', [HOSController::class, 'store']);
    Route::get('external/form', [FilterController::class, 'fetch']);
    Route::post('external/assign/{trainingCode}', [HOSController::class, 'external']);
    Route::get('/checkbox', [CheckboxController::class, 'index']);
    Route::get('/training/details', [CheckboxController::class, 'index']);
    Route::get('/notification/details', [NotificationController::class, 'sendNotification']);
    Route::get('/notification/application', [NotificationController::class, 'applications']);
    Route::post('/notification/approve', [NotificationController::class, 'approveApplication'])->name('notification.approve');
    Route::post('/notification/delete', [NotificationController::class, 'deleteApplication'])->name('notification.delete');
    Route::get('hos/training/{code}', [AdminController::class, 'showForm']);
    Route::get('/staff/{staff_id}/staff_training', [StaffController::class,'showCompletedTraining'])->name('hos.staff_training');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    
    Route::get('staff/home', [StaffController::class, 'index'])->name('staff.home');
    Route::get('/home', [FilterController::class, 'sideFilter'])->name('filter');
    Route::get('staff/training/list', [FilterController::class, 'sideFilter'])->name('sideFilter');
    Route::get('staff/apply/{trainingCode}', [StaffController::class, 'apply']);
    Route::post('/apply/{trainingCode}/sendEmail', [StaffController::class, 'sendEmailToHOS'])->name('apply.sendEmail');
    Route::get('staff/{page}/{trainingID}', [StaffController::class, 'courseDetail']);
});
