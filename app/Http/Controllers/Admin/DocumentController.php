<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\Pejabat;
use App\Models\Jenis_dokumen;
use App\Models\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Validator;

class DocumentController extends Controller
{
  public function index()
  {
    $data = [];
    $kategori = Kategori::with('menu')->where('type', 'document')->get()->toArray();
    $pejabat = Pejabat::all();
    $jenis_dokumen = Jenis_dokumen::all();
    $tahun = Dokumen::select('tahun')->groupBy('tahun')->get();
    $data = array(
      'kategori' => $kategori,
      'pejabat' => $pejabat,
      'jenis_dokumen' => $jenis_dokumen,
      'tahun' => $tahun,
    );
    return view('admin.document.index', $data);
  }

  public function data(Request $request)
  {
    // dd($request->all());
    $page = ($request->start/$request->length) + 1;
    $limit = $request->length;
    $search = $request->search['value'];
    $filter_kategori = $request->kategori != 'empty__' ? decrypt($request->kategori) : '';
    $filter_pejabat = $request->pejabat != 'empty__' ? decrypt($request->pejabat) : '';
    $filter_jenis_dokumen = $request->jenis_dokumen != 'empty__' ? decrypt($request->jenis_dokumen) : '';
    $filter_tahun = $request->tahun != 'empty__' ? $request->tahun : '';
    $filter_status = $request->status != 'empty__' ? $request->status : '';
    $filter_publish = $request->publish != 'empty__' ? $request->publish : '';

    $get_data = Dokumen::with(['pejabat', 'kategori', 'jenis_dokumen'])
                        ->where(function ($query) use ($filter_kategori, $filter_pejabat, $filter_jenis_dokumen, $filter_tahun, $filter_status, $filter_publish) {
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
                            if ($filter_publish != '') {
                              $query->where('terbit', '=', $filter_publish);
                            }
                        })
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

    $data = [];
    if (empty($dokumen)) {
      $row = 0;
    }else{
      foreach ($dokumen as $key => $val) {
        $data = [];
        $data[] = '<div class="table__checkbox table__checkbox--all">
                    <label class="checkbox">
                      <input type="checkbox" class="subSelect" value="'.$val['enc_id'].'" data-checkbox="product"><span class="checkbox__marker"><span class="checkbox__marker-icon">
                      <svg class="icon-icon-checked">
                        <use xlink:href="#icon-checked"></use>
                      </svg></span></span>
                    </label>
                  </div>';
        $data[] = '<span>'.$val['no_sk'].'</span>';
        $data[] = '<span>'.$val['nama_standar'].'</span>';
        $data[] = '<span>'.$val['kategori']['nama_kategori'].'</span>';
        $data[] = '<span>'.$val['pejabat']['nama_pejabat'].'</span>';
        $data[] = '<span>'.$val['jenis_dokumen']['nama_jenis_dokumen'].'</span>';
        $data[] = '<span>'.$val['tahun'].'</span>';
        $color_status = $val['status'] == 'Ada' ? 'green' : 'red';
        $data[] = '<div class="table__status"><span class="table__status-icon color-'.$color_status.'"></span> '.$val['status'].'</div>';
        $icon_terbit = $val['terbit'] == 'Ya' ? '<i class="fa fa-flag"></i>' : '<i class="fa fa-archive"></i>' ;
        $color_terbit = $val['terbit'] == 'Ya' ? 'green' : 'red';
        $data[] = '<center><div class="label badge--'.$color_terbit.' label--md"><span class="label__icon">'.$icon_terbit.'</span>'.$val['terbit'].'</div></center>';
        $data[] = '<div class="items-more">
            <button class="items-more__button">
                <svg class="icon-icon-more">
                    <use xlink:href="#icon-more"></use>
                </svg>
            </button>

            <div class="dropdown-items dropdown-items--right dropdown-items--up">
                <div class="dropdown-items__container">
                    <ul class="dropdown-items__list">
                        <li class="dropdown-items__item"><button class="dropdown-items__link openModal" data-id="'.$val['enc_id'].'"><span class="dropdown-items__link-icon">
    <svg class="icon-icon-view">
      <use xlink:href="#icon-view"></use>
    </svg></span>Update</button>
                        </li>
                        <li class="dropdown-items__item"><button data-id="'.$val['enc_id'].'" class="dropdown-items__link download-file"><span class="dropdown-items__link-icon">
      <svg class="icon-icon-download">
        <use xlink:href="#icon-download"></use>
      </svg></span>Download</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>';
        $row[] = $data;
      }
    }

    $result = array(
  		'draw' 			  => $request->toArray()['draw'],
  		'recordsTotal'    => $recordsTotal,
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

  public function upload(Request $request)
  {
    $file_data = $request->file('upload_file');
    if ($file_data != '') {
      $name                = $file_data->getClientOriginalName();
      $ext                 = $file_data->getClientOriginalExtension();
      $file_name          = 'Document-' . rand(000,999) . '-' . date('YmdHis') . '.' . $ext;
      $enc_name           = encrypt($file_name);
      $destination_path    = storage_path('app/public/dokumen');

      if ($file_data->move($destination_path, $file_name)) {
        $file = new File;
        $file->file_name = $file_name;
        $file->token = $enc_name;

        $response = [
          'status' => 'success',
          'code' => 200,
          'name' => $file_name,
          'enc_name' => $enc_name,
        ];

        try {
          $file->save();
        } catch (\Exception $e) {
          $response = [
            'status' => 'error',
            'pesan' => 'Gagal menyimpan file, ulang kembali!',
            'error' => $e->getMessage(),
            'code' => 500,
          ];
        }

        echo json_encode($response);
      }
    }
  }

  public function proses(Request $request)
  {
    $params = $request->all();
    $messsages = array(
  		'no_sk.required'=>'Nomer SK tidak boleh kosong',
  		'nama_standar.required'=>'Nama standar tidak boleh kosong',
      'tahun.required'=>'Tahun tidak boleh kosong',
      'tahun.numeric'=>'Tahun harus berupa angka',
      'tahun.digits'=>'Tahun harus 4 angka',
      'keterangan.required'=>'Keterangan tidak boleh kosong',
  	);
    $validator = Validator::make($params, [
        'no_sk' => 'required',
        'nama_standar' => 'required',
        'tahun' => 'required|numeric|digits:4',
        'keterangan' => 'required',
    ], $messsages);
    if ($validator->passes()) {
      if ($params['proses'] == 'create') {
        $data = array(
          'enc_id' => $params['enc_id'] != '' ? decrypt($params['enc_id']) : '',
          'terbit' => $params['terbit'] != '' ? $params['terbit'] : '',
          'no_sk' => $params['no_sk'] != '' ? $params['no_sk'] : '',
          'nama_standar' => $params['nama_standar'] != '' ? $params['nama_standar'] : '',
          'kategori' => $params['kategori'] != '' ? decrypt($params['kategori']) : '',
          'pejabat' => $params['pejabat'] != '' ? decrypt($params['pejabat']) : '',
          'jenis_dokumen' => $params['jenis_dokumen'] != '' ? decrypt($params['jenis_dokumen']) : '',
          'tahun' => $params['tahun'] != '' ? $params['tahun'] : '',
          'status' => $params['status'] != '' ? $params['status'] : '',
          'keterangan' => $params['keterangan'] != '' ? $params['keterangan'] : '',
          'file' => $params['file'] != '' ? decrypt($params['file']) : '',
          'token' => $params['file'] != '' ? $params['file'] : '',
        );

        if ($data['file'] != '' || $data['file'] != null) {
          $file_name  = 'Document-' . str_replace([' ','-','/'], '_', $data['nama_standar']) . '-' . date('YmdHis') . '.' . explode('.', $data['file'])[1];
          Storage::rename('public/dokumen/'.$data['file'], 'public/dokumen/'.$file_name);
          $data['file'] = $file_name;
        }

        $document = new Dokumen;

        $document->terbit = $data['terbit'];
        $document->no_sk = $data['no_sk'];
        $document->nama_standar = $data['nama_standar'];
        $document->id_kategori = $data['kategori'];
        $document->id_pejabat = $data['pejabat'];
        $document->id_jenis_dokumen = $data['jenis_dokumen'];
        $document->tahun = $data['tahun'];
        $document->status = $data['status'];
        $document->keterangan = $data['keterangan'];
        $document->file = $data['file'];
        $document->token = $data['token'];

        $response = [
          'status' => 'success',
          'code' => 200,
          'pesan' => 'Data berhasil diproses',
        ];

        try {
          $document->save();
        } catch (\Exception $e) {
          $response = [
            'status' => 'error',
            'pesan' => 'Gagal menyimpan dokumen!',
            'error' => $e->getMessage(),
            'code' => 500,
          ];
        }
      }elseif ($params['proses'] == 'update') {
        $id = decrypt($params['enc_id']);
        $data = array(
        'terbit' => $params['terbit'] != '' ? $params['terbit'] : '',
        'no_sk' => $params['no_sk'] != '' ? $params['no_sk'] : '',
        'nama_standar' => $params['nama_standar'] != '' ? $params['nama_standar'] : '',
        'id_kategori' => $params['kategori'] != '' ? decrypt($params['kategori']) : '',
        'id_pejabat' => $params['pejabat'] != '' ? decrypt($params['pejabat']) : '',
        'id_jenis_dokumen' => $params['jenis_dokumen'] != '' ? decrypt($params['jenis_dokumen']) : '',
        'tahun' => $params['tahun'] != '' ? $params['tahun'] : '',
        'status' => $params['status'] != '' ? $params['status'] : '',
        'keterangan' => $params['keterangan'] != '' ? $params['keterangan'] : '',

        );

        $file = $params['file'] != '' ? decrypt($params['file']) : '';
        $data['token'] = $params['file'] != '' ? $params['file'] : $params['old_token'];

        if ($file != '' || $file != null) {
          $file_name          = 'Document-' . str_replace([' ','-','/'], '_', $data['nama_standar']) . '-' . date('YmdHis') . '.' . explode('.', $file)[1];
          Storage::rename('public/dokumen/'.$file, 'public/dokumen/'.$file_name);
          $data['file'] = $file_name;
        }

        $response = [
        'status' => 'success',
        'code' => 200,
        'pesan' => 'Data berhasil diproses',
        ];

        try {
          Dokumen::where("id", $id)->update($data);
        } catch (\Exception $e) {
          $response = [
          'status' => 'error',
          'pesan' => 'Gagal mengubah dokumen!',
          'error' => $e->getMessage(),
          'code' => 500,
          ];
        }
      }
    }else{
      $response = [
        'status' => 'validate',
        'pesan' => $validator->errors()->toArray(),
      ];

    }

    echo json_encode($response);
  }

  public function kelola(Request $request)
  {
    $data = $request->data;
    $action = $request->action;
    if ($action == 'publish') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Dokumen::where('id', $dec_id)
        ->update(['terbit' => 'Ya']);
      }
    }elseif ($action == 'draft') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Dokumen::where('id', $dec_id)
        ->update(['terbit' => 'Tidak']);
      }
    }elseif ($action == 'delete') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Dokumen::where('id',$dec_id)->delete();
      }
    }
    return redirect()->route('admin_document');
  }

  public function file(Request $request)
    {
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
}
