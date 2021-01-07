<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\AttributController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomLdapController;
use App\Http\Controllers\TypeElementController;
use App\Http\Controllers\AttributValueTypeController;

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

Route::get('/', function () {
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
});

Route::get('/home', function () {
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
});

Auth::routes();

Route::prefix('ldap')->group(function(){
    Route::get('/test', [CustomLdapController::class,'test'])->name('ldaptest');
    Route::get('/sync', [CustomLdapController::class,'sync'])->name('ldapsync');
});

// Route pour test de Master/Details avec Vuejs et VueX
Route::get('persons', [PersonController::class,'index']);

Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/fetch', [ProductController::class, 'fetch'])->name('product.fetch');
Route::get('/product/{product_id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::get('/product/{product_id}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

Route::get('permissions',[RoleController::class, 'permissions'])->middleware('auth');
Route::resource('roles',RoleController::class)->middleware('auth');
Route::get('hasrole/{roleid}',[RoleController::class, 'hasrole'])->middleware('auth');
Route::resource('users',UserController::class)->middleware('auth');

//Route::get('/home', 'HomeController@index')->name('home');

Route::resource('settings',SettingController::class);

Route::get('dashboards',[DashboardController::class,'index'])
    ->name('dashboards.index')
    ->middleware('auth');
Route::get('dashboards/fetch',[DashboardController::class,'fetch'])
    ->name('dashboards.fetch')
    ->middleware('auth');
Route::get('dashboards/fetchagence/{id}',[DashboardController::class,'fetchagence'])
    ->name('dashboards.fetchagence')
    ->middleware('auth');

Route::resource('users',UserController::class)->middleware('auth');
Route::get('users.fetch',[UserController::class,'fetch'])
    ->name('users.fetch')
    ->middleware('auth');

Route::resource('typeelements',TypeElementController::class)->middleware('auth');
Route::get('typeelements.fetch',[TypeElementController::class,'fetch'])
    ->name('typeelements.fetch')
    ->middleware('auth');

Route::resource('attributs',AttributController::class)->middleware('auth');
Route::get('attributs.fetch',[AttributController::class,'fetch'])
    ->name('attributs.fetch')
    ->middleware('auth');

Route::get('/attributvaluetypes/fetchcomposedsingle/{id}', [AttributValueTypeController::class, 'fetchcomposedsingle'])
    ->name('attributvaluetypes.fetchcomposedsingle');
Route::get('/attributvaluetypes/fetchcomposedall/', [AttributValueTypeController::class, 'fetchcomposedall'])
    ->name('attributvaluetypes.fetchcomposedall');
Route::resource('attributvaluetypes',AttributValueTypeController::class)->middleware('auth');
Route::get('attributvaluetypes.fetch',[AttributValueTypeController::class,'fetch'])
    ->name('attributvaluetypes.fetch')
    ->middleware('auth');

Route::resource('elements',ElementController::class)->middleware('auth');
Route::get('elements.fetch',[ElementController::class,'fetch'])
    ->name('elements.fetch')
    ->middleware('auth');
