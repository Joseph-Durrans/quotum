


@extends('layouts.header_footer')

@section('content')
   
<div class="single-stock">
    
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{ $stock['symbol'] }}</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <canvas id="dataChart"></canvas>
    </div>


    <p>{{ var_dump($stock) }}</p>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <script src="{{ asset('js/fetchStockData.js')}}"></script>
    
</div>

@endsection