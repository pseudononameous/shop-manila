<!DOCTYPE html>
<html>
<head>

</head>


<body style="color: #222222;font-size: 15px;line-height: 1.42857; font-family: 'Open Sans','Helvetica Neue',Helvetica,Arial,sans-serif; margin-left:10%; margin-right:10%">

<p>
<h2>Customer Shipment Details</h2>
</p>

<div>

    <p>Order placed on: {{ date('M d, Y', strtotime($data->orderHeader->created_at))}}</p>
    <p>Order number: {{$data->orderHeader->order_number}}</p>
    <p>Shipment number: {{$data->shipment_number}}</p>

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



<h2>Summary of Shipped Items</h2>

<table style="width:100%; border-collapse: collapse;">

    <thead>
    <tr>
        <th style="width:16%;border:1px solid black;">Item</th>
        <th style="width:16%;border:1px solid black;">Quantity Shipped</th>
        <th style="width:16%;border:1px solid black">Tracking Number</th>
    </tr>
    </thead>

    <tbody>

    @foreach ($data->shipmentDetail as $sd)
        <tr>
            <th style="width:16%;border:1px solid #ccc;">{{$sd->orderDetail->item->name . ' ' . $sd->orderDetail->item->short_description}}</th>
            <th style="width:16%;border:1px solid #ccc;">{{$sd->qty}}</th>
            <th style="width:16%;border:1px solid #ccc;"> {{$sd->tracking_number}}</th>
        </tr>
    @endforeach


    </tbody>

</table>


</body>
</html>