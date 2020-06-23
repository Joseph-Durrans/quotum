


@extends('layouts.header_footer')

@section('content')

<div class="all-stocks">


    <div class="container">
        <div class="row">
            @foreach ($stock_symbol as $stock)
                <div class="col-lg-3">
                    {{ $stock['symbol'] }}
                </div>
            @endforeach
        </div>
    </div>

</div>

@endsection