<?php
use Illuminate\Support\Facades\Route;
use App\Events\MessageSent;
use App\Http\Controllers\SendMessageController;
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

Route::get('/send', function () {
    event(new MessageSent('Sveikas iš Laravel WebSockets! 🚀'));
    return 'Išsiųsta!';
});

Route::get('/test', function () {
    return view('test');
});


Route::get('/sendmsg', [SendMessageController::class, 'index']);
Route::post('/sendmsg', [SendMessageController::class, 'send']);