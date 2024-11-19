<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Session;
use App\Rules\MatchOldPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $messsages = array(
            'current_password.required'=>'Password lama tidak boleh kosong',
            'new_password.required'=>'Password baru tidak boleh kosong',
            'new_confirm_password.same'=>'Konfirmasi password harus sama',
            'min'=>'Minamal password baru 8 Karakter',
        );

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required','min:8'],
            'new_confirm_password' => ['same:new_password'],
        ], $messsages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        
        Auth::logout();

        return redirect()->route('login')->with('success_changepass','Password berhasil disimpan!');

    }
}
