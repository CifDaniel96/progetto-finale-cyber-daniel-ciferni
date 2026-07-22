<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WriterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RevisorController;

// Public routes
Route::get('/', [PublicController::class, 'homepage'])->name('homepage');
Route::get('/careers', [PublicController::class, 'careers'])->name('careers');
Route::post('/careers/submit', [PublicController::class, 'careersSubmit'])->name('careers.submit');

Route::get('/articles/index', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/show/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/articles/category/{category}', [ArticleController::class, 'byCategory'])->name('articles.byCategory');
Route::get('/articles/user/{user}', [ArticleController::class, 'byUser'])->name('articles.byUser');
Route::get('/articles/search', [ArticleController::class, 'articleSearch'])->middleware('throttle:article-search')->name('articles.search');

// Writer routes
Route::middleware('writer')->group(function(){
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles/store', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/writer/dashboard', [WriterController::class, 'dashboard'])->name('writer.dashboard');
    Route::get('/articles/edit/{article}', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/update/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/destroy/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// Revisor routes
Route::middleware('revisor')->group(function(){
    Route::get('/revisor/dashboard', [RevisorController::class, 'dashboard'])->name('revisor.dashboard');
    Route::post('/revisor/{article}/accept', [RevisorController::class, 'acceptArticle'])->name('revisor.acceptArticle');
    Route::post('/revisor/{article}/reject', [RevisorController::class, 'rejectArticle'])->name('revisor.rejectArticle');
    Route::post('/revisor/{article}/undo', [RevisorController::class, 'undoArticle'])->name('revisor.undoArticle');
});

// Admin routes
Route::middleware(['admin','admin.local'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/{user}/set-admin', [AdminController::class, 'setAdmin'])->name('admin.setAdmin');
    Route::get('/admin/{user}/set-revisor', [AdminController::class, 'setRevisor'])->name('admin.setRevisor');
    Route::get('/admin/{user}/set-writer', [AdminController::class, 'setWriter'])->name('admin.setWriter');
    
    Route::put('/admin/edit/tag/{tag}', [AdminController::class, 'editTag'])->name('admin.editTag');
    Route::delete('/admin/delete/tag/{tag}', [AdminController::class, 'deleteTag'])->name('admin.deleteTag');
    Route::put('/admin/edit/category/{category}', [AdminController::class, 'editCategory'])->name('admin.editCategory');
    Route::delete('/admin/delete/category/{category}', [AdminController::class, 'deleteCategory'])->name('admin.deleteCategory');
    Route::post('/admin/category/store', [AdminController::class, 'storeCategory'])->name('admin.storeCategory');
    Route::post('/admin/tag/store', [AdminController::class, 'storeTag'])->name('admin.storeTag');
});