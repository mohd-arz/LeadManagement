<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Lead;
use App\Models\Duplicate;
use App\Models\User;

class CrudController extends Controller
{
    //Executive--

    //Adding LeadPage by Executive
    public function addLeadPage(){
        $categories = Category::all();
        return view('crud.add',compact('categories'));
    }

    //Adding Lead by Executive
    public function addLead(Request $request){
        $categories=Category::all();
        request()->validate([
            'name' => 'required',
            'category' => 'required',
            'remark' => 'required',
        ]);
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'phone_code' => $request->input('phone_code'),
            'category' => $request->input('category'),
            'remark' => $request->input('remark'),
            'user_id' => Auth::id(),
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

    //Editing LeadPage by Executive
    public function editLeadPage($id){
        $categories = Category::all();
        $lead=Lead::find($id);
        return view('crud.edit',compact('lead','categories'));
    }

    //Editing Lead by Executive
    public function editLead($id){
        request()->validate([
            'name' => 'required',
            'category' => 'required',
            'remark' => 'required',
        ]);
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
    public function deleteLead($id){
        $lead=Lead::find($id);
        $lead->delete();

        return redirect()->route('home')->with('message','Lead Deleted Successfully');
    }
    /*************************/

    //Admin

    //Setting Status of an Executive by Admin
    public function setStatus(Request $request){
        $status = $request->post('status');
        $id =  $request->post('id');
        $user = User::find($id);
        $user->update(['status'=>$status]);
    }
    
    //Go To LeadPage by Admin
    public function leadPage(){
        $categories = Category::all();
        $executives = User::whereNot('user_type','admin')->get();
        $leads=Lead::leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->get();
        return view('admin.leadsPage',compact('leads','categories','executives'));
    }

    //Adding LeadPage by Admin
    public function addLeadPageAdmin(){
        $categories = Category::all();
        $executives= User::where('user_type','!=','admin')->where('status','active')->get();
        return view('admin.add',compact('categories','executives'));
    }

    //Adding Lead by Admin
    public function addLeadAdmin(Request $request){
        request()->validate([
            'name' => 'required',
            'category' => 'required',
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

    //Editing LeadPage by Admin
    public function editLeadPageAdmin($id){
        $categories = Category::all();
        $executives= User::where('user_type','!=','admin')->where('status','active')->get();
        $lead=Lead::find($id);
        return view('admin.edit',compact('lead','categories','executives'));
    }

    //Editing Lead by Admin
    public function editLeadAdmin($id){
        request()->validate([
            'name' => 'required',
            'category' => 'required',
            'remark' => 'required',
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
        return redirect()->route('home')->with('message','Lead Edited Successfully');
    }
    public function executiveEdit($id){
        $executive = User::find($id);
        return view('admin.executiveedit',compact('executive'));
    }
    public function editExecutive($id){
        $executive = User::find($id);
        $executive->update([
            'name'=>request('name'),
            'email'=>request('email')
        ]);
        return redirect()->route('home')->with('message','User Updated Successfully');
    }

    /**********************************/

    //Duplication//

    //Adding Duplication Value
    public function addDuplicate(){
        $duplicate = Duplicate::all()->first();
        Lead::create([
            'name'=>$duplicate->name,
            'email'=>$duplicate->email,
            'phone_no'=>$duplicate->phone_no,
            'phone_code'=>$duplicate->phone_code,
            'category'=>$duplicate->category,
            'remark'=>$duplicate->remark,
            'user_id'=>Auth::id(),
        ]);
        
        Duplicate::all()->first()->delete();
        return redirect()->route('home')->with('message','Lead Added Successfully');
    }

    //When Reject to Add Duplication value 
    public function rejectDuplicate(){
        Duplicate::all()->first()->delete();
        return redirect()->route('home')->with('message','Duplication Rejected Successfully');
    }
    /**********************************/


    //Contact Type//
    public function setOption(Request $request){
        $option = $request->post('option');
        
    
        if($option=='phone') {
            $html ='<div class="form-group">
            <label for="phone_no" class="form-label">Phone No:
                <input type="phone_no" name="phone_no" class="form-control" required>
            </label>
        </div>
        
        <div class="form-group">
            <label for="phone_code" class="form-label">Phone Code:
                <input type="phone_code" name="phone_code" class="form-control" required>
            </label>
        </div>';
            }
            else {
                $html = '<div class="form-group">
                <label for="email" class="form-label">Email:
                    <input type="email" name="email" class="form-control" required>
                </label>
            </div>';
                }
        return $html;
    }
    /********************************/

    //Filters

    //Filter by Category--
    public function filterCategory(Request $request){
        $category = $request->post('filter');
        if($category=='all'){
            $leads = Lead::leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->get();
        }else{
       $leads = Lead::where('category',$category)->leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->get();
    }

       return view('admin.leads',compact('leads'));
    }

    //Filter by Executive--
    public function filterExecutive(Request $request){
        $executive = $request->post('filter');
        if($executive=='all'){
            $leads = Lead::leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->get();
        }else{
            $leads = Lead::where('user_id',$executive)->leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->get();
        }
       return view('admin.leads',compact('leads'));
    }

    //Filter by Higher--
    public function filterByHigher(Request $request){
        $leads = Lead::leftJoin('users','users.id','=','leads.user_id')->orderBy('leads.created_at', 'ASC')->select('leads.*','users.name as executive_name')->get();
        return view('admin.leads',compact('leads'));
    }

    //Filter by Lower--
    public function filterByLower(Request $request){
        // $leads = Lead::leftJoin('users','users.id','=','leads.user_id')->orderBy('leads.created_at', 'ASC')->select('leads.*','users.name as executive_name')->get();
        $leads = Lead::leftJoin('users', 'users.id', '=', 'leads.user_id')
        ->orderByRaw('UNIX_TIMESTAMP(leads.created_at) ASC')
        ->select('leads.*', 'users.name as executive_name')
        ->get();
    
        return view('admin.leads',compact('leads'));
    }
}
