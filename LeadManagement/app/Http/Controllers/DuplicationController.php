<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Duplicate;

class DuplicationController extends Controller
{
    //Duplication//

    //Adding Duplication Value
    public function addDuplicate(){
        //Getting the latest Duplicate --
        $duplicate = Duplicate::latest()->first();
        Lead::create([
            'name'=>$duplicate->name,
            'email'=>$duplicate->email,
            'phone_no'=>$duplicate->phone_no,
            'phone_code'=>$duplicate->phone_code,
            'category'=>$duplicate->category,
            'remark'=>$duplicate->remark,
            'user_id'=>Auth::id(),
        ]);

        //there's no use for that field
        Duplicate::latest()->first()->delete();
        return redirect()->route('home')->with('message','Lead Added Successfully');
    }
    /////
    
    //When Reject to Add Duplication value 
    public function rejectDuplicate(){
        Duplicate::all()->first()->delete();
        return redirect()->route('home')->with('message','Duplication Rejected Successfully');
    }
    /////
}
