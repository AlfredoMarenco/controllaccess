<?php

use App\Http\Controllers\CodeController;
use App\Http\Controllers\EventController;
use App\Http\Livewire\Admin\AdministrationComponent;
use App\Http\Livewire\Admin\ConfigurationComponent;
use App\Http\Livewire\Admin\ControllAccessComponent;
use App\Http\Livewire\Admin\DashboardComponent;
use App\Http\Livewire\Admin\ReportComponent;
use App\Imports\CodesImport;
use App\Models\Admin\Box;
use App\Models\Admin\Code;
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

Route::get('/', DashboardComponent::class)->name('dashboard');

Route::get('/controll-access',ControllAccessComponent::class)->name('controllaccess');
Route::get('/reports',ReportComponent::class)->name('reports');
Route::get('/administration',AdministrationComponent::class)->name('administration');
/* Route::get('/configuration',ConfigurationComponent::class)->name('configuration'); */


Route::get('/update-box', function(){
    $codes = Code::all();
    foreach ($codes as $code) {
        $box = Box::where('name',$code->section)->where('identifier',$code->row)->first();
        if ($box) {
            $code->update([
                'box_id' => $box->id
            ]);
        }

    }
});

Route::resource('/events',EventController::class);