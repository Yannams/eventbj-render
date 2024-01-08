<?php

use App\Http\Controllers\ChronogrammeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypeLieuController;
use App\Http\Controllers\TypeTicketController;

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

Route::get('/', [EvenementController::class,'index']);
Route::get('/home',[EvenementController::class,'index']);
Route::get('/profil',[ProfileController::class,'afficherFormulaire'])->name('profil');
Route::get('/evenement/type_lieu',[TypeLieuController::class,'select_type_lieu'])->name('select_type_lieu');
Route::get('/mes_evenements', [EvenementController::class,'MyEvents'])->name('MesEvenements');
Route::post('/onLine/{evenement}', [EvenementController::class,'OnlineEvents'])->name('OnlineEvents');
Route::get('/filtredevenement/{type}', [EvenementController::class, 'filteredByTypeEvents'] )->name('type_event');
Route::post('/isEntreprise',[ProfileController::class,'updateIsEntreprise'])->name('isEntreprise'); 
Route::get('/verifiedTransaction/{type_ticket}', [TicketController::class,'verifiedTransaction'] )->name('verifiedTransation');
Route::get('/Create_event',[EvenementController::class,'Create_event'])->name('Create_event');
Route::get('/Editor/chronogramme/{evenement}', [ChronogrammeController::class,'edit_chronogramme'])->name('edit_chronogramme');
Route::post('/evenement/edit/heure/{evenement}', [EvenementController::class,'updateHours'])->name('updateHours');
Route::post('/typelieuSelected', [TypeLieuController::class,'type_lieu_selected'])->name('typelieuSelected');
Route::get('/Form_end',[TypeTicketController::class,'terminus'])->name('terminus');

Route::resource('evenement', EvenementController::class);
Route::resource('type_lieu', TypeLieuController::class);
Route::resource('chronogramme',ChronogrammeController::class);
Route::resource('type ticket', TypeTicketController::class);
Route::resource('ticket', TicketController::class);