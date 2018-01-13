<?php

namespace App\Http\Controllers\Show;

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

class ShowController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function checkCase(Request $request)
	{
		$checkCaseId = Transaction::select('id')
		                          ->where('case_id',$request->case_id)
		                          ->where('client_name','<>',$request->client_name)
		                          ->first();
		if( isset($checkCaseId['exists']) && $checkCaseId['exists']==1 ){
			echo 'exists';
		}else{
			echo 'novu';
		}
	}

	public function workers()
	{
		$workers = Worker::where('id','<>','1')->orderBy('first_name','asc')->get();
		if( count($workers) == 0 ) return redirect('/create-worker');
		else return view('show.workers', ['workers'=>$workers]);
	}

	public function worker($id)
	{
		$worker = Worker::where('id',$id)->where('id','<>','1')->first();
		if($worker!=null) return view('show.worker', ['worker'=>$worker]);
		else return redirect('/workers');
	}

	public function paymentMethod()
	{
		$payment_methods = Payment_method::where('id','<>',14)->orderBy('title','asc')->get();
		if( count($payment_methods) == 0 ) return redirect('/payment-method');
		else return view('show.payment-methods', ['payment_methods'=>$payment_methods]);
	}

	public function paymentType()
	{
		$payment_types = Payment_type::orderBy('title','asc')->get();
		if( count($payment_types) == 0 ) return redirect('/payment-type');
		else return view('show.payment-types', ['payment_types'=>$payment_types]);
	}

	public function marketingSource()
	{
		$marketing_sources = Marketing_source::orderBy('title','asc')->get();
		if( count($marketing_sources) == 0 ) return redirect('/marketing-source');
		else return view('show.marketing-sources', ['marketing_sources'=>$marketing_sources]);
	}

	public function createTransaction()
	{
		$marketing_sources  = Marketing_source::orderBy('title','asc')->get();
		$payment_methods    = Payment_method::orderBy('title','asc')->get();
		$payment_types      = Payment_type::orderBy('title','asc')->get();
		$workers            = Worker::orderBy('first_name','asc')->get();
		return view('create.transaction', compact('marketing_sources','payment_methods','payment_types','workers'));
	}

	public function transactions()
	{
		$transactions = Transaction::select('transactions.*','marketing_sources.title')
		                           ->leftJoin('marketing_sources','marketing_sources.id','=','transactions.marketing_source_id')
		                           ->orderBy('collected','desc')
		                           ->orderBy('id','desc')
		                           ->paginate(10);
		if( count($transactions) == 0 ) return redirect('create-transaction');
		return view('show.transactions',['transactions'=>$transactions]);
	}

	public function transaction($id)
	{
		$workers           = Worker::get();
		$marketing_sources = Marketing_source::orderBy('title','asc')->get();
		$payment_methods   = Payment_method::get();
		$payment_types     = Payment_type::get();
		$transaction       = Transaction::where('id',$id)->first();
		if(isset($transaction)&&$transaction!=null){
			if($transaction->collected == 1) Session::flash('message_success', $transaction->id.' Collected');
			$detalis = Transaction_detalis::select('transaction_detalis.*','transaction_detalis.id as tID','workers.*','payment_methods.title','payment_types.title')
			                              ->leftJoin('workers', 'workers.id', '=', 'transaction_detalis.worker_id')
			                              ->leftJoin('payment_methods', 'payment_methods.id', '=', 'transaction_detalis.payment_method_id')
			                              ->leftJoin('payment_types', 'payment_types.id', '=', 'transaction_detalis.payment_type_id')
			                              ->where('transaction_detalis.transaction_id',$id)->orderBy('transaction_detalis.id','asc')->get();
			$lead_date = [];
			$payment_date = [];
			$amounts_sum = [];
			$amounts_due = 0;
			foreach($detalis as $item){
				$leadDate = date("m-d-Y", strtotime($item->lead_date));
				$paymentDate = date("m-d-Y", strtotime($item->payment_date));
				array_push($lead_date, $leadDate);
				array_push($payment_date, $paymentDate);
				$amounts_due += $item->amounts_due;
				array_push($amounts_sum, $amounts_due);
			}
			return view('show.transaction', compact('transaction','detalis','workers','marketing_sources','payment_methods','payment_types','lead_date','payment_date','amounts_due'));
		}else{
			return redirect('/transactions');
		}
	}

	public function search(Request $request)
	{
		$marketing_sources  = Marketing_source::orderBy('title','asc')->get();
		$payment_methods    = Payment_method::orderBy('title','asc')->get();
		$payment_types      = Payment_type::orderBy('title','asc')->get();
		$workers            = Worker::orderBy('first_name','asc')->get();
		if( isset($request->collected) && $request->collected == "on" ) $collected = "checked";
		else $collected = null;
		if( isset($request->case_id) ) $case_id = $request->case_id;
		else $case_id = null;
		if( isset($request->client_name) ) $client_name = $request->client_name;
		else $client_name = null;
		if( isset($request->marketing_source_id) ) $marketing_source_id = $request->marketing_source_id;
		else $marketing_source_id = null;
		if( isset($request->amount_due) ) $amount_due = $request->amount_due;
		else $amount_due = null;
		if( isset($request->total_price) ) $total_price = $request->total_price;
		else $total_price = null;
		if( isset($request->start_date) ) $start_date = $request->start_date;
		else $start_date = null;
		if( isset($request->end_date) ) $end_date = $request->end_date;
		else $end_date = null;
		if( isset($request->age) ) $age = $request->age;
		else $age = null;
		if( isset($request->payment_method_id) ) $payment_method_id = $request->payment_method_id;
		else $payment_method_id = null;
		if( isset($request->payment_type_id) ) $payment_type_id = $request->payment_type_id;
		else $payment_type_id = null;
		if( isset($request->worker_id) ) $worker_id = $request->worker_id;
		else $worker_id = null;
		$results = null;

		if( $collected!=null || $case_id!=null || $client_name!=null || $marketing_source_id!=null || $amount_due!=null || $total_price!=null || $start_date!=null || $end_date!=null || $payment_method_id!=null || $payment_type_id!=null || $worker_id!=null )
		{
			$start = date("Y-m-d", strtotime($start_date));
			$end = date("Y-m-d", strtotime($end_date));
			$query = Transaction::select(
											'transactions.*','transaction_detalis.*',
											'marketing_sources.title as msTitle','marketing_sources.id as m_id',
											'payment_methods.title as pmTitle','payment_methods.id as p_id',
											'payment_types.title as ptTitle','payment_types.id as pt_id',
											'workers.first_name','workers.last_name','workers.id as w_id')
			                    ->where('transactions.id','<>',0)
			                    ->leftJoin('transaction_detalis','transaction_detalis.transaction_id','=','transactions.id')
			                    ->leftJoin('marketing_sources','marketing_sources.id','=','transactions.marketing_source_id')
			                    ->leftJoin('payment_methods','payment_methods.id','=','transaction_detalis.payment_method_id')
			                    ->leftJoin('payment_types','payment_types.id','=','transaction_detalis.payment_type_id')
			                    ->leftJoin('workers','workers.id','=','transaction_detalis.worker_id');

			if($collected!=null)            $query->where('transaction_detalis.payed',1);
			if($case_id!=null)              $query->where('transactions.case_id',$case_id);
			if($client_name!=null)          $query->where('transactions.client_name',$client_name);
			if($marketing_source_id!=null)  $query->where('transactions.marketing_source_id',$marketing_source_id);
			if($total_price!=null)          $query->where('transactions.total_price',$total_price);
			if($amount_due!=null)           $query->where('transaction_detalis.amounts_due',$amount_due);
			if($start_date!=null)           $query->whereDate('transaction_detalis.payment_date','>=',$start);
			if($end_date!=null)             $query->whereDate('transaction_detalis.payment_date','<=',$end);
			if($payment_method_id!=null)    $query->where('transaction_detalis.payment_method_id',$payment_method_id);
			if($payment_type_id!=null)      $query->where('transaction_detalis.payment_type_id',$payment_type_id);
			if($worker_id!=null)            $query->where('transaction_detalis.worker_id',$worker_id);

			$results = $query->groupBy('transactions.id')->paginate(10)->setPath ('');

			$pagination = $results->appends ( request()->query->all() );
			$t_results = [];
			$td_results = [];
			foreach($results as $key => $val)
			{
				$transaction = Transaction::select('transactions.*','marketing_sources.title as mTitle')
				                          ->leftJoin('marketing_sources','marketing_sources.id','=','transactions.marketing_source_id')
				                          ->where('transactions.id',$val->transaction_id)
				                          ->first();

				$detalis = Transaction_detalis::select('transaction_detalis.*','workers.first_name','workers.last_name','payment_methods.title','payment_types.title as ptTitle')
				                              ->leftJoin('workers', 'workers.id', '=', 'transaction_detalis.worker_id')
				                              ->leftJoin('payment_methods', 'payment_methods.id', '=', 'transaction_detalis.payment_method_id')
				                              ->leftJoin('payment_types', 'payment_types.id', '=', 'transaction_detalis.payment_type_id')
														->where('transaction_detalis.transaction_id',$val->transaction_id);
				if($collected!=null)          $detalis->where('transaction_detalis.payed',1);
				if($amount_due!=null)         $detalis->where('transaction_detalis.amounts_due',$amount_due);
				if($start_date!=null)         $detalis->whereDate('transaction_detalis.payment_date','>=',$start);
				if($end_date!=null)           $detalis->whereDate('transaction_detalis.payment_date','<=',$end);
				if($payment_method_id!=null)  $detalis->where('transaction_detalis.payment_method_id',$payment_method_id);
				if($payment_type_id!=null)    $detalis->where('transaction_detalis.payment_type_id',$payment_type_id);
				if($worker_id!=null)          $detalis->where('transaction_detalis.worker_id',$worker_id);

				$tr_detalis = $detalis->get();
				array_push($t_results, $transaction);
				array_push($td_results, $tr_detalis);
			}
		}

		if( isset($request->exel) )
		{
			$t_results = [];
			$td_results = [];
			foreach($request->id as $item)
			{
				$transaction = Transaction::select('transactions.*','marketing_sources.title as mTitle')
				                          ->leftJoin('marketing_sources','marketing_sources.id','=','transactions.marketing_source_id')
				                          ->where('transactions.id',$item)->first();
				$detalis = Transaction_detalis::select('transaction_detalis.*','workers.first_name','workers.last_name','payment_methods.title','payment_types.title as ptTitle')
				                              ->leftJoin('workers', 'workers.id', '=', 'transaction_detalis.worker_id')
				                              ->leftJoin('payment_methods', 'payment_methods.id', '=', 'transaction_detalis.payment_method_id')
				                              ->leftJoin('payment_types', 'payment_types.id', '=', 'transaction_detalis.payment_type_id')
				                              ->where('transaction_detalis.transaction_id',$item)->get();
				array_push($t_results, $transaction);
				array_push($td_results, $detalis);
			}
			header("Content-Type: application/xls");
			header("Content-Disposition: attachment; filename=download.xls");
			return view('create.search-report', compact('t_results', 'td_results'));
		}
		return view('show.search', compact(
				'marketing_sources', 'payment_methods', 'payment_types', 'workers',
				'new_deal', 'collected', 'case_id', 'client_name', 'marketing_source_id', 'amount_due','total_price',
				'start_date', 'end_date', 'age', 'payment_method_id', 'payment_type_id', 'worker_id', 'results', 't_results', 'td_results'
			)
		);
	}

	public function getWorkingDays($startDate,$endDate){
		$endDate = strtotime($endDate);
		$startDate = strtotime($startDate);
		$days = ($endDate - $startDate) / 86400 + 1;

		$no_full_weeks = floor($days / 7);
		$no_remaining_days = fmod($days, 7);

		$the_first_day_of_week = date("N", $startDate);
		$the_last_day_of_week = date("N", $endDate);

		if ($the_first_day_of_week <= $the_last_day_of_week) {
			if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
			if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
		}
		else {
			if ($the_first_day_of_week == 7) {
				$no_remaining_days--;

				if ($the_last_day_of_week == 6) {
					$no_remaining_days--;
				}
			}
			else {
				$no_remaining_days -= 2;
			}
		}

		$workingDays = $no_full_weeks * 5;
		if ($no_remaining_days > 0 )
		{
			$workingDays += $no_remaining_days;
		}

		/*foreach($holidays as $holiday){
			$time_stamp=strtotime($holiday);
			//If the holiday doesn't fall in weekend
			if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
				$workingDays--;
		}*/

		return $workingDays;
	}

	public function report(Request $request)
	{
		$now = date('m/d/Y');
		if( isset($request->start_date) && $request->start_date!=null ) $start_date = $request->start_date;
		else $start_date = $now;
		if( isset($request->end_date) && $request->end_date!=null ) $end_date = $request->end_date;
		else $end_date = $now;

		$workingDays = self::getWorkingDays($start_date, $end_date);
		$results = null;
		if( $start_date != null )
		{
			$start = date("Y-m-d",strtotime($start_date));
			$end = date("Y-m-d", strtotime($end_date));

			// success
			$result_payment_method = Transaction_detalis::select(DB::raw("SUM(amounts_due) as amounts_due"), 'payment_methods.title as pmTitle')
			                                            ->leftJoin('payment_methods','payment_methods.id','=','transaction_detalis.payment_method_id')
			                                            ->where('payed',1)
			                                            ->whereDate('payment_date','>=',$start)
			                                            ->whereDate('payment_date','<=',$end)
			                                            ->groupby('payment_method_id')->get();
			// success
			$result_payment_type = Transaction_detalis::select(DB::raw("SUM(amounts_due) as amounts_due"), 'payment_types.title as ptTitle')
			                                          ->leftJoin('payment_types','payment_types.id','=','transaction_detalis.payment_type_id')
			                                          ->where('payed',1)
			                                          ->whereDate('payment_date','>=',$start)
			                                          ->whereDate('payment_date','<=',$end)
			                                          ->groupby('payment_type_id')->get();
			// success
			$result_marketing = Transaction_detalis::select(DB::raw("SUM(amounts_due) as amounts_due"), 'marketing_sources.title as msTitle')
			                                       ->leftJoin('transactions','transactions.id','=','transaction_detalis.transaction_id')
			                                       ->leftJoin('marketing_sources','transactions.marketing_source_id','=','marketing_sources.id')
			                                       ->where('payed',1)
			                                       ->whereDate('payment_date','>=',$start)
			                                       ->whereDate('payment_date','<=',$end)
			                                       ->groupby('transactions.marketing_source_id')->get();
			// success
			$total_amout = Transaction_detalis::select(DB::raw("SUM(amounts_due) as amounts_due"))
			                                  ->where('payed',1)
			                                  ->whereDate('payment_date','>=',$start)
			                                  ->whereDate('payment_date','<=',$end)
			                                  ->get();
			// success
			$result_worker = Transaction_detalis::select(DB::raw("SUM(amounts_due) as amounts_due"),
																					'workers.id as w_id',
																					'first_name', 'last_name',
																					'transaction_detalis.id as td_id')
			                                    ->leftJoin('workers','workers.id','=','transaction_detalis.worker_id')
			                                    ->where('payed',1)
			                                    ->whereDate('payment_date','>=',$start)
			                                    ->whereDate('payment_date','<=',$end)
			                                    ->groupby('worker_id')
			                                    ->orderBy('worker_id','asc')
			                                    ->get();


			$new_bissness_new_deal = Transaction_detalis::select('amounts_due','payment_type_id',
																					'worker_id','transaction_id','payment_date')
			                           ->where('payed',1)
			                           ->where(function ($query) {
				                           $query->orWhere('payment_type_id', 1)
				                                 ->orWhere('payment_type_id', 4)
				                                 ->orWhere('payment_type_id', 6);
			                           })
												->whereDate('payment_date','>=',$start)
												->whereDate('payment_date','<=',$end)
			                           //->groupBy('worker_id')
			                           ->orderBy('worker_id','asc')
			                           ->get();

			$a = 0;
			$b = 0;
			$ab = 0;
			$new_bissness = [];
			$new_bissness_total['total_all'] = 0;
			$new_deal['total_new'] = 0;

			foreach($new_bissness_new_deal as $key => $val)
			{
				// new bissness
				//array_push($new_bissness, $val->amounts);
				//$new_bissness_total['total_all'] += $val->amounts;
				if($b != $val->worker_id){
					$b = $val->worker_id;
					$new_bissness[$val->worker_id] = $val->amounts_due;
				}else{
					$new_bissness[$val->worker_id] += $val->amounts_due;
				}
				$new_bissness_total['total_all'] += $val->amounts_due;
				// end new bissness

				// new deal
				if($val->payment_type_id==1 || $val->payment_type_id==4)
				{
					$ab = $ab+1;
					if($a != $val->worker_id){
						$new_deal["{$val->worker_id}"] = 1;
						$a = $val->worker_id;
					}
					else {
						$new_deal["{$val->worker_id}"] += 1;
					}
				}

				if($val->payment_type_id == 6) // || $val->payment_type_id == 7 || $val->payment_type_id == 11
				{
					$ab = $ab+0.5;
					if($a != $val->worker_id){
						$new_deal["{$val->worker_id}"] = 0.5;
						$a = $val->worker_id;
					}
					else {
						$new_deal["{$val->worker_id}"] += 0.5;
					}
				}
				// end new deal

				$new_deal['total_new'] = $ab;
			} // end foreach
		}

		if( isset($request->exel) ) {
			header("Content-Type: application/xls");
			header("Content-Disposition: attachment; filename=download.xls");
			return view('create.saler-report', compact('new_deal','new_bissness_total','new_bissness','total_amout','workingDays','result_payment_method','result_payment_type','result_worker','result_marketing','end_date','start_date'));
		}
		return view('show.report', compact('new_deal','new_bissness_total','new_bissness','total_amout','workingDays','result_payment_method','result_payment_type','result_worker','result_marketing','end_date','start_date'));
	}

	public function checkSelects(Request $request)
	{
		if( isset($request->type) && $request->type == "marketing" )
		{
			$marketing_sources = Marketing_source::orderBy('title','asc')->get();
			if( isset($marketing_sources) && $marketing_sources!=null ){
				echo "<option value=''>Choose</option>";
				foreach($marketing_sources as $item){
					echo "<option value='$item->id'>$item->title</option>";
				}
			}else{
				echo "novu";
			}
		}

	}
}
