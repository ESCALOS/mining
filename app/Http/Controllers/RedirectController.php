<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index(){
        if(Auth()->user() == NULL){
            return redirect('login');
        }else{
            $user = User::find(auth()->user()->id);
            if($user->hasRole('administrador')){
                return redirect()->route('administrador.concentrate');
            }else{
                return view('dashboard');
            }
        }
    }
}
