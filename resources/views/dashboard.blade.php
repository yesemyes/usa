@extends('layouts.app')

@section('title')
    Coast One Dashboard
@endsection

@section('page-content')
    <div class="row">
        <div class="col-md-14">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if(isset($new_deal) && count($new_deal)>0)
                        <div class="table-responsive">
                            <h2 class="tCenter" id="current-date">{{$current_date}}</h2>
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
                                        <td>@if( isset($item->first_name) ) {{$item->first_name}} {{$item->last_name}} @endif</td>
                                        <td>@if( isset($item->amounts_due) ) ${{number_format($item->amounts_due,2)}} @else $0,00 @endif</td>
                                        <td>@if( isset($new_bissness[$key]) ) ${{number_format($new_bissness[$key],2)}} @else $0,00 @endif</td>
                                        <td style="text-align: center;">@if( isset($new_deal[$item->w_id]) ) {{str_replace("."," , ",$new_deal[$item->w_id])}} @else 0 @endif</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><b>Total</b></td>
                                    <td><b>@if($total_amout[0]->amounts_due>0) ${{number_format($total_amout[0]->amounts_due,2)}} @else $0,00 @endif</b></td>
                                    <td>@if($new_bissness_total['total_all']>0) ${{number_format($new_bissness_total['total_all'],2)}} @else $0,00 @endif</td>
                                    <td style="text-align: center;">@if($new_deal['total_new']>0) {{str_replace("."," , ",$new_deal['total_new'])}} @else 0 @endif</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
