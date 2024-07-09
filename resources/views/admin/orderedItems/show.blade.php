@extends('layouts.admin')
@section('content')

    <div class="container">
        <div class="main">



                    <legend>Recipient details</legend>

                    <div class="col-md-6">

                        <my-static-display label="Ship to" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->name}}
                        </my-static-display>

                        <my-static-display label="Email" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->email}}
                        </my-static-display>

                        <my-static-display label="Shipping address" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->shipping_address}}
                        </my-static-display>

                    </div>

                    <div class="col-md-6">

                        <my-static-display label="Telephone number" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->telephone_number}}
                        </my-static-display>

                        <my-static-display label="Mobile number" label-size="4" value-size="8">
                            {{$orderHeader->orderRecipient->mobile_number}}
                        </my-static-display>
                        <my-static-display label="City" label-size="4" value-size="8">
                            @if(count($orderHeader->orderRecipient->city))
                                {{$orderHeader->orderRecipient->city->name}}
                            @endif
                        </my-static-display>

                    </div>

        </div>
    </div>
@stop