@extends("base")

@section("head")
    <title>About</title>
@endsection

@section("content")
<div class="card max-w-6xl mx-auto">
    <div class="card-header card-header-title">About Us</div>
    <div class="card-body">{!! $about !!}</div>
</div>
@endsection