<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\H_SchedulerRequest;
use App\Http\Requests\StorageRequest;


use App\Storage;
use App\Plantation;
use App\Isues;
use App\ScheduleHarvest;

class StorageController extends Controller
{   #h_scheduler is the class resposnible for handling  requests to schedule harests
    public function schedule_harvest(H_SchedulerRequest $request, Isues $isue,Plantation $plant)
    {
        dd($request);
        $transporter = User::get_transporter();
        $produce =  $plant->find($request->id)->book_harvest();
        $isue->alert_transporter($transporter);
        return $produce;


    }
    public function harvest(StorageRequest $request,Storage $store,Plantation $plantation)
    {
        // return $request->id;
        $x= $plantation->harvest_plantation($request);
        // return $x;
        $store->store($request);
        return redirect('plant')->with('message','Stored Succesfully');

    }
    public function sell_from_storage( Request $request,Storage $store)
    {
        // return $request;
        # get the good from storage
        $store->decrement_sacks($request);
        $store->sell_crop_produce($request);
        #decrement the amount of sacks the user entered
        #post it
        return redirect()->route('storage');
    }
    public function take_from_storage(Request $request,Storage $store)
    {
        // return $request;
        $store->decrement_sacks($request);
        return redirect()->route('storage');
    }
    public function all_items()
    {
        $user_items = auth()->user()->stored_products->filter(function($stored){ return $stored->sacks > 0 ;});
        return view('storage.index')->with('user_items',$user_items);
    }

}
