@extends('layouts.app')

@section('title')
    Create Marketing Source
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
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Create Marketing Source</div>
                <div class="panel-body">
                    <form action="{{ url('/createMarketingSource') }}" method="POST">
		                {{ csrf_field() }}
		                <div class="form-group">
		                    <label for="title">Title</label>
		                    <input type="text" id="title" required="required" name="title" class="form-control" placeholder="Marketing Source Name">
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