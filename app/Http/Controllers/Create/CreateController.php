<?php

namespace App\Http\Controllers\Create;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Worker;
use App\Payment_method;
use App\Payment_type;
use App\Marketing_source;
use App\Transaction;
use App\Transaction_detalis;
use DB;
use Carbon\Carbon;

class CreateController extends Controller
{
    public $current_date; 
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createWorkerAction(Request $request)
    {
    	Worker::create(['first_name'=>$request->first_name, 'last_name'=>$request->last_name, 'working'=>true]);
    	Session::flash('message_success', $request->first_name.' '.$request->last_name. ' Worker Created!');
		return redirect('/create-worker');
    }

    public function createPaymentMethodAction(Request $request)
    {
        Payment_method::create(['title'=>$request->title]);
        Session::flash('message_success', $request->title. ' Payment Method Created!');
        return redirect('/create-payment-method');
    }

	public function createPaymentTypeAction(Request $request)
	{
		Payment_type::create(['title'=>$request->title]);
		Session::flash('message_success', $request->title. ' Payment Type Created!');
		return redirect('/create-payment-type');
	}

    public function createMarketingSourceAction(Request $request)
    {
        Marketing_source::create(['title'=>$request->title]);
        Session::flash('message_success', $request->title. ' Marketing Source Created!');
        return redirect('/create-marketing-source');
    }

    public function createTransactionAction(Request $request)
    {
        $this->current_date = Carbon::now()->toDateTimeString();
        $collected = 0;
        $scheduled_count = count($request->lead_date);
        
        $transaction_id = Transaction::create([
            'case_id'               =>  $request->case_id,
            'client_name'           =>  $request->client_name,
            'marketing_source_id'   =>  $request->marketing_source_id,
            'scheduled_count'       =>  $scheduled_count,
            'total_price'           =>  $request->total_price,
            'collected'             =>  $collected      
        ])->id;


        foreach($request->lead_date as $key => $item)
        {
            $lead_date = date("Y-m-d", strtotime($item));
            $payment_date = date("Y-m-d", strtotime($request->payment_date[$key]));
            if( isset($request->payed[$key]) && $request->payed[$key] == "on" ) $payed = 1;
            else $payed = 0;
            if($request->payment_method_id[$key] == 14){
	            if( isset($request->check_price[$key]) && $request->check_price[$key] != "" ){
		            $check_price = $request->check_price[$key];
		            if( isset($request->check[$key]) && $request->check[$key] == "on" ) $check = 1;
		            else $check = 0;
	            } else{
		            $check_price = null;
		            $check = null;
	            }
            }else{
	            $check_price = null;
               $check = null;
            }
            Transaction_detalis::create([
                'transaction_id'        =>  $transaction_id,
                'lead_date'             =>  $lead_date,
                'payment_date'          =>  $payment_date,
                'age'                   =>  $request->age[$key],
                'worker_id'             =>  $request->worker_id[$key],
                'payment_method_id'     =>  $request->payment_method_id[$key],
                'payment_type_id'       =>  $request->payment_type_id[$key],
                'check_price'           =>  $check_price,
                'check'                 =>  $check,
                'amounts_due'           =>  $request->amounts_due[$key],
                'payed'                 =>  $payed
            ]);
        }
        $amounts_total = 0;
        $checkCollected = Transaction::where('id',$transaction_id)->first();
        $trDCheck = Transaction_detalis::where('transaction_id',$transaction_id)->where('payed',1)->get();
        
        foreach($trDCheck as $key => $val){
            $amounts_total += $request->amounts_due[$key];
        }

	    if( $checkCollected['total_price'] == $amounts_total ){
		    Transaction::where('id',$transaction_id)->update(['collected'=>1]);
		    Session::flash('message_success', 'Collected');
	    }elseif( $checkCollected['total_price'] > $amounts_total ){
		    Transaction::where('id',$transaction_id)->update(['collected'=>0]);
		    Session::flash('message_error', 'Gross Sale > Amount Due');
	    }elseif( $checkCollected['total_price'] < $amounts_total ){
		    Transaction::where('id',$transaction_id)->update(['collected'=>0]);
		    Session::flash('message_error', 'Gross Sale < Amount Due');
	    }else{
		    Session::flash('message_error', 'Error!');
	    }return redirect('/manage-transaction/'.$transaction_id);
    }
}
