<html>
<body style="background-color: white">

<table width=100%>
    <tr>
        <td style='text-align: center;text-decoration: underline'><h2>Purchase Order Request</h2></td>
    </tr>
</table>



<table>
    <tr><td>{{date('Y-m-d')}}</td></tr>
    <tr>
        <td><h2>{{$data['header_details']['company_name']}}</h2></td>

    </tr>
    <tr>
        <td><h6>{{$data['header_details']['company_address']}}
        </td>
    </tr>

    <tr>
        <td> <h6>Tel : {{$data['header_details']['company_phone']}}</h6></td>
    </tr>
</table>


<table style="width: 100%">
    <tr>
        <td style="height: 50px"></td>
    </tr>
</table>


<table>

    <tr>
        <p>Dear Supplier ({{$data['details']['supplier_details']->name}}),&nbsp;</p></tr>
    <tr><p>This the an order request to you. If you can full fill this order, please send a reply to this email. Happy to work with you </p>

    </tr>

</table>

<table style="width: 100%">
    <tr>
        <td style="height: 50px"></td>
    </tr>
</table>

<table style="width: 100%" border="1" cellpadding=5 cellspacing=0>
    <tr >
        <th style="background-color: #c9c9c9;">product name</th>
        <th style="background-color: #c9c9c9;">Quantity</th>
    </tr>
    @foreach($data['details']['product_details'] as $product)
        <tr>
            <td class="text-center">{{$product->name}}</td>
            <td class="text-left">{{$product->quantity}}</td>

        </tr>

    @endforeach
</table>

</body>
</html>


