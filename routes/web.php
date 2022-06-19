<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashController;

Auth::routes();

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// DashBoard
Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard');

// Posts
Route::get('/myposts', [DashController::class, 'myPosts'])->name('myPosts');
Route::get('/createPost', [DashController::class, 'createPost'])->name('createPost');
Route::put('/createPost/submit', [DashController::class, 'createPostSubmit'])->name('createPost.submit');
Route::put('/deletePost/{postId}', [DashController::class, 'deletePost'])->name('deletePost');
Route::put('/editPost', [DashController::class, 'editPost'])->name('editPost');

// Users
Route::put('/deleteUser/{userId}', [DashController::class, 'deleteUser'])->name('deleteUser');
Route::get('/myProfile', [DashController::class, 'myProfile'])->name('myProfile');
Route::put('/editUser', [DashController::class, 'editUser'])->name('editUser');


// Routes
Route::get('/post/{slug}-{id}/', [PostController::class, 'post'])->name('post');
