<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProfEnrols;
use App\Http\Requests\SuppliersEnrol;
use App\Http\Requests\FarmersRequest;

use  App\Mail\RejectMail;

use App\Proffesional;
use App\Supplier;
use App\Farmer;
use App\Http\Requests\CustomerStore;

class EnrolmentController extends Controller
{
    //
    public function profesionals_enrole(StoreProfEnrols $request,Proffesional $prof)
    {
        $validated = $request->validated();
        $prof->new_enrolement($validated);

        return 'success';

    }
    public function suppliers_enrole(SuppliersEnrol $request , Supplier $sup )
    {
        $validated = $request->validated();
        // return ($validated['kra']);
        // return $request;
        
        $sup->new_enrolement($validated);

        return 'Sucess!' ;

    }
    public function farmers_enrole(FarmersRequest $request ,Farmer $farmer )
    {
        $validated = $request->validated();
        $farmer->new_enrolement($validated);
        return redirect('login')->with('info','Enter You login Details');
    }
    public function customer_enrole(CustomerStore $request ,Customer $customer )
    {
        // return $request->all();
        $validated = $request->validated();
        $customer->new_enrolement($validated);
        return 'Sucess!';
    }
    #this is the route for acoount confirmation
    public function confirmation($request,Proffesional $proffesional)
    {
        $proffesional->confirm($request->id);        
    }
    #path for account rejection
    public function rejection($request,Proffesional $proffesional)
    {
        $proffesional->reject($request->id);        
    }
    
}
