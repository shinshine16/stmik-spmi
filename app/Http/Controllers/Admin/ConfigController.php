<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use Validator;

class ConfigController extends Controller
{
    public function index()
    {
      $config = Config::findOrFail(1);
      $data = [
        'config' => $config
      ];  
      return view('admin/config/index', $data);
    }    

    public function store(Request $request){

      $params = $request->all();
      $messsages = array(
        'nama_aplikasi.required' => "Nama Aplikasi tidak boleh kosong.",
        'deskripsi.required' => "Deskripsi tidak boleh kosong.",
        'lokasi.required' => "Lokasi tidak boleh kosong.",
        'email.required' => "Email tidak boleh kosong.",
        'telpon.required' => "Telpon tidak boleh kosong.",
        'facebook.required' => "Facebook tidak boleh kosong.",
        'whatsapp.required' => "Whatsapp tidak boleh kosong.",
        'instagram.required' => "Instagram tidak boleh kosong.",
        'youtube.required' => "Youtube tidak boleh kosong.",
        'linkedin.required' => "Linkedin tidak boleh kosong.",
      );
      $validator = Validator::make($params, [
          'nama_aplikasi' => 'required', 
          'deskripsi' => 'required', 
          'lokasi' => 'required', 
          'email' => 'required', 
          'telpon' => 'required', 
          'facebook' => 'required', 
          'whatsapp' => 'required', 
          'instagram' => 'required', 
          'youtube' => 'required', 
          'linkedin' => 'required', 
      ], $messsages);

      if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
      }


      $config                 = Config::find(1);
      $config->nama_aplikasi     = $request->nama_aplikasi;
      $config->deskripsi         = $request->deskripsi;
      $config->lokasi            = $request->lokasi;
      $config->email             = $request->email;
      $config->telpon            = $request->telpon;
      $config->facebook          = $request->facebook;
      $config->whatsapp          = $request->whatsapp;
      $config->instagram         = $request->instagram;
      $config->youtube           = $request->youtube;
      $config->linkedin          = $request->linkedin;
      $config->updated_at        = date("Y-m-d h:i:s");
      $config->deleted_at        = NULL;
      
      if($request->hasFile('file_upload'))
      { 
          $file           = $request->file('file_upload');
          $upload_path    = storage_path('app/public/config'); 
          $name           = 'logo'.date('Ymd-hms').'.'.$file->extension();

          try {
              $file->move($upload_path, $name);
              $config->logo = $name;
          } catch(\Exception $e) {
              Log::channel('error-message')->info(basename(__FILE__) .' ('. __LINE__.') '.$e->getMessage());
          }
      }

      try {
          $config->save();
          return back()->with('success','Data berhasil disimpan!');
      } catch(\Exception $e) {
          return back()->withError($e->getMessage())->withInput();
      }

    }
}
