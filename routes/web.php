<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HeadlineController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

$UrlPrefix = 'admin';

Route::get('/', function () {
    return view('welcome');
});


Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->prefix($UrlPrefix)->as('admin.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('file/serve/{file_path}', [HomeController::class, 'fileServe'])->where('file_path', '(.*)')->name('file.serve');
    Route::post('/get-additional-permission', [PermissionController::class, 'getRolePermission'])->name('getRolePermission');

    Route::resources([
        'users' => UsersController::class,
        'roles' => RoleController::class,
        'permissions' => PermissionController::class ,
        'headlines' => HeadlineController::class ,
        'categories' => CategoryController::class ,
        'comments' => CommentController::class ,
        'advertisements' => AdvertisementController::class ,
    ]);
});

require __DIR__.'/auth.php';
