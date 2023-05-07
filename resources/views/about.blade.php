@extends('base')

@section("head")
    <title>About</title>
@endsection

@section('content')
<div class="card max-w-6xl mx-3 lg:mx-auto my-4">
    <div class="card-header card-header-title">About Us</div>
    <div class="card-body">{!! $about !!}</div>
</div>
@endsection