<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Lead;
use App\Models\Duplicate;
use App\Models\User;

class ExecutiveController extends Controller
{
    //Executive//

    //Adding LeadPage by Executive-------------
    public function addLeadPage(){

        //Getting All Categories from catergories table
        $categories = Category::all();
        return view('crud.add',compact('categories'));
    }
    ////
    //Adding Lead by Executive---------------
    public function addLead(Request $request){

        //Getting All Categories from catergories table
        $categories=Category::all();

        //Added Basic Validation
        request()->validate([
            'name' => 'required',
            'contact_option'=>'required',
            'category' => 'required',
            'remark' => 'required',
        ]);

        //Stores every data into an Array 
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'phone_code' => $request->input('phone_code'),
            'category' => $request->input('category'),
            'remark' => $request->input('remark'),
            'user_id' => Auth::id(),
        ];

        //Checks if the phone_no field is not null
        if($request->input('phone_no')!=null ){

            //then get the value by where eloquent
            $leads = Lead::where('phone_no',$request->input('phone_no'))->where('phone_code',$request->input('phone_code'))->get();

            //if it's not empty then it means, it's already existing
            if($leads -> isNotEmpty()){

                //Creating a value at duplicates table
                Duplicate::create($data);
                $leads=Lead::where('leads.phone_no',$request->input('phone_no'))->where('leads.phone_code',$request->input('phone_code'))->leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->latest()->paginate(10);
                return view('duplicate',compact('leads'));
            }
        //Same for if the email field is not null
        }else if($request->input('email')!=null){
            $leads = Lead::where('email',$request->input('email'))->get();
            if($leads -> isNotEmpty()){
                Duplicate::create($data);
                $leads=Lead::where('leads.email',$request->input('email'))->leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->latest()->paginate(10);
                return view('duplicate',compact('leads'));
            }
        }
        //If everythings okay (Values are unique then) Create value into leads table
        Lead::create($data);
        return redirect()->route('home')->with('message','Lead Added Successfully'); 
    }
    ////

    

    //Editing LeadPage by Executive---------------
    public function editLeadPage($id){
        $categories = Category::all();
        $lead=Lead::find($id);
        return view('crud.edit',compact('lead','categories'));
    }
    ////


    //Editing Lead by Executive------------------
    public function editLead($id){

        //basic validations
        request()->validate([
            'name' => 'required',
            'category' => 'required',
            'remark' => 'required',
            'email' => 'sometimes|required_without:phone_no',
            'phone_no' => 'sometimes|required_without:email',
            'phone_code' => 'required_with:phone_no'
        ]);

        //Getting an appropiate lead and updating it
        $lead=Lead::find($id);
        $lead->update([
            'name'=>request('name'),
            'email'=>request('email'),
            'phone_no'=>request('phone_no'),
            'phone_code'=>request('phone_code'),
            'category'=>request('category'),
            'remark'=>request('remark'),
        ]);
        return redirect()->route('home')->with('message','Lead Edited Successfully');
    }
    ////

    //deleting a Lead-----(both executive and admin)
    public function deleteLead($id){
        $lead=Lead::find($id);
        $lead->delete();

        return redirect()->route('home')->with('message','Lead Deleted Successfully');
    }
    ////
}
