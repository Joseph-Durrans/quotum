@extends('layouts.header_footer')

@section('content')
   
<div class="user-panel">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <a href="{{ route('stocks') }}">Stocks Browser</a>
            </div>
            <div class="col-lg-4">
                <a href="{{ route('portfolio') }}">My Portfolio</a>
            </div>
            <div class="col-lg-4">
                <a href="{{ route('news') }}">News</a>
            </div>
        </div>
    </div>
</div>

@endsection