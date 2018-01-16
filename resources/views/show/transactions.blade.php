@extends('layouts.app')

@section('title')
    All Transactions
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
            <div class="panel-heading">All Transactions</div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Case ID</th>
                                <th>Client Name</th>
                                <th>Marketing Source</th>
                                <th>($) Gross Sale</th>
                                <th>Created at</th>
                                <th class="tCenter">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $item)
                                <tr @if( $item->collected == 1 ) class="success" @else class="warning" @endif>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->case_id }}</td>
                                    <td>{{ $item->client_name }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>$ {{ $item->total_price }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="tCenter">
                                        <a href="{{ url('/manage-transaction/'.$item->id) }}" target="_blank" class="btn btn-info">Edit</a>
                                        <a href="#" data-id="{{$item->id}}" class="del_tr btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $transactions->links('vendor.pagination.custom') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('myjsfile')
<script src="{{ url('bower_components/bootstrap/dist/js/moment.min.js') }}"></script>
<script src="{{ url('bower_components/bootstrap/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('dist/js/transaction.js') }}"></script>
@endsection