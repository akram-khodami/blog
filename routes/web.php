<?php

use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;

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
Route::get('/', [HomeController::class, 'index']);
Route::prefix('blog')->group(function () {

    Route::get('posts', [BlogController::class, 'index']);
    Route::get('posts/{id}', [BlogController::class, 'post']);
    Route::post('comment', [BlogController::class, 'storeComment']);
    Route::get('category_posts/{category}', [BlogController::class, 'category_posts']);

});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tags', TagController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('posts/post_comments', [PostController::class, 'get_post_comments']);

    Route::resource('posts', PostController::class);
    Route::resource('comments', CommentController::class);
    Route::post('comment/confirmComment/{id}', [CommentController::class, 'confirmComment']);

    Route::resource('users', UserController::class);
    Route::post('addUserRole', [UserController::class, 'addUserRole']);
    Route::delete('deleteUserRole', [UserController::class, 'deleteUserRole']);
    Route::post('activeUser', [UserController::class, 'activeUser']);
    Route::post('inActiveUser', [UserController::class, 'inActiveUser']);


    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::post('roles/addPermission', [RoleController::class, 'addPermission']);

    Route::delete('destroy/posts', [PostController::class, 'destroyAll']);

});
require __DIR__ . '/auth.php';
