<?php

namespace App\Http\Controllers\Delete;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Worker;
use App\Transaction;
use App\Transaction_detalis;

class DeleteController extends Controller
{
    public function worker($id, Request $request)
    {
        if( isset($request->working) && $request->working != null ){
            if( isset($request->f_l_name) ) $del_worker = $request->f_l_name;
            else $del_worker = "unknown";
            if( $request->working == 0 ){
                $worker = Worker::where('id',$id)->where('id','<>','1')->delete();
                if($worker == 1){
                    Session::flash('message_success', $del_worker.' worker deleted');
                    return redirect('/workers');
                }else{
                    Session::flash('message_error', $del_worker.' worker not deleted!');
                    return redirect('/workers');
                }
            }else{
                Session::flash('message_error', $del_worker.' real time on worker!');
                return redirect('/workers');
            }
        }
    }

    public function transaction_detalis($id, Request $request)
    {
        $trDetalis = Transaction_detalis::where('id',$id)->delete();
        if($trDetalis == 1) return "ok";
        else return "error";
    }
}
