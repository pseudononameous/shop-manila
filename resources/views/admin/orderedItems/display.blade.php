@extends('layouts.admin')
@section('content')

    <div class="container" ng-controller="ViewInvoiceCtrl">

        <div class="main">

            <div class="page-header">
                <h2>View Invoice #{{$invoice->invoice_number}}</h2>
            </div>

            <div class="clearfix"></div>

            <button ng-click="sendEmail()" class="btn btn-default">Email to Customer</button>

            <form class="form-horizontal" name="invoiceForm" role="form" ng-submit="invoiceForm.$valid && submit()" novalidate>

                <a href="{{route('admin.invoices.index')}}" class="btn btn-default pull-right"><span class="icon-left"></span> Back</a>

                <div class="pull-left">
                    <p>Date Ordered:  {{date('M d, Y', strtotime($invoice->orderHeader->created_at)) }}</p>
                    <p>Date Invoiced:  {{date('M d, Y', strtotime($invoice->created_at)) }}</p>
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

                    <legend>Orders</legend>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>QTY Invoiced</th>
                            <th>Amount Invoiced</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($invoice->invoiceDetail as $id)
                            <tr>

                                <td>
                                {{$id->orderDetail->item->name}}
                                </td>
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