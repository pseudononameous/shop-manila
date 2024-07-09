@extends('layouts.admin') 
@section('content')
<div class="container">
    <div class="main">

        <div class="page-header">
            <h2>View Item</h2>
        </div>

        <div class="form-horizontal">

            <fieldset class="col-md-6">

                <my-static-display label-size="2" label="Name" value-size="8" required>
                    {{$item->name}}
                </my-static-display>

                <my-static-display label-size="2" label="SKU" value-size="8">
                    {{$item->sku}}
                </my-static-display>

                <my-static-display label-size="2" label="Short description" value-size="8">
                    {{$item->short_description}}
                </my-static-display>

                <my-static-display label-size="2" label="Description" value-size="8">
                    {{$item->description}}
                </my-static-display>

                <my-static-display label-size="2" label="Price" value-size="8">
                    {{$item->price}}
                </my-static-display>

                <my-static-display label="Status" label-size="2" value-size="8">
                    {{$item->optionStatus->status}}
                </my-static-display>

            </fieldset>


        </div>
    </div>
</div>
@endsection