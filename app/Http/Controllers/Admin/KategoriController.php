<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Str;
use Validator;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Text;

class KategoriController extends Controller
{
  public function index()
  {
    $menu = Menu::all();
    $kategori = Kategori::all();
    $data = array(
      'menu' => $menu,
      'parent' => $kategori,
    );
    return view('admin.master.kategori.index', $data);
  }

  public function data(Request $request)
  {
    $page = ($request->start/$request->length) + 1;
    $limit = $request->length;
    $search = $request->search['value'];
    $filter_menu = $request->menu != 'empty__' ? decrypt($request->menu) : '';
    $filter_type = $request->type != 'empty__' ? $request->type : '';
    $filter_publish = $request->publish != 'empty__' ? $request->publish : '';

    $get_data = Kategori::with(['menu', 'parent'])
                        ->where(function ($query) use ($filter_menu, $filter_type, $filter_publish) {
                            if ($filter_menu != '') {
                              $query->where('id_menu', '=', $filter_menu);
                            }
                            if ($filter_type != '') {
                              $query->where('type', '=', $filter_type);
                            }
                            if ($filter_publish != '') {
                              $query->where('terbit', '=', $filter_publish);
                            }
                        })
                        ->where(function ($query) use ($search) {
                          $query->where(function ($query) use ($search) {
                            $query->where('nama_kategori', 'like', '%'.$search.'%')
                            ->orWhere('type', 'like', '%'.$search.'%')
                            ->orWhere('terbit', 'like', '%'.$search.'%');

                          });
                          $query->orWhere(function ($query) use ($search) {
                            $query->whereHas('menu', function ($query) use ($search) {
                              $query->where('nama_menu', 'like', '%'.$search.'%');
                            });
                            $query->orWhereHas('parent', function ($query) use ($search) {
                              $query->where('nama_kategori', 'like', '%'.$search.'%');
                            });
                          });
                        });


    $recordsFiltered = $get_data->count();
    $recordsTotal = Kategori::count();
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
                  $data_final[] = '<span>'.$val['nama_kategori'].'</span>';
        $data_final[] = '<span>'.$val['menu']['nama_menu'].'</span>';
        $parent = $val['parent'] != null ? $val['parent']['nama_kategori'] : '-';
        $data_final[] = '<span>'.$parent.'</span>';
        $data_final[] = '<span>'.$val['type'].'</span>';
        $icon_terbit = $val['terbit'] == 'Ya' ? '<i class="fa fa-flag"></i>' : '<i class="fa fa-archive"></i>' ;
        $color_terbit = $val['terbit'] == 'Ya' ? 'green' : 'red';
        $data_final[] = '<center><div class="label badge--'.$color_terbit.' label--md"><span class="label__icon">'.$icon_terbit.'</span>'.$val['terbit'].'</div></center>';
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
    $data = Kategori::with('menu')->with('parent')
    ->where('id', '=', $id)->get()->toArray();
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
  		'nama_kategori.required'=>'Nama kategori tidak boleh kosong',
  	);
    $validator = Validator::make($params, [
        'nama_kategori' => 'required',
    ], $messsages);
    if ($validator->passes()) {
      if ($params['proses'] == 'create') {
        $data_params = array(
          'enc_id' => $params['enc_id'] != '' ? decrypt($params['enc_id']) : '',
          'id_menu' => $params['menu'] != '' ? decrypt($params['menu']) : '',
          'id_parent' => $params['parent'] != 'empty__' ? decrypt($params['parent']) : NULL,
          'nama_kategori' => $params['nama_kategori'] != '' ? $params['nama_kategori'] : '',
          'type' => $params['type'] != '' ? $params['type'] : '',
          'slug' => $params['nama_kategori'] != '' ? Str::slug($params['nama_kategori'].'-'.date('Ymdhis')) : '',
          'terbit' => $params['terbit'] != '' ? $params['terbit'] : '',
        );

        $data = new Kategori;

        $data->id_menu = $data_params['id_menu'];
        $data->id_parent = $data_params['id_parent'];
        $data->nama_kategori = $data_params['nama_kategori'];
        $data->type = $data_params['type'];
        $data->slug = $data_params['slug'];
        $data->terbit = $data_params['terbit'];

        $response = [
          'status' => 'success',
          'code' => 200,
          'pesan' => 'Data berhasil diproses',
        ];

        try {
          $data->save();

          if ($data_params['type'] == 'text') {
            $text = new Text;
            $text->id_kategori = $data->id;
            $text->terbit = 'Tidak';
            $text->save();
          }
        } catch (\Exception $e) {
          $response = [
            'status' => 'error',
            'pesan' => 'Gagal menyimpan kategori!',
            'error' => $e->getMessage(),
            'code' => 500,
          ];
        }
      }elseif ($params['proses'] == 'update') {
        $id = decrypt($params['enc_id']);
        $data_params = array(
          'id_menu' => $params['menu'] != '' ? decrypt($params['menu']) : '',
          'id_parent' => $params['parent'] != 'empty__' ? decrypt($params['parent']) : NULL,
          'nama_kategori' => $params['nama_kategori'] != '' ? $params['nama_kategori'] : '',
          'type' => $params['type'] != '' ? $params['type'] : '',
          'slug' => $params['nama_kategori'] != '' ? Str::slug($params['nama_kategori'].'-'.date('Ymdhis')) : '',
          'terbit' => $params['terbit'] != '' ? $params['terbit'] : '',
        );

        $response = [
        'status' => 'success',
        'code' => 200,
        'pesan' => 'Data berhasil diproses',
        ];

        try {
          Kategori::where("id", $id)->update($data_params);
          if ($data_params['type'] == 'text') {
            $check = Text::where('id_kategori',$id)->get()->toArray();
            if (empty($check)) {
              $text = new Text;
              $text->id_kategori = $id;
              $text->terbit = 'Tidak';
              $text->save();
            }
          }
        } catch (\Exception $e) {
          $response = [
          'status' => 'error',
          'pesan' => 'Gagal mengubah kategori!',
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
        Kategori::where('id', $dec_id)
        ->update(['terbit' => 'Ya']);
      }
    }elseif ($action == 'draft') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Kategori::where('id', $dec_id)
        ->update(['terbit' => 'Tidak']);
      }
    }elseif ($action == 'delete') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Kategori::where('id',$dec_id)->delete();
      }
    }
    return redirect()->route('admin_master_kategori');
  }

}
