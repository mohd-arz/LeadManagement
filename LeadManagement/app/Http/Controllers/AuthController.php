<?php

namespace App\Http\Controllers;

//Importing Necessary Packages
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;

class AuthController extends Controller
{
    public function AuthFn(){
        //Auth::id() has value
        if(Auth::id()){
            $usertype=Auth()->user()->user_type;
            if($usertype=='admin'){

                //if the Authenticated user is Admin
                $executives=User::where('user_type','!=','admin')->latest()->paginate(10);

                return view('admin.dashboard',compact('executives'));
            }else if($usertype=='executive'){

                //if the Authenticated user is Admin
                $leads=Lead::where('user_id',Auth::id())->latest()->paginate(10);
                
                return view('dashboard',compact('leads'));
            }else{
                //Redirect back to previous page
                return redirect()->back();
            }
        }
    }
}
