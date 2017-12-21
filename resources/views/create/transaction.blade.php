@extends('layouts.app')

@section('title')
    Create New Transaction
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
                <div class="panel-heading">Create New Transaction</div>

                <div class="panel-body">
                    <form action="{{ url('/createTransaction') }}" method="POST">
		                {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="case_id">Case ID #</label>
                                    <input type="text" id="case_id" class="form-control" required="required" name="case_id" placeholder="Case ID #">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="client_name">Client Name</label>
                                    <input type="text" id="client_name" class="form-control" required="required" name="client_name" placeholder="Jose Isreal Manzano Lopez">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="client_name">Marketing Source</label>
                                    <select name="marketing_source_id" class="form-control" required>
                                        <option value="">Choose</option>
                                        @foreach($marketing_sources as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="total_price">Gross Sale</label>
                                    <div class="input-group date">
                                        <input type="text" id="total_price" class="form-control" required="required" name="total_price" placeholder="Gross Sale">
                                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="cont">
    		                <div class="row tablerow">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <a class="btn btn-success mt25 form-control add"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Lead Date</label>
                                        <div class='input-group date datetimepicker'>
                                            <input type='text' name="lead_date[]" class="form-control" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Payment Date</label>
                                        <div class='input-group date datetimepicker'>
                                            <input type='text' name="payment_date[]" class="form-control" required />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="text" name="age[]" readonly class="form-control age" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Payment Method</label>
                                        <select name="payment_method_id[]" class="form-control pay" required>
                                            <option value="">Choose</option>
                                            @foreach($payment_methods as $item)
                                            <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group date return_check none">
                                            <input type="text" name="check_price[]" class="form-control amCol" placeholder="Check (m or i)" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-usd"></i>
                                                <input type="checkbox" class="" name="check[]" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="col-md-2">
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
                                <!--  -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="client_name">Sale Rep</label>
                                        <select name="worker_id[]" class="form-control worker" required>
                                            <option value="">Choose</option>
                                            @foreach($workers as $item)
                                            <option value="{{$item->id}}">{{$item->first_name}} {{$item->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="client_name" class="amCol">Amount Due (Collected)</label>
                                        <div class="input-group date">
                                            <input type="text" name="amounts_due[]" class="form-control amount_due" required>
                                            <span class="input-group-addon">
                                                <input type="checkbox" class="payed" name="payed[]">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

		                <div class="form-group">
		                    <input type="submit" value="Create" class="form-control">
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