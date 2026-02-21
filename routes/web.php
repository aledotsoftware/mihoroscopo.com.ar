<?php




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\TermsController;

use App\Http\Controllers\EmailTrackingController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
// use App\Http\Controllers\LandingController;

use App\Http\Controllers\SubscriptionController;



// Ruta para la landing page
Route::get('/landing', [LandingController::class, 'show'])->name('landing');



// Route::post('/create-plan', [SubscriptionController::class, 'createPlan']);
Route::post('/create-subscription', [SubscriptionController::class, 'createSubscription']);



Route::get('/subscribe', function () {
    return view('subscribe');
});



// Route::get('/subscription/unsubscribe/{id}', [SubscriptionController::class, 'unsubscribe'])->name('subscription.unsubscribe');
Route::get('/subscription/preferences/{id}', [SubscriptionController::class, 'preferences'])->name('subscription.preferences');

Route::get('/subscription/unsubscribe/{id}', [SubscriptionController::class, 'processUnsubscribe'])->name('subscription.processUnsubscribe');
// Route::post('/subscription/preferences/{id}', [SubscriptionController::class, 'processPreferences'])->name('subscription.processPreferences');
Route::get('/subscription/reactivate/{id}', [SubscriptionController::class, 'reactivate'])->name('subscription.reactivate');
Route::get('/subscription/update/{id}', [SubscriptionController::class, 'update'])->name('subscription.update');
Route::get('/subscription/reactivatesubscription/{id}/{paymentType}', [SubscriptionController::class, 'reactivateSubscription'])->name('subscription.reactivateSubscription');



// Ruta para la página principal
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
// Route::get('/blog/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/blog/{slug}', [ArticleController::class, 'show'])->name('articles.show');


// web.php
Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');























// Ruta para mostrar el formulario de login
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
// Ruta para procesa el login
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.process');
// Ruta para el panel de administración
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// Ruta para el logout
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
// Ruta para mostrar el formulario de edición de un artículo existente
Route::get('/admin/articles/{article}/edit', [ArticleController::class, 'edit'])->name('admin.articles.edit');
// Ruta para mostrar la lista de artículos
Route::get('/admin/articles', [ArticleController::class,  'adminIndex'])->name('admin.articles.index');
// Ruta para mostrar el formulario de creación de un nuevo artículo
Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('admin.articles.create');
// Ruta para procesar la creación de un nuevo artículo
Route::post('/admin/articles', [ArticleController::class, 'store'])->name('admin.articles.store');
// Ruta para actualizar un artículo existente
Route::put('/admin/articles/{article}', [ArticleController::class, 'update'])->name('admin.articles.update');
// Ruta para eliminar un artículo
Route::delete('/admin/articles/{article}', [ArticleController::class, 'destroy'])->name('admin.articles.destroy');








Route::get('/logo', [EmailTrackingController::class, 'trackOpen'])->name('logo');


