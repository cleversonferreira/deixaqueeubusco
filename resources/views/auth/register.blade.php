@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <a href="{{url('/facebook/redirect')}}" class="btn btn-primary">Login com Facebook</a>
            </div>
        </div>
    </div>
</div>
@endsection
