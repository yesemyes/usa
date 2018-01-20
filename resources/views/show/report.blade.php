@extends('layouts.app')

@section('title')
    Coast One Report
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
                <div class="panel-heading">Report @if(isset($workingDays)&&$workingDays!=null) working days in {{$workingDays}} @endif</div>

                <div class="panel-body">
                    <form action="{{ url('/report') }}" autocomplete="off" method="GET">
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
                            <div class="col-md-2">
                                <label>Search</label>
                                <div class="form-group">
                                    <input type="submit" value="Search" class="form-control">
                                </div>
                            </div>
                        </div>
                        @if(isset($new_deal) && count($new_deal)>0)
                            <div class="table-responsive">
                                <h2 class="tCenter">Sales Payroll</h2>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Sales Rep</th>
                                        <th>Total Collected</th>
                                        <th>New Business </th>
                                        <th>New Deals</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($result_worker as $key => $item)
                                        <tr>
                                            <td>@if( isset($name[$key]) ) {{$name[$key]}} @endif</td>
                                            <td>@if( isset($item) ) ${{number_format($item,2)}} @else $0,00 @endif</td>
                                            <td>@if( isset($new_bissness[$key]) ) ${{number_format($new_bissness[$key],2)}} @else $0,00 @endif</td>
                                            <td style="text-align: center;">@if( isset($new_deal[$key]) ) {{$new_deal[$key]}} @else 0 @endif</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td><b>@if(isset($total_amout['total'])) ${{number_format($total_amout['total'],2)}} @else $0,00 @endif</b></td>
                                        <td>@if(isset($new_bissness_total['total_all'])) ${{number_format($new_bissness_total['total_all'],2)}} @else $0,00 @endif</td>
                                        <td style="text-align: center;">@if(isset($new_deal['total_new'])) {{$new_deal['total_new']}} @else 0 @endif</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <th>Total Collected</th>
                                    </tr>
                                    @foreach($result_payment_method as $item)
                                        <tr>
                                            <td>{{$item->pmTitle}}</td>
                                            <td>@if(isset($item->amounts_due)) @if($item->pmTitle == "Refund" || $item->pmTitle == "Returned Check") - @endif ${{number_format($item->amounts_due,2)}} @else $0,00 @endif</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td><b>@if(isset($total_amout['total'])) ${{number_format($total_amout['total'],2)}} @else $0,00 @endif</b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Type</th>
                                        <th>Total Collected</th>
                                    </tr>
                                    @foreach($result_payment_type as $item)
                                        <tr>
                                            <td>{{$item->ptTitle}}</td>
                                            <td>@if($item->amounts_due>0) @if($item->ptTitle == "Refund" || $item->ptTitle == "Returned Check") - @endif ${{number_format($item->amounts_due,2)}} @else $0,00 @endif</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td><b>@if(isset($total_amout['total'])) ${{number_format($total_amout['total'],2)}} @else $0,00 @endif</b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Marketing Source</th>
                                        <th>$ Collected</th>
                                    </tr>
                                    @foreach($result_marketing as $key => $item)
                                        <tr>
                                            <td>@if(isset($key)) {{$key}} @endif</td>
                                            <td>@if(isset($item)) ${{number_format($item,2)}} @else $0,00 @endif</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td><b>@if(isset($total_amout['total'])) ${{number_format($total_amout['total'],2)}} @else $0,00 @endif</b></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input type="submit" name="exel" value="Download Report">
                            </div>
                        @endif
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
