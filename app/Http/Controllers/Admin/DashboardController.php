<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\LogActivity;


class DashboardController extends Controller
{
    public function index(){
        $file = Dokumen::whereNotNull('file')->get()->count();
        $download = LogActivity::where('subject', '=', 'Download')->get()->count();

        $data =[
            'total_dokumen' =>  Dokumen::count(),
            'total_file' =>  $file,
            'total_download' =>  $download
        ];
        
        return view('admin.dashboard.index', $data);
    }
}
