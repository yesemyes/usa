@extends('layouts.app')

@section('title')
    All Marketing Sources
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
            <div class="col-xs-8">
                <div class="alert alert-danger fade in alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Danger!</strong> {{ Session::get('message_error') }}
                </div>
            </div>
        </div>
    @endif
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">All Marketing Sources</div>

            <div class="panel-body">
                <form action="{{url('/updateMarketingSource')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <select name="id" class="form-control" required>
                            <option value="">Select Marketing Source</option>
                        @foreach($marketing_sources as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" required="required" name="title" class="form-control" placeholder="Marketing Source name (for delete)">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="change" value="update" class="btn btn-success">Change</button>
                        <button type="submit" name="destroy" value="delete" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection