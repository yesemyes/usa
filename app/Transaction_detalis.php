<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction_detalis extends Model
{
	protected $table = "transaction_detalis";
    protected $fillable = [
    	'transaction_id',
    	'lead_date',
    	'payment_date',
    	'age',
    	'worker_id',
    	'payment_type_id',
    	'payment_method_id',
    	'check_price',
    	'check',
    	'amounts_due',
    	'payed',
    	'created_at',
    	'updated_at'
    ];
}
