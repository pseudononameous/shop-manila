@extends('layouts.master')
@section('content')
    @include('includes.subNav')

<div class="container">

    <div class="banner">
        <h2>
            <span class="highlight">Today's Deals</span>
        </h2>
    </div>

    <section>
        <div class="row">


            <div class="col-md-12">
                <div class="row">

                    @foreach($events as $e)
                        <div class="col-md-12">
                            <a href="{{route('event_page', $e->slug)}}">

                                @foreach($e->eventImage as $eImg)
                                    @if($eImg->is_primary)
                                        <img style="margin:20px auto;" src="{{url($eImg->path . $eImg->file_name)}}" alt="" class="img-responsive center-block">
                                    @endif
                                @endforeach
                            </a>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="pull-right">

                            {!! $events->render() !!}

                    </div>
                </div>

            </div>

    </section>

</div>

@endsection