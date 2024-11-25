<?php

use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\JenisDokumenController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PejabatController;
use App\Http\Controllers\Admin\TextController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\IndexController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
//log-viewers
Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Auth::routes();
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('change-password', 'Admin\ChangePasswordController@store')->name('change.password');

Route::get('/', [IndexController::class, 'index'])->name('user_index');
Route::get('/user-table/{slug}', [IndexController::class, 'table'])->name('user_table');
Route::get('/user-download', [IndexController::class, 'download'])->name('user_download');
Route::get('/user-data', [IndexController::class, 'data'])->name('user_data');
Route::get('/user-data-id', [IndexController::class, 'data_id'])->name('user_data_id');

Route::get('/text/{slug}', [IndexController::class, 'data_text'])->name('user_text');

Route::group(['middleware' => ['auth','role:superadmin,admin']], function () {
	Route::get('/admin', [LoginController::class,'index'])->name('admin');
	Route::get('/admin-dashboard', [DashboardController::class, 'index'])->name('admin_dashboard');

	// Dokumen
	Route::get('/admin-document', [DocumentController::class,'index'])->name('admin_document');
  Route::post('/admin-document-data', [DocumentController::class,'data'])->name('admin_document_data');
  Route::post('/admin-document-get-id', [DocumentController::class,'data_id'])->name('admin_document_data_id');
  Route::post('/admin-document-proses', [DocumentController::class,'proses'])->name('admin_document_proses');
  Route::post('/admin-document-kelola', [DocumentController::class,'kelola'])->name('admin_document_kelola');
  Route::post('/admin-document-upload',[DocumentController::class,'upload'])->name('admin_document_upload');
  Route::post('/admin-file', [DocumentController::class,'file'])->name('admin_file');

	// Text
	Route::get('/admin-text', [TextController::class,'index'])->name('admin_text');
	Route::get('/admin-text-edit', [TextController::class,'edit'])->name('text_edit');
	Route::put('/admin-text-store', [TextController::class,'store'])->name('text_store');
	Route::delete('/admin-text-delete/{id}', [TextController::class,'delete'])->name('text_delete');
	Route::post('/admin-text-kelola', [TextController::class,'kelola'])->name('admin_text_kelola');
	Route::post('/admin-text-preview', [TextController::class,'preview'])->name('text_preview');
	Route::put('/admin-text-preview', [TextController::class,'preview'])->name('text_preview');

	// ===============================MASTER===============================
	// Menu
	Route::get('/admin-master-menu', [MenuController::class,'index'])->name('admin_master_menu');
  Route::post('/admin-master-menu-data', [MenuController::class,'data'])->name('admin_master_menu_data');
  Route::post('/admin-master-menu-get-id', [MenuController::class,'data_id'])->name('admin_master_menu_data_id');
  Route::post('/admin-master-menu-proses', [MenuController::class,'proses'])->name('admin_master_menu_proses');
  Route::post('/admin-master-menu-kelola', [MenuController::class,'kelola'])->name('admin_master_menu_kelola');

	// Kategori
	Route::get('/admin-master-kategori', [KategoriController::class,'index'])->name('admin_master_kategori');
  Route::post('/admin-master-kategori-data', [KategoriController::class,'data'])->name('admin_master_kategori_data');
  Route::post('/admin-master-kategori-get-id', [KategoriController::class,'data_id'])->name('admin_master_kategori_data_id');
  Route::post('/admin-master-kategori-proses', [KategoriController::class,'proses'])->name('admin_master_kategori_proses');
  Route::post('/admin-master-kategori-kelola', [KategoriController::class,'kelola'])->name('admin_master_kategori_kelola');

	// Pejabat
	Route::get('/admin-master-pejabat', [PejabatController::class,'index'])->name('admin_master_pejabat');
  Route::post('/admin-master-pejabat-data', [PejabatController::class,'data'])->name('admin_master_pejabat_data');
  Route::post('/admin-master-pejabat-get-id', [PejabatController::class,'data_id'])->name('admin_master_pejabat_data_id');
  Route::post('/admin-master-pejabat-proses', [PejabatController::class,'proses'])->name('admin_master_pejabat_proses');
  Route::post('/admin-master-pejabat-kelola', [PejabatController::class,'kelola'])->name('admin_master_pejabat_kelola');

	// Jenis Dokumen
	Route::get('/admin-master-jenis-dokumen', [JenisDokumenController::class,'index'])->name('admin_master_jenis_dokumen');
  Route::post('/admin-master-jenis-dokumen-data', [JenisDokumenController::class,'data'])->name('admin_master_jenis_dokumen_data');
  Route::post('/admin-master-jenis-dokumen-get-id', [JenisDokumenController::class,'data_id'])->name('admin_master_jenis_dokumen_data_id');
  Route::post('/admin-master-jenis-dokumen-proses', [JenisDokumenController::class,'proses'])->name('admin_master_jenis_dokumen_proses');
  Route::post('/admin-master-jenis-dokumen-kelola', [JenisDokumenController::class,'kelola'])->name('admin_master_jenis_dokumen_kelola');

  // Configurations
	Route::get('/admin-config', [ConfigController::class,'index'])->name('admin_config');
	Route::post('/admin-store', [ConfigController::class,'store'])->name('admin_config_store');

});
