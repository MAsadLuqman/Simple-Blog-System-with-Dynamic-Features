<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');
Route::get('/login_match', [UserController::class, 'login_match'])->name('login_match');
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('/register/save', [UserController::class, 'register_save'])->name('register_save');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/sendmail/{id}', [UserController::class, 'verifyUser'])->name('sendmail');
Route::view('/verify', 'verify')->name('verification.notice');
Route::get('password/reset', [UserController::class, 'passwordReset'])->name('password.reset');
Route::post('password/email', [UserController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{id}/{time}', [UserController::class, 'verifyResetLink'])->name('update.password');
Route::post('password/reset/{id}', [UserController::class, 'updatePassword'])->name('update_password');

Route::group(['middleware' => ['auth','verified']], function () {
    Route::view('/Welcome_users','welcomeuser')->name('Welcome_users');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [UserController::class, 'count'])->name('dashboard');
    //permissions Routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    //    tags Routes
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index')->middleware('permission:view-tag');
    Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create')->middleware('permission:create-tag');
    Route::post('/tags/store', [TagController::class, 'store'])->name('tags.store')->middleware('permission:create-tag');
    Route::get('/tags/edit/{id}', [TagController::class, 'edit'])->name('tags.edit')->middleware('permission:update-tag');
    Route::put('update_tag/{id}', [TagController::class, 'update'])->name('tags.update')->middleware('permission:update-tag');
    Route::delete('delete_tag/{id}', [TagController::class, 'destroy'])->name('tags.destroy')->middleware('permission:delete-tag');
//    user route
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:view-user');
    Route::get('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete-user');
    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('users.show')->middleware('permission:view-user');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update')->middleware('checkid');
    Route::get('/add-users', [UserController::class, 'add'])->name('users.add')->middleware('permission:create-user');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit')->middleware( 'checkid');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search')->middleware('permission:view-user');
    Route::get('user/pdf', [UserController::class, 'pdfgenerate'])->name('users.pdf');


//    post routes
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('permission:view-post');
    Route::get('/posts/show/{slug}', [PostController::class, 'show'])->name('posts.show')->middleware('permission:view-post');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('permission:create-post');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store')->middleware('permission:create-post');
    Route::get('/posts/edit/{id}', [PostController::class, 'edit'])->name('posts.edit')->middleware('permission:update-post');
    Route::get('delete_posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('permission:delete-post');
    Route::post('/posts/search', [PostController::class, 'search'])->name('posts.search')->middleware('permission:view-post');
    Route::put('update_posts/{id}', [PostController::class, 'update'])->name('posts.update')->middleware( 'permission:update-post');


    Route::post('/comments',[CommentController::class, 'store'])->name('comments.store');

    Route::get("/blogs",[BlogController::class, 'index'])->name('posts.index');



});

Route::get('/blogs/show/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get("/blogs",[BlogController::class, 'index'])->name('blogs.index');
Route::post('/blogs/search', [BlogController::class, 'search'])->name('blogs.search');
Route::get('/comments/{postID}',[CommentController::class, 'index'])->name('comments.index');




