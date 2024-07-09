@extends('layouts.admin') 
@section('content')
<div class="container">
    <div class="main">
        <div class="page-header">
            <h2>View User</h2>
        </div>

        <div class="form-horizontal">

            <fieldset class="col-md-6">

                <my-static-display label-size="2" label="Name" value-size="8" required>
                    {{$data->name}}
                </my-static-display>

                <my-static-display label-size="2" label="Email" value-size="8">
                    {{$data->email}}
                </my-static-display>


            </fieldset>


        </div>
    </div>
</div>
@endsection