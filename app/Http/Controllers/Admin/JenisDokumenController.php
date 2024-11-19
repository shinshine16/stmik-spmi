<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\Jenis_dokumen;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Validator;

class JenisDokumenController extends Controller
{
  public function index()
  {
    return view('admin.master.jenis_dokumen.index');
  }

  public function data(Request $request)
  {
    $page = ($request->start/$request->length) + 1;
    $limit = $request->length;
    $search = $request->search['value'];


    $get_data = Jenis_dokumen::where(function ($query) use ($search) {
                      $query->where('nama_jenis_dokumen', 'like', '%'.$search.'%');
                  });
    $recordsFiltered = $get_data->count();
    $recordsTotal = Jenis_dokumen::count();
    $data = $get_data->limit($limit)->offset($request->start)->get()->toArray();

    $data_final = [];
    if (empty($data)) {
      $row = 0;
    }else{
      foreach ($data as $key => $val) {
        $data_final = [];
        $data_final[] = '<div class="table__checkbox table__checkbox--all">
                    <label class="checkbox">
                      <input type="checkbox" class="subSelect" value="'.$val['enc_id'].'" data-checkbox="product"><span class="checkbox__marker"><span class="checkbox__marker-icon">
                      <svg class="icon-icon-checked">
                        <use xlink:href="#icon-checked"></use>
                      </svg></span></span>
                    </label>
                  </div>';
        $data_final[] = '<span>'.$val['nama_jenis_dokumen'].'</span>';
        $data_final[] = '<div class="items-more">
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
                    </ul>
                </div>
            </div>
        </div>';
        $row[] = $data_final;
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
    $data = Jenis_dokumen::where('id', '=', $id)->get()->toArray();
    $response = [
      'status' => 'success',
      'code' => 200,
      'data' => $data,
    ];

    echo json_encode($response);
  }

  public function proses(Request $request)
  {
    $params = $request->all();
    $messsages = array(
  		'nama_jenis_dokumen.required'=>'Nama jenis dokumen tidak boleh kosong',
  	);
    $validator = Validator::make($params, [
        'nama_jenis_dokumen' => 'required',
    ], $messsages);
    if ($validator->passes()) {
      if ($params['proses'] == 'create') {
        $data_params = array(
          'enc_id' => $params['enc_id'] != '' ? decrypt($params['enc_id']) : '',
          'nama_jenis_dokumen' => $params['nama_jenis_dokumen'] != '' ? $params['nama_jenis_dokumen'] : '',
        );

        $data = new Jenis_dokumen;

        $data->nama_jenis_dokumen = $data_params['nama_jenis_dokumen'];

        $response = [
          'status' => 'success',
          'code' => 200,
          'pesan' => 'Data berhasil diproses',
        ];

        try {
          $data->save();
        } catch (\Exception $e) {
          $response = [
            'status' => 'error',
            'pesan' => 'Gagal menyimpan jenis dokumen!',
            'error' => $e->getMessage(),
            'code' => 500,
          ];
        }
      }elseif ($params['proses'] == 'update') {
        $id = decrypt($params['enc_id']);
        $data_params = array(
        'nama_jenis_dokumen' => $params['nama_jenis_dokumen'] != '' ? $params['nama_jenis_dokumen'] : '',
        );

        $response = [
        'status' => 'success',
        'code' => 200,
        'pesan' => 'Data berhasil diproses',
        ];

        try {
          Jenis_dokumen::where("id", $id)->update($data_params);
        } catch (\Exception $e) {
          $response = [
          'status' => 'error',
          'pesan' => 'Gagal mengubah jenis dokumen!',
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
        Jenis_dokumen::where('id', $dec_id)
        ->update(['terbit' => 'Ya']);
      }
    }elseif ($action == 'draft') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Jenis_dokumen::where('id', $dec_id)
        ->update(['terbit' => 'Tidak']);
      }
    }elseif ($action == 'delete') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Jenis_dokumen::where('id',$dec_id)->delete();
      }
    }
    return redirect()->route('admin_master_jenis_dokumen');
  }
}
