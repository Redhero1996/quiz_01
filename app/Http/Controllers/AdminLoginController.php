<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminLoginController extends Controller
{
    function getlogin()
    {
        if (Auth::check()) {
            foreach(session()->all() as $key => $value){
                if ($value == Auth::user()->id) {

                    return redirect('admin/users');
                }
            }
        }

        return view('admin.login');
    }

    function postlogin(AdminRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', '=', $request->email)->firstOrFail();
            if ($user->role_id == '1') {

                return redirect()->route('users.index');
            }
            else {
                foreach (session()->all() as $key => $value){
                    if ($value == Auth::user()->id) {
                        session()->forget($key);
                    }
                }

                return redirect('admin/login')->with('error', __('translate.account_error'));
            }
        } else {

            return redirect('admin/login')->with('error', __('translate.error'));
        }
    }

    function logout()
    {
        foreach (session()->all() as $key => $value){
            if ($value == Auth::user()->id) {
                session()->forget($key);
            }
        }

        return redirect('admin/login');
    }
}
