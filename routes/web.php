<?php

use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CorretorController;
use App\Http\Controllers\ImovelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeocodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitaController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//ROTAS CORRETORES
Route::get('/corretor', [CorretorController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('corretor');

Route::get('/corretor/create', [CorretorController::class, 'create'])->name('corretor.create');
Route::post('/corretor/store', [CorretorController::class, 'store'])->name('corretor.store');
Route::put('/corretor/update/{id}', [CorretorController::class, 'update'])->name('corretor.update');
Route::delete('/corretor/destroy/{corretor}', [CorretorController::class, 'destroy'])->name('corretor.destroy');

//ROTAS CLIENTES
Route::get('/cliente', [ClienteController::class, 'index'])
->middleware(['auth', 'verified'])
->name('cliente');

Route::get('/cliente/create', [ClienteController::class, 'create'])->name('cliente.create');
Route::post('/cliente/store', [ClienteController::class, 'store'])->name('cliente.store');
Route::put('/cliente/update/{id}', [ClienteController::class, 'update'])->name('cliente.update');
Route::delete('/cliente/destroy/{cliente}', [ClienteController::class, 'destroy'])->name('cliente.destroy');

//ROTAS IMOVEIS
Route::get('/imovel', [ImovelController::class, 'index'])
->middleware(['auth', 'verified'])
->name('imovel');

Route::get('/imovel/create', [ImovelController::class, 'create'])->name('imovel.create');
Route::post('/imovel/store', [ImovelController::class, 'store'])->name('imovel.store');
Route::put('/imovel/update/{id}', [ImovelController::class, 'update'])->name('imovel.update');
Route::delete('/imovel/destroy/{imovel}', [ImovelController::class, 'destroy'])->name('imovel.destroy');

//ROTAS VISITAS
Route::get('/visita', [VisitaController::class, 'index'])
->middleware(['auth', 'verified'])
->name('visita');

Route::get('/visita/create', [VisitaController::class, 'create'])->name('visita.create');
Route::post('/visita/store', [VisitaController::class, 'store'])->name('visita.store');
Route::put('/visita/update/{id}', [VisitaController::class, 'update'])->name('visita.update');
Route::delete('/visita/destroy/{visita}', [VisitaController::class, 'destroy'])->name('visita.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
});

Route::post('/geocode', [GeocodeController::class, 'geocode']);

Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');

Route::get('/calendario/events', [CalendarioController::class, 'getEvents'])->name('calendario.events');

//ROTA USER
Route::get('/users', [UserController::class, 'index'])
->middleware(['auth', 'verified'])
->name('users');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/destroy/{visita}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/arquivos', [ArquivoController::class, 'index'])
->middleware(['auth', 'verified'])
->name('arquivos');

Route::get('/arquivos/create', [ArquivoController::class, 'create'])->name('arquivos.create');
Route::post('/arquivos/store', [ArquivoController::class, 'store'])->name('arquivos.store');
Route::put('/arquivos/update/{id}', [ArquivoController::class, 'update'])->name('arquivos.update');
Route::delete('/arquivos/destroy/{arquivo}', [ArquivoController::class, 'destroy'])->name('arquivos.destroy');



Route::get('/exibir-foto/{fotoId}', [ImovelController::class, 'exibirFoto'])->name('exibir-foto');
Route::post('/excluir-foto/{fotoId}', [ImovelController::class, 'excluirFoto'])->name('excluir-foto');





require __DIR__.'/auth.php';
