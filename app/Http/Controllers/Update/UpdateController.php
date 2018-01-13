<?php

namespace App\Http\Controllers\Update;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Worker;
use App\Payment_method;
use App\Payment_type;
use App\Marketing_source;
use App\Transaction;
use App\Transaction_detalis;

class UpdateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function worker($id, Request $request)
    {
        if( $request->working == "on" ) $working = 1;
        else $working = 0;
    	$updWorker = Worker::where('id',$id)->where('id','<>','1')->update([
            'first_name'=>$request->first_name,
            'last_name' =>$request->last_name,
            'working'   =>$working
        ]);
    	if($updWorker == 1){
    		Session::flash('message_success', $request->first_name.' '.$request->last_name.' information updated');
			return redirect('/workers');
    	}else{
    		Session::flash('message_error', 'Error!');
			return redirect('/workers');
    	}
    }

    /*public function paymentMethod(Request $request)
    {
        if ( isset($request->change) && $request->change == "update" ) {
            $updPayment_method = Payment_method::where('id',$request->id)->update(['title'=>$request->title]);
            if($updPayment_method == 1){
                Session::flash('message_success', $request->title.' Updated');
                return redirect('/payment-methods');
            }else{
                Session::flash('message_error', $request->title.' NOT UPDATED! Please choose Payment Method');
                return redirect('/payment-methods');
            }    
        }elseif ( isset($request->destroy) && $request->destroy == "delete" ) {
            $delPayment_method = Payment_method::where('id',$request->id)->where('title',$request->title)->delete();
            if($delPayment_method == 1){
                Session::flash('message_success', $request->title.' deleted');
                return redirect('/payment-methods');
            }else{
                Session::flash('message_error', $request->title.' NOT DELETED!, Please select Payment Method and write its name');
                return redirect('/payment-methods');
            }
        } 
    }*/

	/*public function paymentType(Request $request)
	{
		if ( isset($request->change) && $request->change == "update" ) {
			$updPayment_type = Payment_type::where('id',$request->id)->update(['title'=>$request->title]);
			if($updPayment_type == 1){
				Session::flash('message_success', $request->title.' Updated');
				return redirect('/payment-types');
			}else{
				Session::flash('message_error', $request->title.' NOT UPDATED! Please choose Payment Type');
				return redirect('/payment-types');
			}
		}
	}*/

    public function marketingSource(Request $request)
    {
        if ( isset($request->change) && $request->change == "update" ) {
            $updMarketing_sources = Marketing_source::where('id',$request->id)->update(['title'=>$request->title]);
            if($updMarketing_sources == 1){
                Session::flash('message_success', $request->title.' Updated');
                return redirect('/marketing-sources');
            }else{
                Session::flash('message_error', $request->title.' NOT UPDATED! Please choose Marketing Source');
                return redirect('/marketing-sources');
            }    
        }elseif ( isset($request->destroy) && $request->destroy == "delete" ) {
            $delMarketing_sources = Marketing_source::where('id',$request->id)->where('title',$request->title)->delete();
            if($delMarketing_sources == 1){
                Session::flash('message_success', $request->title.' Marketing Source deleted');
                return redirect('/marketing-sources');
            }else{
                Session::flash('message_error', $request->title.' NOT DELETED!, Please select Marketing Source and write its name');
                return redirect('/marketing-sources');
            }
        }
    }

    public function transaction($id, Request $request)
    {
        $scheduled_count = count($request->lead_date);
        $updTransaction = Transaction::where('id',$id)
                            ->update([
                                'case_id'               =>  $request->case_id,
                                'client_name'           =>  $request->client_name,
                                'marketing_source_id'   =>  $request->marketing_source_id,
                                'scheduled_count'       =>  $scheduled_count,
                                'total_price'           =>  $request->total_price
                            ]);

        foreach($request->tID as $key => $item)
        {
            $lead_date = date("Y-m-d", strtotime($request->lead_date[$key]));
            $payment_date = date("Y-m-d", strtotime($request->payment_date[$key]));
            if( isset($request->payed[$item]) && $request->payed[$item] == "on" ) $payed = 1;
            else $payed = 0;
				if($request->payment_method_id[$key] == 14)
				{
				   if( isset($request->check_price[$key]) && $request->check_price[$key] != "" )
					  $check_price = $request->check_price[ $key ];
				   else $check_price = null;
					if( isset($request->check[$item]) && $request->check[$item] == "on" ) $check = 1;
					else $check = 0;
				}
				else{
				  $check_price = null;
				  $check = null;
				}

            if( isset($item) && $item != 0 ){
                $updTransaction_detalis = Transaction_detalis::where('id',$request->tID[$key])->update([
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
            else{
                Transaction_detalis::create([
                    'transaction_id'        =>  $id,
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
            
        }
        //dd('ok');
        $amounts_total = 0;
        $checkCollected = Transaction::where('id',$id)->first();
        $trDCheck = Transaction_detalis::where('transaction_id',$id)->where('payed',1)->get();
        
        foreach($trDCheck as $key => $val){
            $amounts_total += $request->amounts_due[$key];
        }

        if( $checkCollected['total_price'] == $amounts_total ){
            Transaction::where('id',$id)->update(['collected'=>1]);
            Session::flash('message_success', 'Collected');
        }elseif( $checkCollected['total_price'] > $amounts_total ){
            Transaction::where('id',$id)->update(['collected'=>0]);
	        Session::flash('message_error', 'Gross Sale > Amount Due');
        }elseif( $checkCollected['total_price'] < $amounts_total ){
	        Transaction::where('id',$id)->update(['collected'=>0]);
	        Session::flash('message_error', 'Gross Sale < Amount Due');
        }else{
	        Session::flash('message_error', 'Error!');
        }return redirect()->back();
    }
}
