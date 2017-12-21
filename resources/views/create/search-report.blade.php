<table border="1">
    <thead>
    <tr>
        <th>#</th>
        <th>Created at</th>
        <th>Case ID</th>
        <th>Client Name</th>
        <th>Marketing Source</th>
        <th>Total Price</th>
        <th>Collected (total)</th>
        <th>Lead Date</th>
        <th>Payment Date</th>
        <th>Age</th>
        <th>Payment Method</th>
        <th>Payment Type</th>
        <th>Return Check</th>
        <th>Sale Rap</th>
        <th>Amount due</th>
        <th>Collected (amount)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($td_results as $key => $item)
        <tr>
            <td>{{$t_results[$key]->id}}</td>
            <td>{{$t_results[$key]->created_at}}</td>
            <td>{{$t_results[$key]->case_id}}</td>
            <td>{{$t_results[$key]->client_name}}</td>
            <td>{{$t_results[$key]->mTitle}}</td>
            <td>{{$t_results[$key]->total_price}}</td>
            <td>@if($t_results[$key]->collected==1) Yes @else No @endif</td>
        </tr>
        @foreach($item as $val)
        <tr>
            <td style="border:0"></td>
            <td style="border:0"></td>
            <td style="border:0"></td>
            <td style="border:0"></td>
            <td style="border:0"></td>
            <td style="border:0"></td>
            <td style="border:0"></td>
            <td>{{$val->lead_date}}</td>
            <td>{{$val->payment_date}}</td>
            <td>{{$val->age}}</td>
            <td>{{$val->title}}</td>
            <td>{{$val->ptTitle}}</td>
            <td>@if($val->check_price != null){{$val->check_price}} @if($val->check==1) Customer @else House @endif @endif</td>
            <td>{{$val->first_name}} {{$val->last_name}}</td>
            <td>{{$val->amounts_due}}</td>
            <td>@if($val->payed==1) Yes @else No @endif</td>
        </tr>
        @endforeach
    @endforeach
    </tbody>
</table>