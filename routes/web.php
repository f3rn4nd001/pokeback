<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\catalogo\usuario;
use App\Http\Controllers\Login\loginController;
use App\Http\Controllers\catalogo\menuSubmenuControPermisos;

use App\Http\Controllers\sistemas\permisosController;

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
/*
Logins -------------------
*/
Route::post('Login', [loginController::class,'posLogin']);
Route::post('getMenu', [menuSubmenuControPermisos::class,'getMenu']);
Route::post('Registro', [loginController::class,'posRegistro']);



Route::post('p1file', [menuSubmenuControPermisos::class,'p1file']);
Route::post('contras', [loginController::class,'poscontras']);





/*
usuarios -------------------
*/

Route::get('Catalogo/usuario/consulta', [usuario::class,'getRegistro']);
Route::post('Catalogo/usuario/registro', [usuario::class,'postRegistro']);
Route::post('Catalogo/usuario/detalles', [usuario::class,'getDetalles']);
Route::post('Catalogo/usuario/getRFC', [usuario::class,'getRFC']);
Route::post('Catalogo/usuario/delete', [usuario::class,'postEliminar']);




Auth::routes();
