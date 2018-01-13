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
                            <h2 class="tCenter" id="current-date">{{date('F.Y')}}</h2>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Sales Rep</th>
                                    <th>{{$current_date}}</th>
                                    <th>Pay Period</th>
                                    <th>M-T-D</th>
                                    <th>New $</th>
                                    <th class="tCenter">New</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($m_t_d as $key => $item)
                                    <tr>
                                        <td @if( isset($result_worker[$key]) && $result_worker[$key] < 0 ) class="danger" @endif>@if( isset($name[$key]) ) {{$name[$key]}} @endif</td>
                                        <td @if( isset($result_worker[$key]) && $result_worker[$key] < 0 ) class="danger" @endif>@if( isset($result_worker[$key]) ) $ {{number_format($result_worker[$key],2)}} @else $ 0,00 @endif</td>
                                        <td>@if( isset($pay_period[$key]) ) $ {{number_format($pay_period[$key],2)}} @else $ 0,00 @endif</td>
                                        <td>@if( isset($m_t_d[$key]) ) $ {{number_format($m_t_d[$key],2)}} @else $ 0,00 @endif</td>
                                        <td>@if( isset($new_bissness[$key]) ) $ {{number_format($new_bissness[$key],2)}} @else $ 0,00 @endif</td>
                                        <td style="text-align: center;">@if( isset($new_deal[$key]) ) {{$new_deal[$key]}} @else 0 @endif</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><b>Total</b></td>
                                    <td @if( isset($total_amout['total']) && $total_amout['total'] < 0 ) class="danger" @endif><b>@if(isset($total_amout['total'])) $ {{number_format($total_amout['total'],2)}} @else $ 0,00 @endif</b></td>
                                    <td>@if($pay_period_total['total']>0) $ {{number_format($pay_period_total['total'],2)}} @else $ 0,00 @endif</td>
                                    <td>@if($m_t_d_total['total']>0) $ {{number_format($m_t_d_total['total'],2)}} @else $ 0,00 @endif</td>
                                    <td>@if($new_bissness_total['total_all']>0) $ {{number_format($new_bissness_total['total_all'],2)}} @else $ 0,00 @endif</td>
                                    <td style="text-align: center;">@if($new_deal['total_new']>0) {{$new_deal['total_new']}} @else 0 @endif</td>
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
<script>
function autoRefresh()
{
    window.location = window.location.href;
}
setInterval('autoRefresh()', 60000);
</script>