@extends('layouts.app')

@section('title')
    Search
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
            <div class="panel-heading">Search</div>

            <div class="panel-body">
                <form action="{{ url('/search') }}" autocomplete="off" method="get" id="search_form" role="search">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="case_id">Case ID #</label>
                                <input type="text" id="case_id" class="form-control" name="case_id" value="{{$case_id}}" placeholder="Case ID #">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="client_name">Client Name</label>
                                <input type="text" id="client_name" class="form-control" name="client_name" value="{{$client_name}}" placeholder="Jose Isreal Manzano Lopez">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="client_name">Marketing Source</label>
                                <select name="marketing_source_id" id="marketing_source_id" class="form-control">
                                    <option value="">Choose</option>
                                    @foreach($marketing_sources as $item)
                                    <option value="{{$item->id}}" @if($item->id==$marketing_source_id) selected @endif>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total_price">Gross Sale</label>
                                <div class="input-group date">
                                    <input type="text" id="total_price" class="form-control" name="total_price" value="{{$total_price}}" placeholder="Gross Sale">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row tablerow">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class='input-group date datetimepicker'>
                                    <input type='text' name="start_date" id="start_date" value="{{$start_date}}" class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>End Date</label>
                                <div class='input-group date datetimepicker'>
                                    <input type='text' name="end_date" id="end_date" value="{{$end_date}}" class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Age</label>
                                <input type="text" name="age" value="{{$age}}" readonly class="form-control age" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="client_name">Payment Method</label>
                                <select name="payment_method_id" id="payment_method_id" class="form-control pay">
                                    <option value="">Choose</option>
                                    @foreach($payment_methods as $item)
                                    <option value="{{$item->id}}" @if($item->id==$payment_method_id) selected @endif>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="client_name">Payment Type</label>
                                <select name="payment_type_id" id="payment_type_id" class="form-control pay_type">
                                    <option value="">Choose</option>
                                    @foreach($payment_types as $item)
                                        <option value="{{$item->id}}" @if($item->id==$payment_type_id) selected @endif>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="client_name">Sale Rep</label>
                                <select name="worker_id" id="worker_id" class="form-control worker">
                                    <option value="">Choose</option>
                                    @foreach($workers as $item)
                                    <option value="{{$item->id}}" @if($item->id==$worker_id) selected @endif>{{$item->first_name}} {{$item->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="font-size: 1em" for="collected">Collected</label>
                                <input type="checkbox" name="collected" {{$collected}} id="collected" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Search</label>
                            <div class="form-group">
                                <input type="submit" value="Search" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
                @if(count($results)>0)
                <div class="panel-heading">Result ({{count($results)}})</div>
                <form action="{{ url('/search') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Case ID</th>
                                <th>Client Name</th>
                                <th>Marketing Source</th>
                                <th>Payment Method</th>
                                <th>Payment Type</th>
                                <th>Sale Rep</th>
                                <th>Total Price</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $item)
                                <input type="hidden" name="id[]" value="{{$item->id}}">
                                <tr @if( $item->collected == 1 ) class="success" @else class="warning" @endif>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->case_id}}</td>
                                    <td>{{$item->client_name}}</td>
                                    <td>{{$item->msTitle}}</td>
                                    <td>{{$item->pmTitle}}</td>
                                    <td>{{$item->ptTitle}}</td>
                                    <td>{{$item->first_name}} {{$item->last_name}}</td>
                                    <td>{{$item->total_price}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td><a href="{{ url('/manage-transaction/'.$item->id) }}" class="dBlock btn btn-info">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $results->links('vendor.pagination.custom') }}
                    <input type="submit" name="exel" value="Download Search">
                </div>
                </form>
                @endif
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