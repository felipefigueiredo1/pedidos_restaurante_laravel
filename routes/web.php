<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoProdutoController;

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
Route::get('/', [PedidoProdutoController::class, 'index']);
Route::get('index', [PedidoProdutoController::class, 'index']);
Route::get('/index/{id}', [PedidoProdutoController::class, 'find']);
Route::post('index', [PedidoProdutoController::class, 'store'])->name('index');

Route::get('caixa', [PedidoProdutoController::class, 'show'])->name('caixa');


Auth::routes();
