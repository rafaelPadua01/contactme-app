<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisterUser;
use App\Http\Controllers\Auth\LoginRequest;
use App\Http\Controllers\Auth\LogoutRequest;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\ImageProfileController;
use App\Http\Controllers\Client\ProfileProfController;
use App\Http\Controllers\Client\SearchServicesController;
use App\Http\Controllers\Client\FollowerController;
use App\Http\Controllers\Client\GaleryController;
use App\Http\Controllers\Client\ImageGaleryController;
use App\Http\Controllers\Client\CloakController;
use App\Http\Controllers\Message\ChatsController;
use App\Http\Controllers\Message\MessagesController;
use App\Http\Controllers\Message\VoiceMessageController;
use App\Http\Controllers\AppointmentBook\AppointmentBookController;
use App\Http\Controllers\Service\ServicesController;
use App\Http\Controllers\Enterprise\Auth\RegisterEnterpriseController;
use LDAP\Result;

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
    return Inertia::render('Welcome', [
      //  'canLogin' => Route::has('login'),
      //  'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboardEnt', function () {
    return Inertia::render('./Enterprise/dashboardEnt');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

//Rotas de login logoff
Route::post('/login', [LoginRequest::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LogoutRequest::class, 'logout'])->name('logout')->middleware('auth');

//Rotas de usuario comum
Route::get('/user', function(){
   return \Auth::user();
})->middleware('auth');
Route::post('/create/{email}/{name}/{password}', [RegisterUser::class, 'insert'])->name('create');
Route::get('/user/getNotifications', [RegisterUser::class, 'getNotifications'])->name('getNotifications');
Route::post('/user/markasread/{id}', [RegisterUser::class, 'markasread'])->name('markasread');
Route::post('/user/markAll', [RegisterUser::class, 'markall'])->name('markall');
Route::post('/user/notification/remove/{id}', [RegisterUser::class, 'removeNotification'])->name('removeNotification');

//rota insert profile usuario comum
Route::get('/profile', [ProfileController::class, 'index'])->name('index')->middleware('auth');
Route::post('/createProfile/{id}', [ProfileController::class, 'save'])->name('create');


//Rotas do perfil profissional
Route::get('/professionalProfile', [ProfileProfController::class, 'index'])->name('index');
Route::post('/professionalProfile/{id}', [ProfileProfController::class, 'save'])->name('save');

//Rotas da imagem de perfil
Route::get('/profileImg', [ImageProfileController::class, 'index'])->name('index');
Route::post('/profileImg/upload/{id}', [ImageProfileController::class, 'upload'])->name('upload');
Route::post('/profileImg/update/{id}', [ImageProfileController::class, 'update'])->name('update');

//Route Cloak (capa profile)
Route::get('/cloak', [CloakController::class, 'index'])->name('index');
Route::get('/cloaks/{id}', [CloakController::class, 'allCloaks'])->name('allCloaks');
Route::post('/cloak/selected/{id}', [CloakController::class, 'selected'])->name('selected');
Route::post('/cloak/upload/{id}', [CloakController::class, 'upload'])->name('upload');
Route::post('/cloak/delete/{id}', [CloakController::class, 'delete'])->name('delete');

//Rotas Search service 
Route::post('/searchService/{id}', [SearchServicesController::class, 'search'])->name('search');
Route::get('/searchProfile/{id}', [SearchServicesController::class, 'userProfile'])->name('userProfile');

//Route to Services
Route::get('/service/usersMarked/{id}', [ServicesController::class, 'index'])->name('index');
Route::post('/service/create/{id}', [ServicesController::class, 'create'])->name('create');
Route::post('/service/marked/alterStatus/{id}', [ServicesController::class, 'alterStatus'])->name('alterStatus');
Route::post('/service/marked/dismatchStatus/{id}', [ServicesController::class, 'dismatchStatus'])->name('dismatchStatus');
Route::post('/service/marked/remove/{id}', [ServicesController::class, 'remove'])->name('remove');


//Rotas Follow
Route::get('/Follower', [FollowerController::class, 'index'])->name('index');
Route::post('/Follower/create/{id}', [FollowerController::class, 'follow'])->name('follow');
Route::post('/Follower/confirm/{id}', [FollowerController::class, 'followConfirm'])->name('followConfirm');
Route::post('/Follower/alterStatus/{id}', [FollowerController::class, 'alterStatus'])->name('alterStatus');
Route::post('/Follower/unconfirm/{id}', [FollowerController::class, 'unconfirm'])->name('unconfirm');
Route::get('/Follower/followers/{id}', [FollowerController::class, 'followers'])->name('followers');
Route::post('/Follower/unfollow/{id}', [FollowerController::class, 'unfollow'])->name('unfollow');

//Rotas Galery
Route::get('/galery/{id}',[GaleryController::class, 'index'])->name('index');
Route::post('/galery/create/{id}', [GaleryController::class, 'create'])->name('create');
Route::post('/galery/edit/{id}', [GaleryController::class, 'update'])->name('update');
Route::post('galery/delete/{id}', [GaleryController::class, 'delete'])->name('delete');

//Rotas Image Galery
Route::get('/imageGalery/selected/{id}', [ImageGaleryController::class, 'selected'])->name('selected');
Route::get('/imageGalery/selectedAll/{id}', [ImageGaleryController::class, 'selectedAll'])->name('selectedAll');
Route::get('/imageGalery/all/{id}', [ImageGaleryController::class, 'all'])->name('all');
Route::post('/imageGalery/delete/{id}', [ImageGaleryController::class, 'delete'])->name('delete');
//Route chats
Route::get('/chats/{id}', [ChatsController::class, 'index'])->name('index');
Route::post('/chats/create/{id}', [ChatsController::class, 'create'])->name('create');
Route::get('/selectChat/{id}', [ChatsController::class, 'selectChat'])->name('selectChat');
Route::post('chats/changeColor/{id}', [ChatsController::class, 'changeColor'])->name('changeColor');

//Rotas Messages 
Route::get('/messages/{id}', [MessagesController::class, 'index'])->name('index');
Route::post('/messages/send/{id}', [MessagesController::class, 'send'])->name('send');
Route::get('/messages/show/{id}', [MessagesController::class, 'show'])->name('show');
Route::post('/messages/remove/{id}', [MessagesController::class, 'remove'])->name('remove');

//Routes voice messages
Route::post('/messages/voice/{id}', [VoiceMessageController::class, 'send'])->name('send')->middleware('auth');
Route::get('/messages/voice/show/{id}', [VoiceMessageController::class, 'show'])->name('show')->middleware('auth');
Route::post('/messages/voice/delete/{id}', [VoiceMessageController::class, 'delete'])->name('delete')->middleware('auth');
//Routes to Appointments (agenda, compromissos)
Route::get('/appointments/{id}',[AppointmentBookController::class, 'index'])->name('index');
Route::post('/appointments/{id}', [AppointmentBookController::class, 'save'])->name('save');
Route::post('/appointments/update/{id}', [AppointmentBookController::class, 'update'])->name('update');
Route::post('/appointments/delete/{id}', [AppointmentBookController::class, 'delete'])->name('delete');

//Rotas de empresas
Route::post('/enterprise/create', [RegisterEnterpriseController::class , 'create'])->name('create');
