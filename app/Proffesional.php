<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;


class Proffesional extends Model
{
    public  function new_enrolement(array $validated)
    {


        $prof = new Proffesional;
        $prof->id_number = $validated['id_number'];
        $prof->name = $validated['name'];
        $prof->email= $validated['email'];
        $prof->location= $validated['location'];
        #status will be zero since he or she has not been vetted and given an account
        $prof->status=0;
        $prof->phone= $validated['phone_number'];
        #since the one being registerd has never been rated before...
        $prof->ratings= 0;
        $prof->specialty = $validated['specialty'];
        $prof->exp=$validated['exp'];
        $prof->save();
    }
    public function pending_requests()
    {
        return DB::table('proffesionals')
                    ->where('status','=',0)
                    ->get();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function pregnant()
    {
        return $this->hasMany('App\Pregnant');
    }
}
