<table border="1">
    <thead>
    <tr style="text-align: center;">
        <th colspan="4" style="text-align: center;">
            <table style="text-align:center;" align="center" width="100%">
                <tr style="text-align:center;" align="center">
                    <td style="text-align:center;" align="center">
                        <img src="http://test-usa.tk/img/logo.png" alt="logo" width="250" height="75" style="text-align: center;" align="center">
                    </td>
                </tr>
            </table>
        </th>
    </tr>
    <tr><th></th></tr>
    <tr><th></th></tr>
    <tr><th></th></tr>
    <tr>
        <th colspan="4" style="text-align:center;">Sales Payroll</th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center">{{$start_date}} to {{$end_date}}</th>
    </tr>
    <tr>
        <th colspan="4" style="text-align: center">@if(isset($workingDays)&&$workingDays!=null) {{$workingDays}} Workdays @endif</th>
    </tr>
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
