<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Storage;
use DateTime;
use DatePeriod;
use DateInterval;
use App\User;
use App\ScheduleHarvest;



class Plantation extends Model
{
    protected $guarded=[];

    public function new_plantation(array $validated)
    {
        $new_plant = new Plantation;
        $new_plant->species= $validated['species'];
        $new_plant->type_id= $validated['type_id'];
        // conversion is needed.. also must check if the total is more than the total size of farmers farm...
        $new_plant->size_of_plantation= $validated['size'];
        $new_plant->user_id=  auth()->user()->id;
        $new_plant->planting_date= $validated['planting_date'];
        // $new_plant->default Status is not ready for harvest
        $new_plant->status=0; 
        $new_plant->save();

    }
    #issue|recomendations| checker.. would use this object
    public function time_to_harvest()
    {   
        #find interval to the harvest period
        $time_interval = new DateInterval('P'.$this->plant_fact_sheet->months_to_maturity.'M'); #used the 'P' 'int' 'Abr' method
        $due =  date_add(date_create($this->planting_date),$time_interval);
        return now()->diff($due)->format('%R%a');

    }



    public function book_harvest()
    {
        $this->status= 1;# to be harvested
        $this->save();
        return $this->id;
    }
    public function harvest_plantation($request)
    {
        $plantation = $this->find($request->id);
        $plantation->status= 2;#harvested
        $plantation->size_of_plantation  = 0;#take  revoke the land it was under
        $plantation->save();
        return $plantation;
    }
    
    public function farmer(){
        return $this->belongsTo('App\User','user_id');
    }
    public function plant_fact_sheet(){
        return $this->belongsTo('App\Plant_fact_sheet','type_id');
    }
    public function storage()
    {
        return $this->hasOne('App\Storage','plantation_id');
    }
    public function schedule()
    {
        return $this->hasOne('App\ScheduledHarvest','plantation_id');
    }
}
