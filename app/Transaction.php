<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Transaction extends Model
{
    protected $table = "transactions";

    protected $fillable = [
    	'case_id',
    	'client_name',
    	'marketing_source_id',
    	'scheduled_count',
    	'total_price',
    	'collected',
    	'created_at',
    	'updated_at'
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('F/d/Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('F/d/Y');
    }

    /*public function transactions()
    {
        return $this->hasMany('App\Transaction_detalis','transaction_id');
    }

    public function marketing()
    {
        return Marketing_source::where('id',$this->marketing_source_id)->first();
    }*/

    /*public function marketing()
    {
        return $this->hasOne('App\Marketing_source','marketing_source_id'); // links this->id to events.course_id
    }*/

    
}