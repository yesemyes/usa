@extends('layouts.app')

@section('title')
    All workers
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
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">All workers</div>

            <div class="panel-body">
                <div class="table-responsive">
                	<table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($workers as $item)
                                @if( $item->id != 1 )
                                <tr @if( $item->working == 0 ) class="danger" @endif>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->first_name }}</td>
                                    <td>{{ $item->last_name }}</td>
                                    <td>@if( $item->working == 1 ) working @else released @endif</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a href="{{ url('/worker/'.$item->id) }}" class="dBlock btn btn-info">Edit</a>
                                        @if( $item->working == 0 )
                                        <form action="{{url('/deleteWorker/'.$item->id)}}" class="mt5" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="f_l_name" value="{{$item->first_name}} {{$item->last_name}}">
                                            <input type="hidden" name="working" value="{{$item->working}}">
                                            <input type="submit" class="dBlock w100 btn btn-danger" value="Delete">
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                        	@endforeach
                        </tbody>
                	</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection