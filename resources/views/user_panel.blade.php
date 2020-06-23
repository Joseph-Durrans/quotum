@extends('layouts.header_footer')

@section('content')
   
<div class="user-panel">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <a href="{{ route('stocks') }}">Stocks Browser</a>
            </div>
        </div>
    </div>
</div>

@endsection