@extends('layouts.admin') 
@section('content')
<div class="container">
    <div class="main">

        <div class="page-header">
            <h2>View Store</h2>
        </div>

        <div class="form-horizontal">

            <fieldset class="col-md-6">

                <my-static-display label-size="2" label="Name" value-size="8" required>
                    {{$store->name}}
                </my-static-display>

                <my-static-display label-size="2" label="Description" value-size="8">
                    {{$store->description}}
                </my-static-display>

                <my-static-display label="Status" label-size="2" value-size="8">
                    {{$store->optionStatus->status}}
                </my-static-display>

            </fieldset>


        </div>
    </div>
</div>
@endsection