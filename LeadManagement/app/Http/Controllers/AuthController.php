<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;



class AuthController extends Controller
{
    public function AuthFn(){
        if(Auth::id()){
            $usertype=Auth()->user()->user_type;
            if($usertype=='admin'){
                $executives=User::where('user_type','!=','admin')->latest()->paginate(10);
                return view('admin.dashboard',compact('executives'));
            }else if($usertype=='executive'){
                $leads=Lead::where('user_id',Auth::id())->latest()->paginate(10);
                return view('dashboard',compact('leads'));
            }else{
                return redirect()->back();
            }
        }
    }
}
