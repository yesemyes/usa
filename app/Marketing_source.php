<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketing_source extends Model
{
	protected $table = "marketing_sources";

    protected $fillable = ['title','created_at','updated_at'];

    /*public function transaction()
    {
        return $this->belongsTo('App\Transaction','id'); // links this->course_id to courses.id
    }*/
}
