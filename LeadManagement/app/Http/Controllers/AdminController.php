<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Lead;
use App\Models\User;

// 
use Illuminate\Support\Facades\DB;


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
        $category = $request->input('category');
        $executive = $request->input('executive');
        $date_filter=$request->input('date_filter');
        $date_range=$request->input('date_range');
       
        $categories = Category::all();
        $executives = User::whereNot('user_type','admin')->get();


        $leads = Lead::leftJoin('users', 'users.id', '=', 'leads.user_id')
        ->select('leads.*', 'users.name as executive_name','users.status as user_status')
        ->when($category != null, function ($q) use ($category) {
            return $q->where('category', $category);
        })
        ->when($executive != null, function ($q) use ($executive) {
            return $q->where('users.id', $executive);
        })
        ->when($date_range != null && $date_range != 'custom', function($q) use($date_range){
            $today = now()->format('Y-m-d');
            if($date_range=='today'){
                return $q->whereDate('leads.created_at',$today);
            }
            if($date_range=='last_three_days'){
                $threeDays=now()->subDays(3)->format('Y-m-d');
                return $q->whereBetween(DB::raw('DATE(leads.created_at)'), [$threeDays, $today]);
            }else if($date_range=='last_week'){
                $sevenDays=now()->subDays(7)->format('Y-m-d');
                return $q->whereBetween(DB::raw('DATE(leads.created_at)'), [$sevenDays, $today]);
            }else if($date_range=='last_month'){
                $lastMonth = now()->subMonth()->format('Y-m-d');
                return $q->whereBetween(DB::raw('DATE(leads.created_at)'),[$lastMonth,$today]);
            }
        })
        ->when($date_filter != null, function($q) use($date_filter){
            return $q->orWhereDate('leads.created_at',$date_filter);
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
            'email' => 'sometimes|required_without:phone_no',
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
