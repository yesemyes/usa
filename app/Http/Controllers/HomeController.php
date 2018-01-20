<?php

namespace App\Http\Controllers;

use App\Transaction_detalis;
use DB;

class HomeController extends Controller
{
	public function dashboard()
	{
		$now_day = date("Y-m-d");
		$first_day = date('Y-m-01', strtotime($now_day));
		$last_day = date('Y-m-t', strtotime($now_day));

		$middle_day = date('Y-m-15', strtotime($now_day));
		$day_16 = date('Y-m-16', strtotime($now_day));
		$nowDate = strtotime($now_day);
		$middleDate = strtotime($middle_day);


		$result_worker_query = Transaction_detalis::select('amounts_due','workers.id as w_id','first_name','last_name',
																'transaction_detalis.id as td_id','payment_method_id')
		                                    ->leftJoin('workers','workers.id','=','transaction_detalis.worker_id')
		                                    ->where('payed',1)
		                                    ->where('working',1)
		                                    ->whereDate('payment_date',$now_day)
		                                    ->orderBy('transaction_detalis.id','asc')
		                                    ->get();

		$for_worker = [];
		$result_worker = [];
		$total_amout['total'] = 0;
		foreach($result_worker_query as $key => $val)
		{
			if($val->payment_method_id != 14 && $val->payment_method_id != 13) {
				if ( ! in_array( $val->w_id, $for_worker ) ) {
					$for_worker[$val->w_id] = $val->w_id;
					$result_worker[$val->w_id] = $val->amounts_due;
				} else{
					$result_worker[$val->w_id] += $val->amounts_due;
				}
				$total_amout['total'] += $val->amounts_due;
			}else{
				if ( ! in_array( $val->w_id, $for_worker ) ) {
					$for_worker[$val->w_id] = $val->w_id;
				} else{
					$result_worker[$val->w_id] -= $val->amounts_due;
				}
				$total_amout['total'] -= $val->amounts_due;
			}
		}


		if($nowDate>$middleDate)
		{
			$pay_period_query = Transaction_detalis::select('amounts_due','workers.id as w_id','first_name','last_name',
				'transaction_detalis.id as td_id','payment_method_id')
			                                       ->leftJoin('workers','workers.id','=','transaction_detalis.worker_id')
			                                       ->where('payed',1)
			                                       ->where('working',1)
			                                       ->whereDate('payment_date','>=',$day_16)
			                                       ->whereDate('payment_date','<=',$last_day)
																->orderBy('transaction_detalis.id','asc')
			                                       ->get();
		}
		else
		{
			$pay_period_query = Transaction_detalis::select('amounts_due','workers.id as w_id','first_name','last_name',
				'transaction_detalis.id as td_id','payment_method_id')
			                                       ->leftJoin('workers','workers.id','=','transaction_detalis.worker_id')
			                                       ->where('payed',1)
			                                       ->where('working',1)
			                                       ->whereDate('payment_date','>=',$first_day)
			                                       ->whereDate('payment_date','<=',$middle_day)
																->orderBy('transaction_detalis.id','asc')
			                                       ->get();
		}

		$for_pay = [];
		$pay_period = [];
		$pay_period_total['total'] = 0;
		foreach($pay_period_query as $key => $val)
		{
			if($val->payment_method_id != 14 && $val->payment_method_id != 13)
			{
				if ( ! in_array( $val->w_id, $for_pay ) ) {
					$for_pay[$val->w_id] = $val->w_id;
					$pay_period[$val->w_id] = $val->amounts_due;
				}else{
					$pay_period[$val->w_id] += $val->amounts_due;
				}
				$pay_period_total['total'] += $val->amounts_due;
			}else{
				if ( ! in_array( $val->w_id, $for_pay ) ) {
					$for_pay[$val->w_id] = $val->w_id;
				}else{
					$pay_period[$val->w_id] -= $val->amounts_due;
				}
				$pay_period_total['total'] -= $val->amounts_due;
			}
		}

		$m_t_d_query = Transaction_detalis::select('amounts_due','workers.id as w_id','first_name','last_name',
																	'transaction_detalis.id as td_id','payment_method_id')
		                            ->leftJoin('workers','workers.id','=','transaction_detalis.worker_id')
		                            ->where('payed',1)
											 ->where('working',1)
		                            ->whereDate('payment_date','>=',$first_day)
		                            ->whereDate('payment_date','<=',$last_day)
		                            ->orderBy('transaction_detalis.id','asc')
		                            ->get();
		$for_mtd = [];
		$m_t_d = [];
		$name = [];
		$m_t_d_total['total'] = 0;
		foreach($m_t_d_query as $key => $val)
		{
			if($val->payment_method_id != 14 && $val->payment_method_id != 13)
			{
				if ( ! in_array( $val->w_id, $for_mtd ) ) {
					$for_mtd[$val->w_id] = $val->w_id;
					$name[$val->w_id] = $val->first_name." ".$val->last_name;
					$m_t_d[$val->w_id] = $val->amounts_due;
				}else{
					$m_t_d[$val->w_id] += $val->amounts_due;
				}
				$m_t_d_total['total'] += $val->amounts_due;
			}else{
				if ( ! in_array( $val->w_id, $for_mtd ) ) {
					$for_mtd[$val->w_id] = $val->w_id;
				}else{
					$m_t_d[$val->w_id] -= $val->amounts_due;
				}
				$m_t_d_total['total'] -= $val->amounts_due;
			}
		}

		$new_bissness_new_deal = Transaction_detalis::select('amounts_due','payment_type_id','worker_id','transaction_id','payment_date',
			'workers.id as w_id','first_name','last_name','transaction_detalis.id as td_id','payment_method_id')
		                            ->leftJoin('workers','workers.id','=','transaction_detalis.worker_id')
		                                            ->where('payed',1)
																  ->where('working',1)
																	->where( function( $query ) {
																		$query->orWhere( 'payment_type_id', 1 )
																		      ->orWhere( 'payment_type_id', 4 )
																		      ->orWhere( 'payment_type_id', 6 )
																		      ->orWhere( 'payment_method_id', 14 )
																		      ->orWhere( 'payment_method_id', 13 );
																	} )
		                                            ->whereDate('payment_date','>=',$first_day)
		                                            ->whereDate('payment_date','<=',$last_day)
		                                            ->orderBy('transaction_detalis.id','asc')
		                                            ->get();

		$for_new_bissness = [];
		$for_new_deal = [];
		$for_plus = 0;
		$new_bissness = [];
		$new_bissness_total['total_all'] = 0;
		$new_deal['total_new'] = 0;
		foreach($new_bissness_new_deal as $key => $val)
		{
			if ( $val->payment_method_id != 14 && $val->payment_method_id != 13 ) {
				// new bissness
				if ( $val->payment_type_id == 1 || $val->payment_type_id == 4 || $val->payment_type_id == 6 ) {
					if( !in_array($val->worker_id, $for_new_bissness) ){
						$for_new_bissness[$val->worker_id] = $val->worker_id;
						$new_bissness[ $val->worker_id ] = $val->amounts_due;
					} else {
						$new_bissness[ $val->worker_id ] += $val->amounts_due;
					}
					$new_bissness_total['total_all'] += $val->amounts_due;
				}
				// end new bissness

				// new deal
				if ( $val->payment_type_id == 1 || $val->payment_type_id == 4 ) {
					$for_plus = $for_plus + 1;
					if ( !in_array($val->worker_id,$for_new_deal) ) {
						$for_new_deal[$val->worker_id] = $val->worker_id;
						$new_deal[ $val->worker_id ] = 1;
					} else {
						$new_deal[ $val->worker_id ] += 1;
					}
				}

				if ( $val->payment_type_id == 6 ) {
					$for_plus = $for_plus + 0.5;
					if ( !in_array($val->worker_id,$for_new_deal) ) {
						$for_new_deal[$val->worker_id] = $val->worker_id;
						$new_deal[ $val->worker_id ] = 0.5;
					} else {
						$new_deal[ $val->worker_id ] += 0.5;
					}
				}
				// end new deal

				$new_deal['total_new'] = $for_plus;
			}
			else {
				// new bissness
				if ( $val->payment_type_id == 1 || $val->payment_type_id == 4 || $val->payment_type_id == 6 ) {

					if ( ! in_array( $val->worker_id, $for_new_bissness ) ) {
						$for_new_bissness[ $val->worker_id ] = $val->worker_id;
						$new_bissness[ $val->worker_id ] = $val->amounts_due;
					} else {
						$new_bissness[ $val->worker_id ] -= $val->amounts_due;
					}
					$new_bissness_total['total_all'] -= $val->amounts_due;
				}
				// end new bissness

				// new deal
				if ( isset( $new_deal[ $val->worker_id ] ) && ( $val->payment_type_id == 1 || $val->payment_type_id == 4 || $val->payment_type_id == 6 ) )
				{
					if ( $new_bissness[ $val->worker_id ] < 0 )
					{
						$new_deal[ $val->worker_id ] = 0;
						if ( $val->payment_type_id == 1 || $val->payment_type_id == 4 ) {
							$for_plus = $for_plus-1;
						}
						if ( $val->payment_type_id == 6 ) {
							$for_plus = $for_plus-0.5;
						}
						$new_deal['total_new'] = $for_plus;
					}
				}
				// end new deal
			}
		} // end foreach
		$current_date = date('m/d/Y');
		return view('dashboard', compact('current_date','new_deal','new_bissness_new_deal','new_bissness_total','new_bissness','total_amout','result_worker','pay_period','pay_period_total','m_t_d','m_t_d_total','name'));
	}
}
