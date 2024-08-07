@extends('layouts.admin')
@section('content')

    <div class="container" ng-controller="ViewInvoiceCtrl">

        <div class="main">

            <div class="page-header">
                <h2>View Invoice #{{$invoice->invoice_number}}</h2>
            </div>

            <div class="clearfix"></div>

            <button ng-click="sendEmail()" class="btn btn-default">Email to Customer</button>

            @if($invoice->is_email_sent)
                <span>
                    An email has been sent to the customer
                </span>
            @endif

            <form class="form-horizontal" name="invoiceForm" role="form" ng-submit="invoiceForm.$valid && submit()" novalidate>

                <a href="{{route('admin.invoices.index')}}" class="btn btn-default pull-right"><span class="icon-left"></span> Back</a>

                <div class="pull-left">
                    <p>Date Ordered:  {{date('M d, Y', strtotime($invoice->orderHeader->created_at)) }}</p>
                    <p>Date Invoiced:  {{date('M d, Y', strtotime($invoice->created_at)) }}</p>
                    <p>Payment Method: {{$invoice->orderHeader->optionPayment->name}}</p>
                </div>

                <div class="clearfix"></div>

                <fieldset>

                    <legend>Customer</legend>

                    <div class="col-md-6">
                        <my-static-display label="Customer" label-size="4" value-size="8">
                            {{$invoice->orderHeader->customer->name}}
                        </my-static-display>

                        <my-static-display label="Email" label-size="4" value-size="8">
                            {{$invoice->orderHeader->customer->email}}
                        </my-static-display>
                    </div>


                </fieldset>

                <fieldset>

                    <legend>Recipient details</legend>

                    <div class="col-md-6">

                        <my-static-display label="Ship to" label-size="4" value-size="8">
                            {{$invoice->orderHeader->orderRecipient->name}}
                        </my-static-display>

                        <my-static-display label="Email" label-size="4" value-size="8">
                            {{$invoice->orderHeader->orderRecipient->email}}
                        </my-static-display>

                        <my-static-display label="Shipping address" label-size="4" value-size="8">
                            {{$invoice->orderHeader->orderRecipient->shipping_address}}
                        </my-static-display>

                    </div>


                    <div class="col-md-6">


                        <my-static-display label="Telephone number" label-size="4" value-size="8">
                            {{$invoice->orderHeader->orderRecipient->telephone_number}}
                        </my-static-display>

                        <my-static-display label="Mobile number" label-size="4" value-size="8">
                            {{$invoice->orderHeader->orderRecipient->mobile_number}}
                        </my-static-display>

                    </div>

                </fieldset>


                <fieldset>
                    <legend>Order total</legend>

                    <div class="col-md-6">
                        <my-static-display label="Subtotal" label-size="4" value-size="8">
                            {{$invoice->orderHeader->subtotal}}
                        </my-static-display>

                        <my-static-display label="Shipping rate" label-size="4" value-size="8">
                            {{$invoice->orderHeader->shipping_rate}}
                        </my-static-display>

                        <my-static-display label="Discount" label-size="4" value-size="8">
                            {{$invoice->orderHeader->discount}}
                        </my-static-display>
                    </div>

                    <div class="col-md-6">
                        <my-static-display label="Grand total" label-size="4" value-size="8">
                            {{$invoice->orderHeader->grand_total}}
                        </my-static-display>
                    </div>
                </fieldset>

                <fieldset>

                    <legend>Orders</legend>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Size</th>
                            <th>QTY Invoiced</th>
                            <th>Amount Invoiced</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($invoice->invoiceDetail as $id)
                            <tr>

                                <td>
                                {{$id->orderDetail->item->name . ' ' .  $id->orderDetail->item->short_description}}
                                </td>
                                <td>{{count($id->orderDetail->optionSize) >=1 ? $id->orderDetail->optionSize->name : 'N/A'}}</td>
                                <td>{{$id->qty}}</td>
                                <td>{{$id->amount}}</td>

                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </fieldset>


            </form>
        </div>
    </div>

@stop