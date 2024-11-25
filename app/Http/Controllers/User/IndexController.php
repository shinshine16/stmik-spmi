<?php

namespace App\Http\Controllers\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Dokumen;
use App\Models\Text;
use App\Models\Kategori;
use App\Models\Pejabat;
use App\Models\Jenis_dokumen;
use Datatables;
use LogActivity;

class IndexController extends Controller
{
    public function index()
    {
      $kategori = Kategori::with('menu')->where('type', 'document')->get()->toArray();
      $pejabat = Pejabat::all();
      $menu = Menu::with('kategori')->get();
      $jenis_dokumen = Jenis_dokumen::all();
      $tahun = Dokumen::select('tahun')->groupBy('tahun')->get();

      $data = array(
        'title' => ENV('APP_NAME'),
        'slug' => '',
        'tag' => '',
        'kategori' => $kategori,
        'pejabat' => $pejabat,
        'jenis_dokumen' => $jenis_dokumen,
        'tahun' => $tahun,
        'tag' => '<li>'.ENV('APP_NAME').'</li>',
      );
      return view('user/display', $data);
    }

    public function data(Request $request)
    {
      $page = ($request->start/$request->length) + 1;
      $limit = $request->length;
      $search = $request->search['value'];
      $slug = $request->slug != 'empty__' ? $request->slug : '';
      $filter_kategori = $request->kategori != 'empty__' ? decrypt($request->kategori) : '';
      $filter_pejabat = $request->pejabat != 'empty__' ? decrypt($request->pejabat) : '';
      $filter_jenis_dokumen = $request->jenis_dokumen != 'empty__' ? decrypt($request->jenis_dokumen) : '';
      $filter_tahun = $request->tahun != 'empty__' ? $request->tahun : '';
      $filter_status = $request->status != 'empty__' ? $request->status : '';

      $get_data = Dokumen::with(['pejabat', 'kategori', 'jenis_dokumen'])
              ->where(function ($query) use ($slug, $filter_kategori, $filter_pejabat, $filter_jenis_dokumen, $filter_tahun, $filter_status) {
                $query->whereHas('kategori', function ($query) use ($slug, $filter_kategori, $filter_pejabat, $filter_jenis_dokumen, $filter_tahun, $filter_status) {
                  if ($slug != '') {
                    $query->where('slug', '=', $slug);
                  }
                  if ($filter_kategori != '') {
                    $query->where('id_kategori', '=', $filter_kategori);
                  }
                  if ($filter_pejabat != '') {
                    $query->where('id_pejabat', '=', $filter_pejabat);
                  }
                  if ($filter_jenis_dokumen != '') {
                    $query->where('id_jenis_dokumen', '=', $filter_jenis_dokumen);
                  }
                  if ($filter_tahun != '') {
                    $query->where('tahun', '=', $filter_tahun);
                  }
                  if ($filter_status != '') {
                    $query->where('status', '=', $filter_status);
                  }
                });
              })
              ->where('terbit','=','Ya')
              ->where(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                  $query->where('no_sk', 'like', '%'.$search.'%')
                  ->orWhere('nama_standar', 'like', '%'.$search.'%')
                  ->orWhere('tahun', 'like', '%'.$search.'%')
                  ->orWhere('terbit', 'like', '%'.$search.'%')
                  ->orWhere('status', 'like', '%'.$search.'%');

                })
                ->orWhere(function ($query) use ($search) {
                  $query->whereHas('pejabat', function ($query) use ($search) {
                    $query->where('nama_pejabat', 'like', '%'.$search.'%');
                  });
                  $query->orWhereHas('kategori', function ($query) use ($search) {
                    $query->where('nama_kategori', 'like', '%'.$search.'%');
                  });
                  $query->orWhereHas('jenis_dokumen', function ($query) use ($search) {
                    $query->where('nama_jenis_dokumen', 'like', '%'.$search.'%');
                  });
                });
              });

        $recordsFiltered = $get_data->count();
        $recordsTotal = Dokumen::count();
        $dokumen = $get_data->limit($limit)->offset($request->start)->get()->toArray();
        
        //dd($dokumen);
      $data = [];
      if (empty($dokumen)) {
        $row = 0;
      }else{
        foreach ($dokumen as $key => $val) {
          $data = [];
          $data[] = '<span>'.$val['no_sk'].'</span>';
          $data[] = '<span>'.$val['nama_standar'].'</span>';
          $data[] = '<span>'.$val['kategori']['nama_kategori'].'</span>';
          $data[] = '<span>'.$val['pejabat']['nama_pejabat'].'</span>';
          $data[] = '<span>'.$val['jenis_dokumen']['nama_jenis_dokumen'].'</span>';
          $data[] = '<span>'.$val['tahun'].'</span>';
          $data[] = '<span>'.$val['status'].'</span>';
          if (decrypt($val['enc_file']) != '') {
            $data[] = '<div class="table_action">
            <button class="btn btn-custom fa fa-file openModal" data-id="'.$val['enc_id'].'"></button>

            <button type="button" class="btn btn-custom fa fa-download download-file" data-id="'.$val['enc_id'].'" ></button>
            </div>

          ';
          } else {
            $data[] = '<div class="table_action">
            <button class="btn btn-custom fa fa-file openModal" data-id="'.$val['enc_id'].'"></button>

            
            </div>

          ';
          }
          
          
          $row[] = $data;
        }
      }


      $result = array(
        'draw' 			  => $request->toArray()['draw'],
        'recordsTotal'    =>  $recordsTotal ,
        'recordsFiltered' => $recordsFiltered,
        'data'			  => $row
      );

      echo json_encode($result);
    }

    public function data_id(Request $request)
    {
      $id = decrypt($request->id);
      $dokumen = Dokumen::with('pejabat')
      ->with('kategori')
      ->with('jenis_dokumen')
      ->where('id', '=', $id)->get()->toArray();
      $response = [
        'status' => 'success',
        'code' => 200,
        'data' => $dokumen,
      ];

      echo json_encode($response);
    }

    public function download(Request $request)
    {
      LogActivity::addToLog('Download');
      $id = decrypt($request->id);
      $data = Dokumen::where('id', $id)->get()->toArray();
      if (decrypt($data[0]['enc_file']) == '' || decrypt($data[0]['enc_file']) == null) {
        $response =[
          'status' => 'failed',
          'message' => 'File tidak ada untuk data ini.'
        ];
      }else{
        $path  = url('storage/app/public/dokumen/'.decrypt($data[0]['enc_file']));
        $response =[
          'status' => 'success',
          'path' => $path
        ];
      }
      echo json_encode($response);
    }

    public function table($slug)
    {
      $kategori = Kategori::with('menu')->where(['type' => 'document'])->get()->toArray();
      $pejabat = Pejabat::all();
      $jenis_dokumen = Jenis_dokumen::all();
      $tahun = Dokumen::select('tahun')->groupBy('tahun')->get();

      $slug_name = Kategori::where(['slug' => $slug])->first();

      $data = array(
        'title' => env('APP_NAME'),
        'tag' => '<li><a href="'.url('').'">'.ENV('APP_NAME').'</a></li> <li>'.$slug_name->nama_kategori .'</li>',
        'slug' => $slug,
        'kategori' => $kategori,
        'pejabat' => $pejabat,
        'jenis_dokumen' => $jenis_dokumen,
        'tahun' => $tahun,
      );
      return view('user/display', $data);
    }

    public function data_text($slug)
    {
      $text = Text::with(['kategori'])
                    ->where(function ($query) use ($slug) {
                      $query->whereHas('kategori', function ($query) use ($slug) {
                        $query->where('slug', '=', $slug);
                      });
                    })
                    ->get()->first();
      $data = array(
        'title' => env('APP_NAME').' - '.$text->kategori['nama_kategori'],
        'tag' => '<li><a href="'.url('').'">'.ENV('APP_NAME').'</a></li> <li>' .$text->kategori['nama_kategori']. '</li>',
        'text' => $text,
      );
      return view('user/display_text', $data);
    }
}
