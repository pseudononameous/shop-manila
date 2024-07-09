<!DOCTYPE html>
<html>
<head>

</head>


<body style="color: #222222;font-size: 15px;line-height: 1.42857; font-family: 'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif; margin-left:10%; margin-right:10%">

<p>
        <h2>Customer Invoice Details</h2>
</p>

<div>

    <p>Order placed on: {{ date('M d, Y', strtotime($data->orderHeader->created_at))}}</p>
    <p>Order number: {{$data->orderHeader->order_number}}</p>
    <p>Invoice number: {{$data->invoice_number}}</p>

</div>

<div>
    <h2>Recipient Details</h2>

    <p>Ship to: {{$data->orderHeader->orderRecipient->name}}</p>


</div>

<table style="width:100%; border-collapse: collapse;">

    <thead>
    <tr>
        <th style="width:20%;border:1px solid black;">Contact Details</th>
        <th style="width:20%;border:1px solid black;">Shipping Address</th>
    </tr>
    </thead>

    <tbody>


    <tr>
        <td style="border:1px solid black;">
            <p style="text-align:center">Email: <br>{{$data->orderHeader->orderRecipient->email}}</p>
            <p style="text-align:center">Telephone number: <br>{{$data->orderHeader->orderRecipient->telephone_number}}</p>
            <p style="text-align:center">Mobile number: <br>{{$data->orderHeader->orderRecipient->mobile_number}}</p>
        </td>
        <td style="border:1px solid black;">
            <p style="text-align:center;">{{$data->orderHeader->orderRecipient->shipping_address}}</p>
        </td>
    </tr>



    </tbody>

</table>



<h2>Summary of Invoiced Items</h2>

<table style="width:100%; border-collapse: collapse;">

    <thead>
    <tr>
        <th style="width:16%;border:1px solid black;">Item</th>
        <th style="width:16%;border:1px solid black;">Quantity Invoiced</th>
        <th style="width:16%;border:1px solid black">Amount Invoiced</th>
    </tr>
    </thead>

    <tbody>

    @foreach ($data->invoiceDetail as $id)
        <tr>
            <th style="width:16%;border:1px solid #ccc;">{{$id->orderDetail->item->name . ' ' . $id->orderDetail->item->short_description}} </th>
            <th style="width:16%;border:1px solid #ccc;">{{$id->qty}}</th>
            <th style="width:16%;border:1px solid #ccc;"> {{$id->amount}}</th>
        </tr>
    @endforeach


    </tbody>

</table>

<h3>Order total details</h3>

<div>
    Shipping rate: P {{$data->orderHeader->shipping_rate}}
</div>

<div>
    Discount applied: P {{$data->orderHeader->discount}}
</div>

<div>
    Your order's grand total is: P {{$data->orderHeader->grand_total}}
</div>



</body>
</html>