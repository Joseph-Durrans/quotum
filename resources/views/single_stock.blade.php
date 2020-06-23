


@extends('layouts.header_footer')

@section('content')
   
<div class="single-stock">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h1>{{ $stock['symbol'] }}</h1>
            </div>
        </div>
    </div>


    <p>{{ var_dump($stock) }}</p>
</div>

@endsection