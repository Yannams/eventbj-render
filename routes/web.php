<?php

use App\Http\Controllers\ChronogrammeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilPromoteurController;
use App\Http\Controllers\RBACRedirectionController;
use App\Http\Controllers\TypeLieuController;
use App\Http\Controllers\TypeTicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IntervenantController;
use App\Http\Controllers\UsersoftdeleteController;
use App\Http\Controllers\CentreInteretController;
use App\Http\Controllers\ChronogrammeController as ControllersChronogrammeController;

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
Route::get('/mes_evenements', [EvenementController::class,'MyEvents'])->name('MesEvenements')->middleware('auth','role:User|Promoteur');
Route::post('/onLine', [EvenementController::class,'OnlineEvents'])->name('OnlineEvents')->middleware('auth','role:Promoteur');
Route::get('/filtredevenement/{type}', [EvenementController::class, 'filteredByTypeEvents'] )->name('type_event'); 
Route::get('/verifiedTransaction/{type_ticket}', [TicketController::class,'verifiedTransaction'] )->name('verifiedTransation');
Route::get('/Create_event',[EvenementController::class,'Create_event'])->name('Create_event')->middleware('auth','role:User|Promoteur');
Route::get('/Editor/chronogramme/{evenement}', [ChronogrammeController::class,'edit_chronogramme'])->name('edit_chronogramme')->middleware('auth','role:Promoteur');
//Route::post('/evenement/edit/heure/{evenement}', [EvenementController::class,'updateHours'])->name('updateHours');
Route::post('/type_lieu_selected', [TypeLieuController::class,'type_lieu_selected'])->name('typelieuSelected')->middleware('auth','role:Promoteur');
Route::get('/Form_end',[TypeTicketController::class,'terminus'])->name('terminus')->middleware('auth','role:Promoteur');
Route::post('/ticket_selected',[TicketController::class, 'TicketSelected'])->name('ticket_selected')->middleware('auth');
Route::post('/NombreTicket',[TicketController::class, 'nombreTicket'])->name('nombreTicket');
Route::post('/like/event',[EvenementController::class,'like_event'])->name('like_event')->middleware('auth');
Route::post('/query',[EvenementController::class,'research_event'])->name('research_event');
Route::get('/gererEvent/{evenement}',[EvenementController::class,'gererEvent'])->name('gererEvent')->middleware('auth','role:Promoteur|Admin');
Route::post('/getChartsData',[EvenementController::class,'getChartsData'])->name('getChartsData')->middleware('auth','role:Promoteur|Admin');
Route::get('/billetterie',[TypeTicketController::class,'billetterie'])->name('billetterie')->middleware('auth','role:Promoteur');
Route::get('/ModifierHoraire',[EvenementController::class,'ModifierHoraire'])->name('ModifierHoraire')->middleware('auth','role:Promoteur');
Route::post('/UpdaterHoraire',[EvenementController::class,'UpdateHoraire'])->name('UpdateHoraire')->middleware('auth','role:Promoteur');
Route::get('/scanTicket',[TicketController::class,'scanTicket'])->name('scanTicket')->middleware('auth','role:Promoteur');
Route::get('/afficherProfil',[ProfileController::class,'afficherProfil'])->name('afficherProfil');
Route::post('/verifierTicket', [TicketController::class,'verifierTicket'])->name('verifierTicket')->middleware('auth','role:Promoteur');
Route::get('/validTicket',[TicketController::class,'validTicket'])->name('validTicket')->middleware('auth','role:Promoteur');
Route::get('/verifiedTicket',[TicketController::class,'verifiedTicket'])->name('verifiedTicket')->middleware('auth','role:Promoteur');
Route::get('/invalidTicket',[TicketController::class,'invalidTicket'])->name('invalidTicket')->middleware('auth','role:Promoteur');
Route::get('/eventToVerify',[TicketController::class,'eventToVerify'])->name('eventToVerify')->middleware('auth','role:Promoteur');
Route::post('/eventSending',[TicketController::class,'eventSending'])->name('eventSending')->middleware('auth','role:Promoteur');
Route::get('/redirection',[RBACRedirectionController::class,'redirection'])->name('redirection');
Route::get('/PromoteurShow/{evenement}',[EvenementController::class,'PromoteurShow'])->name('PromoteurShow')->middleware('auth','role:Promoteur');
Route::post('/deleteUser',[UsersoftdeleteController::class,'softDelete'])->name('softDelete');
Route::get('/ConfirmUserBeforeDelete/{user}',[UsersoftdeleteController::class,'ConfirmUserBeforeDelete'])->name('ConfirmUserBeforeDelete');
Route::post('/GiveUpEventProcess',[EvenementController::class,'GiveUpEventProcess'])->name('GiveUpEventProcess');
Route::get('/lastEventRedirection/{evenement}', [EvenementController::class,'lastEventRedirection'])->name('lastEventRedirection')->middleware(['auth','role:Promoteur']);
Route::get('/UnauthorizedUser',[EvenementController::class,'UnauthorizedUser'])->name('UnauthorizedUser');
Route::get('/filteredByInterests/{interest}',[EvenementController::class,'filteredByInterests'])->name('filteredByInterest')->middleware(['auth','role:User|Promoteur']);
Route::get('evenement/autres',[EvenementController::class,'autres'])->name('autres')->middleware(['auth','role:User|Promoteur']);
Route::get('evenement/localisation/create',[EvenementController::class,'localisation'])->name('localisation')->middleware('auth');
Route::post('evenement/localisation/store',[EvenementController::class,'localisationStore'])->name('localisationStore')->middleware('auth','role:Promoteur');
Route::get('download/ticket/{ticket}',[TicketController::class,'downloadTicket'])->name('downloadTicket')->middleware('auth');
Route::get('/EditEvent/{evenement}',[EvenementController::class,'EditEvent'])->name('EditEvent')->middleware(['auth','role:Promoteur']);
Route::get('/AddTicket/{evenement}',[TypeTicketController::class,'AddTicket'])->name('AddTicket')->middleware(['auth','role:Promoteur']);
Route::get('/localisationEdit/{evenement}',[EvenementController::class,'localisationEdit'])->name('localisationEdit')->middleware(['auth','role:Promoteur']);
Route::get('/eventRedirecting/{type_ticket}/{token}',[EvenementController::class,'eventRedirecting'])->name('eventRedirecting')->middleware(['auth']);
Route::get('/evenement/{evenement}/typeTicket',[TypeTicketController::class,'AllTickets'])->name('AllTickets')->middleware(['auth','role:Promoteur']);
Route::get('/StartWithoutTicket/{evenement}',[TypeTicketController::class,'StartWithoutTicket'])->name('StartWithoutTicket');
Route::post('/ticket/getAmount',[TicketController::class,'GetAmount'])->name('GetAmount');
Route::get('/ticket/UserInfo',[TicketController::class,'UserInfo'])->name('UserInfo');
Route::post('/ticket/getUserInfo',[TicketController::class,'GetUserInfo'])->name('GetUserInfo');

Route::resource('evenement', EvenementController::class,['middleware'=>['auth','role:Promoteur'],'except'=>['index','show','create']]);
Route::resource('evenement', EvenementController::class,['except'=>['update','store','edit','create','destroy'],'middleware'=>['auth','role:User|Promoteur']]);
//Route::resource('type_lieu', TypeLieuController::class);
Route::resource('chronogramme',ChronogrammeController::class)->middleware(['auth','role:Promoteur']);
Route::resource('type_ticket', TypeTicketController::class)->middleware(['auth','role:Promoteur']);
Route::resource('ticket', TicketController::class)->middleware('auth');
Route::resource('Promoteur',ProfilPromoteurController::class);
Route::resource('Intervenant',IntervenantController::class)->middleware(['auth','role:Promoteur']);
Route::resource('Centre_interet',CentreInteretController::class)->middleware(['auth']);


Route::get('/AllEvents',[AdminController::class,'AllEvents'])->name('AllEvents')->middleware('auth','role:Admin');
Route::post('/Administrative_activation',[AdminController::class,'Administrative_activation'])->name('Administrative_action')->middleware('auth','role:Admin');
Route::get('/Same_organiser/{organiser}',[AdminController::class,'Same_organiser'])->name('Same_organiser')->middleware('auth','role:Admin');
Route::get('/filter_event/{filter}/{filter_character}',[AdminController::class,'filtered_event'])->name('filter_event')->middleware('auth','role:Admin');
Route::post('/Recommand_Event',[AdminController::class,'Recommand_Event'])->name('Recommand_Event')->middleware('auth','role:Admin');
Route::get('/users',[AdminController::class,'users'])->name('users')->middleware('auth','role:Admin');
Route::get('/UserActivity/{user}',[AdminController::class,'UserActivity'])->name('UserActivity')->middleware('auth','role:Admin');
Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard')->middleware('auth','role:Admin');
Route::get('/AdminShowEvent/{evenement}',[AdminController::class,'AdminShowEvent'])->name('AdminShowEvent');
Route::post('/getChartsDataAdmin',[AdminController::class,'getChartsDataAdmin'])->name('getChartsDataAdmin');

