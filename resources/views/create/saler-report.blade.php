<table border="1">
    <thead>
    <tr style="text-align: center;">
        <th colspan="4" style="text-align: center;">
            <img src="http://test-usa.tk/img/logo.png" alt="logo" width="250" height="75" style="text-align: center;">
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
                <td>@if($item->amounts_due>0) ${{number_format($item->amounts_due,2)}} @else $0,00 @endif</td>
            </tr>
        @endforeach
        <tr>
            <td><b>Total</b></td>
            <td><b>@if($total_amout[0]->amounts_due>0) ${{number_format($total_amout[0]->amounts_due,2)}} @else $0,00 @endif</b></td>
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
                <td>@if($item->amounts_due>0) ${{number_format($item->amounts_due,2)}} @else $0,00 @endif</td>
            </tr>
        @endforeach
        <tr>
            <td><b>Total</b></td>
            <td><b>@if($total_amout[0]->amounts_due>0) ${{number_format($total_amout[0]->amounts_due,2)}} @else $0,00 @endif</b></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <th>Marketing Source</th>
            <th>$ Collected</th>
        </tr>
        @foreach($result_marketing as $item)
            <tr>
                <td>{{$item->msTitle}}</td>
                <td>@if($item->amounts_due>0) ${{number_format($item->amounts_due,2)}} @else $0,00 @endif</td>
            </tr>
        @endforeach
        <tr>
            <td><b>Total</b></td>
            <td><b>@if($total_amout[0]->amounts_due>0) ${{number_format($total_amout[0]->amounts_due,2)}} @else $0,00 @endif</b></td>
        </tr>
    </tbody>
</table>
