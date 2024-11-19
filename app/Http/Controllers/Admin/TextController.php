<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Text;
use App\Models\Kategori;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Illuminate\Support\Carbon;

class TextController extends Controller
{
    public function index(Request $request){

        $limit       = !empty($request->limit) ? $request->limit : 10 ;
        $kategori    = $request->kategori;
        $status      = $request->status;
        $search      = $request->search;

        $text = Text::with('kategori')
        ->where(function ($query) use ($status) {
            if (!empty($status)) {
              $query->where('terbit', '=', $status);
            }
        })
        ->where(function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%'.$search.'%')
                ->orWhere('terbit', 'like', '%'.$search.'%');
            });
        })
        ->orWhere(function ($query) use ($search) {
            $query->whereHas('kategori', function ($query) use ($search) {
                if (!empty($search)) {
                  $query->where('nama_kategori', 'like', '%'.$search.'%');
                }
            });
        });

        $text = $text->orderBy('id', 'DESC')->paginate($limit);

        $data['title']          = 'Text';
        $data['data']           =  $text;


        $data['kategoris']      = Kategori::where(['type'=>'text'])->orderBy('id', 'DESC')->get();

        if ($request->ajax()) {
            return view('admin.text.table', $data);
        }
        return view('admin.text.index', $data);
    }

    public function edit(Request $request){
        $id   = decrypt($request->id);
        try {
            $text = Text::with('kategori')->findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'code' => 404, 'message' => 'Data not found'], 404);
        }

        return response()->json(['status' => 'success', 'code' => 200, 'data' => $text], 200);
    }

    public function store(Request $request){
        $message = [
                    'required'                    => 'Input gagal, harap lengkapi semua field!',
                ];

        $validator = Validator::make($request->all(), [
            'id'  => 'required',
            'judul'  => 'required',
            'isi'  => 'required',
        ], $message);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
       
        $text                 = Text::find(decrypt($request->id));
        $text->isi            = $request->isi;
        $text->judul          = $request->judul;
        $text->terbit         = $request->terbit;
        $text->updated_at     = date("Y-m-d h:i:s");
        $text->deleted_at     = NULL;

        try {
            $text->save();
            return back()->with('success','Data berhasil disimpan!');
        } catch(\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function delete($id)
    {
        $id = decrypt($id);
        try {
            Text::where('id',$id)->delete();
            return back()->with('success','Data berhasil dihapus!');
        } catch(\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function preview(Request $request){
        $data = [ 
            'title' => 'Preview Text',
            'isi' => $request->isi,
            'judul' => $request->judul,
        ];

        $html = view('admin.text.preview', $data)->render();
        echo $html;
    }

    public function kelola(Request $request)
    {
    $data = $request->data;
    $action = $request->action;
    if ($action == 'publish') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Text::where('id', $dec_id)
        ->update(['terbit' => 'Ya']);
      }
    }elseif ($action == 'draft') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Text::where('id', $dec_id)
        ->update(['terbit' => 'Tidak']);
      }
    }elseif ($action == 'delete') {
      foreach ($data as $key => $value) {
        $value = str_replace('selected_', '', $value);
        $dec_id = decrypt($value);
        Text::where('id',$dec_id)->delete();
      }
    }
    return redirect()->route('admin_text');
    }
}
