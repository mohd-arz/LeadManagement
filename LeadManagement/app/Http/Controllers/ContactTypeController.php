<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    //Contact Type//
    public function setOption(Request $request){
        $option = $request->post('option');
        
        //if the recieved value is phone then return two inputs for both number and code
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
            //else email
            else {
                $html = '<div class="form-group">
                <label for="email" class="form-label">Email:
                    <input type="email" name="email" class="form-control" required>
                </label>
                </div>';
            }
        return $html;
    }
}
