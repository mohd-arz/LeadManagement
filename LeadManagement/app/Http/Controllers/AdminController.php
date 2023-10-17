<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Lead;
use App\Models\User;

class AdminController extends Controller
{
    //Admin

    //Setting Status of an Executive by Admin (Ajax)
    public function setStatus(Request $request){
        $status = $request->post('status');
        $id =  $request->post('id');
        $user = User::find($id);
        $user->update(['status'=>$status]);
    }
    /////
    
    //Go To LeadPage by Admin
    public function leadPage(Request $request){
        // $categories = Category::all();

        // //getting every executives except admin
        // $executives = User::whereNot('user_type','admin')->get();

        // //Implemented leftJoin with users table to get users_name as executive_name
        // $leads=Lead::leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->latest()->paginate(10);

        $category = $request->input('category');
        $executive = $request->input('executive');
        $date = $request->input('date');
        

        $categories = Category::all();
        $executives = User::whereNot('user_type','admin')->get();

    
        $leads = Lead::leftJoin('users', 'users.id', '=', 'leads.user_id')
        ->select('leads.*', 'users.name as executive_name')
        ->when($category != null, function ($q) use ($category) {
            return $q->where('category', $category);
        })
        ->when($executive != null, function ($q) use ($executive) {
            return $q->where('users.id', $executive);
        })
        ->when($date == 'higher', function ($q){
            return $q->orderByRaw('UNIX_TIMESTAMP(leads.created_at) DESC');
        })
        ->when($date == 'lower', function ($q) {
            return $q->orderByRaw('UNIX_TIMESTAMP(leads.created_at) ASC');
        })
        ->latest()
        ->paginate(10);


        return view('admin.leadsPage',compact('leads','categories','executives'));
    }
    /////

    //Adding LeadPage by Admin
    public function addLeadPageAdmin(){
        $categories = Category::all();
        $executives= User::where('user_type','!=','admin')->where('status','active')->get();
        return view('admin.add',compact('categories','executives'));
    }
    /////

    //Adding Lead by Admin (Same as AddingLead by executives)
    public function addLeadAdmin(Request $request){
        request()->validate([
            'name' => 'required',
            'contact_option'=>'required',
            'category' => 'required',
            'executive'=>'required',
            'remark' => 'required',
        ]);
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'phone_code' => $request->input('phone_code'),
            'category' => $request->input('category'),
            'remark' => $request->input('remark'),
            'user_id' => $request->input('executive'),
        ];
        if($request->input('phone_no')!=null ){
            $leads = Lead::where('phone_no',$request->input('phone_no'))->where('phone_code',$request->input('phone_code'))->get();
            if($leads -> isNotEmpty()){
                Duplicate::create($data);
                $leads=Lead::where('leads.phone_no',$request->input('phone_no'))->where('leads.phone_code',$request->input('phone_code'))->leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->get();
                return view('duplicate',compact('leads'));
            }
        }else if($request->input('email')!=null){
            $leads = Lead::where('email',$request->input('email'))->get();
            if($leads -> isNotEmpty()){
                Duplicate::create($data);
                $leads=Lead::where('leads.email',$request->input('email'))->leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->get();
                return view('duplicate',compact('leads'));
            }
        }
        Lead::create($data);
        return redirect()->route('home')->with('message','Lead Added Successfully'); 
    }
    /////

    //Editing LeadPage by Admin
    public function editLeadPageAdmin($id){
        $categories = Category::all();
        $executives= User::where('user_type','!=','admin')->where('status','active')->get();
        $lead=Lead::find($id);
        return view('admin.edit',compact('lead','categories','executives'));
    }
    /////

    //Editing Lead by Admin
    public function editLeadAdmin($id){
        request()->validate([
            'name' => 'required',
            'category' => 'required',
            'executive'=>'required',
            'remark' => 'required',
            'email' => 'sometimes|required_without:phone_no|email',
            'phone_no' => 'sometimes|required_without:email',
            'phone_code' => 'required_with:phone_no'
        ]);
        $lead=Lead::find($id);
        $lead->update([
            'name'=>request('name'),
            'email'=>request('email'),
            'phone_no'=>request('phone_no'),
            'phone_code'=>request('phone_code'),
            'category'=>request('category'),
            'remark'=>request('remark'),
            'user_id'=>request('executive'),
        ]);
        return redirect()->route('leadPage')->with('message','Lead Edited Successfully');
    }
    /////

    //Editing the executive Page for Admin
    public function executiveEdit($id){
        $executive = User::find($id);
        return view('admin.executiveedit',compact('executive'));
    }
    /////

    //Editing the executive by admin
    public function editExecutive($id){
        $executive = User::find($id);
        $executive->update([
            'name'=>request('name'),
            'email'=>request('email')
        ]);
        return redirect()->route('home')->with('message','User Updated Successfully');
    }
    /////
}
