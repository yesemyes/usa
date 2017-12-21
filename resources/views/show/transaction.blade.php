@extends('layouts.app')

@section('title')
    # {{$transaction['case_id']}} Transaction
@endsection

@section('page-content')
    @if( Session::has('message_success') )
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Success!</strong> {{ Session::get('message_success') }}
                </div>        
            </div>
        </div>
    @elseif( Session::has('message_error') )
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger fade in alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Danger!</strong> {{ Session::get('message_error') }}
                </div>
            </div>
        </div>
    @endif
<div class="row">
    <div class="col-md-14">
        <div class="panel panel-default">
            <div class="panel-heading">{{$transaction['case_id']}} Transaction</div>

            <div class="panel-body">
                <form action="{{ url('/updateTransaction/'.$transaction['id']) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="case_id">Case ID #</label>
                                <input type="text" id="case_id" value="{{$transaction['case_id']}}" class="form-control" required="required" name="case_id" placeholder="Case ID #">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="client_name">Client Name</label>
                                <input type="text" id="client_name" value="{{$transaction['client_name']}}" class="form-control" required="required" name="client_name" placeholder="Jose Isreal Manzano Lopez">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="client_name">Marketing Source</label>
                                <select name="marketing_source_id" class="form-control" required>
                                @foreach($marketing_sources as $item)
                                    @if($item->id == $transaction['marketing_source_id'])
                                        <option value="{{$item->id}}" selected>{{$item->title}}</option>
                                    @else
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total_price">Gross Sale</label>
                                <div class="input-group date">
                                    <input type="text" id="total_price" value="{{$transaction['total_price']}}" class="form-control" required="required" name="total_price" placeholder="Gross Sale">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="cont">
                    @foreach($detalis as $key => $item)
                        <div class="row tablerow">
                            <input type="hidden" name="tID[]" value="{{$item->tID}}">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <a id="del-{{$item->tID}}" class="btn btn-danger @if($key == 0) mt25 @endif form-control del"><i class="fa fa-minus"></i></a>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    @if($key == 0)<label>Lead Date</label>@endif
                                    <div class='input-group date datetimepicker'>
                                        <input type='text' name="lead_date[]" value="{{$lead_date[$key]}}" class="form-control" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    @if($key == 0)<label>Payment Date</label>@endif
                                    <div class='input-group date datetimepicker'>
                                        <input type='text' name="payment_date[]" value="{{$payment_date[$key]}}" class="form-control" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    @if($key == 0)<label>Age</label>@endif
                                    <input type="text" value="{{$item->age}}" readonly name="age[]" class="form-control age" required />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    @if($key == 0)<label>Payment Method</label>@endif
                                    <select name="payment_method_id[]" class="form-control pay" required>
                                        @foreach($payment_methods as $a => $val)
                                            @if($val->id == $item->payment_method_id)
                                                <option value="{{$val->id}}" selected>{{$val->title}}</option>
                                            @else
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="input-group date return_check @if($item->payment_method_id!=14) none @endif">
                                        <input type="text" name="check_price[]" value="{{$item->check_price}}" class="form-control amCol" placeholder="Check (m or i)" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-usd"></i>
                                            <input type="checkbox" @if($item->check==1) checked @endif class="" name="check[]" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    @if($key == 0)<label>Payment Types</label>@endif
                                    <select name="payment_type_id[]" class="form-control pay_type" required>
                                        @foreach($payment_types as $a => $val)
                                            @if($val->id == $item->payment_type_id)
                                                <option value="{{$val->id}}" selected>{{$val->title}}</option>
                                            @else
                                                <option value="{{$val->id}}">{{$val->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    @if($key == 0)<label>Sale Rep</label>@endif
                                    <select name="worker_id[]" class="form-control worker" required>
                                        @foreach($workers as $a => $val)
                                            @if($val->id == $item->worker_id)
                                                <option value="{{$val->id}}" selected>{{$val->first_name}} {{$val->last_name}}</option>
                                            @else
                                                <option value="{{$val->id}}">{{$val->first_name}} {{$val->last_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    @if($key == 0)<label class="amCol">Amount Due (Collected)</label>@endif
                                    <div class="input-group date">
                                        <input type="text" value="{{$item->amounts_due}}" name="amounts_due[]" class="form-control @if($transaction->total_price < $amounts_due) amounts_sum @endif amount_due" required />
                                        <span class="input-group-addon">
                                            <input type="checkbox" class="payed" name="payed[]" @if($item->payed==1) checked @endif>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        <div class="row tablerow">
                            <div class="col-md-1">
                                <div class="form-group">
                                    <a class="btn btn-success updateTransaction form-control add"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="col-md-2 hidden pMsR">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select name="payment_method_id[]" class="form-control pay" required>
                                        <option value="">Choose</option>
                                        @foreach($payment_methods as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 hidden pMsR">
                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select name="payment_type_id[]" class="form-control pay_type" required>
                                        <option value="">Choose</option>
                                        @foreach($payment_types as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 hidden pMsR">
                                <div class="form-group">
                                    <label>Sale Rep</label>
                                    <select name="worker_id[]" class="form-control worker" required>
                                        <option value="">Choose</option>
                                        @foreach($workers as $item)
                                        <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Update" class="form-control" id="updateTransaction">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
@section('myjsfile')
<link href="{{ url('dist/css/datetimepicker.css') }}" rel="stylesheet"/>
<script src="{{ url('bower_components/bootstrap/dist/js/moment.min.js') }}"></script>
<script src="{{ url('bower_components/bootstrap/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('dist/js/transaction.js') }}"></script>
@endsection