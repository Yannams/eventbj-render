<?php

use App\Http\Controllers\ChronogrammeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoteurController;
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

Route::get('/', [EvenementController::class,'index'])->name('index');
Route::get('/home',[EvenementController::class,'index'])->name('home');
Route::get('/evenement/type_lieu',[TypeLieuController::class,'select_type_lieu'])->name('select_type_lieu')->middleware('auth','role:Promoteur');
Route::get('/mes_evenements', [EvenementController::class,'MyEvents'])->name('MesEvenements')->middleware('auth');
Route::post('/onLine', [EvenementController::class,'OnlineEvents'])->name('OnlineEvents')->middleware('auth','role:Promoteur');
Route::get('/filtredevenement/{type}', [EvenementController::class, 'filteredByTypeEvents'] )->name('type_event'); 
Route::get('/verifiedTransaction/{type_ticket}', [TicketController::class,'verifiedTransaction'] )->name('verifiedTransation');
Route::get('/Create_event',[EvenementController::class,'Create_event'])->name('Create_event')->middleware('auth');
Route::get('/Editor/chronogramme/{evenement}', [ChronogrammeController::class,'edit_chronogramme'])->name('edit_chronogramme')->middleware('auth','role:Promoteur');
//Route::post('/evenement/edit/heure/{evenement}', [EvenementController::class,'updateHours'])->name('updateHours');
Route::post('/type_lieu_selected', [TypeLieuController::class,'type_lieu_selected'])->name('typelieuSelected')->middleware('auth','role:Promoteur');
Route::get('/Form_end',[TypeTicketController::class,'terminus'])->name('terminus')->middleware('auth','role:Promoteur');
Route::post('/ticket_selected',[TicketController::class, 'TicketSelected'])->name('ticket_selected')->middleware('auth');
Route::post('/NombreTicket',[TicketController::class, 'nombreTicket'])->name('nombreTicket');
Route::post('/like/event',[EvenementController::class,'like_event'])->name('like_event')->middleware('auth');
Route::post('/query',[EvenementController::class,'research_event'])->name('research_event');
Route::get('/gererEvent/{evenement}',[EvenementController::class,'gererEvent'])->name('gererEvent')->middleware('auth','role:Promoteur');
Route::post('/getChartsData',[EvenementController::class,'getChartsData'])->name('getChartsData')->middleware('auth','role:Promoteur');
Route::get('/billetterie',[TypeTicketController::class,'billetterie'])->name('billetterie');
Route::get('/ModifierHoraire',[EvenementController::class,'ModifierHoraire'])->name('ModifierHoraire');
Route::post('/UpdaterHoraire',[EvenementController::class,'UpdateHoraire'])->name('UpdateHoraire');
Route::get('/scanTicket',[TicketController::class,'scanTicket'])->name('scanTicket');


Route::resource('evenement', EvenementController::class,['middleware'=>['auth','role:Promoteur'],'except'=>['index','show','create']]);
Route::resource('evenement', EvenementController::class,['except'=>['update','store','edit','create','destroy']]);
//Route::resource('type_lieu', TypeLieuController::class);
Route::resource('chronogramme',ChronogrammeController::class)->middleware(['auth','role:Promoteur']);
Route::resource('type_ticket', TypeTicketController::class)->middleware(['auth','role:Promoteur']);
Route::resource('ticket', TicketController::class);
Route::resource('Promoteur',PromoteurController::class);