<?php

use App\Http\Controllers\CodeController;
use App\Http\Controllers\EventController;
use App\Http\Livewire\Admin\ControllAccessComponent;
use App\Imports\CodesImport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

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
    return view('dashboard');
});

Route::get('/controll-access',ControllAccessComponent::class)->name('controllaccess');

Route::resource('/events',EventController::class);
