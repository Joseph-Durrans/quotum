


@extends('layouts.header_footer')

@section('content')

<div class="all-stocks">


    <div class="container">

        <div class="row">
            <div class="col">
                <form action="{{ route('stocks_search') }}" method="POST" role="search">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="search-input" name="search" placeholder="Search All Stocks"> 
                        <button type="submit" class="search-button">Search</button>
                    </div>
                </form>
            </div>
        </div>
        @if(isset($search_stock_symbol))
            <h1>Found</h1>
        @elseif(isset($search_not_found))
            <h1>Not Found</h1>
        @endif

        <div class="row">
            @foreach ($random_stock_symbols as $stock)
                <div class="col-lg-3">
                    {{ $stock['symbol'] }}
                    <a href="/user-panel/stocks/{{ strtoupper($stock['symbol']) }}">{{ $stock['symbol'] }}</a>
                </div>
            @endforeach
        </div>
    </div>

</div>

@endsection