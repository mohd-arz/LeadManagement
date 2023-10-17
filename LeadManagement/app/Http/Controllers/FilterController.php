<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class FilterController extends Controller
{
    //Filters

    //Filter by Category--
    public function filterCategory(Request $request){
        $category = $request->post('filter');
        if($category=='all'){
            $leads = Lead::leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->latest()->paginate(10);
        }else{
       $leads = Lead::where('category',$category)->leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->latest()->paginate(10);
    }

       return view('admin.leads',compact('leads'));
    }

    //Filter by Executive--
    public function filterExecutive(Request $request){
        $executive = $request->post('filter');
        if($executive=='all'){
            $leads = Lead::leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->latest()->paginate(10);
        }else{
            $leads = Lead::where('user_id',$executive)->leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->latest()->paginate(10);
        }
       return view('admin.leads',compact('leads'));
    }

    //Filter by Higher--
    public function filterByHigher(Request $request){
        $leads = Lead::leftJoin('users','users.id','=','leads.user_id')->orderByRaw('UNIX_TIMESTAMP(leads.created_at) DESC')->select('leads.*','users.name as executive_name')->latest()->paginate(10);
        return view('admin.leads',compact('leads'));
    }

    //Filter by Lower--
    public function filterByLower(Request $request){
        if($request->post('filter')=='all'){
            $leads = Lead::leftJoin('users','users.id','=','leads.user_id')->select('leads.*','users.name as executive_name')->latest()->paginate(10);
        }else{
            $leads = Lead::leftJoin('users', 'users.id', '=', 'leads.user_id')
            ->orderByRaw('UNIX_TIMESTAMP(leads.created_at) ASC')
            ->select('leads.*', 'users.name as executive_name')
            ->latest()->paginate(10);
        }
        return view('admin.leads',compact('leads'));

    }
}
