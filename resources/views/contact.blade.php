@extends('base')

@section("head")
    <title>Contact</title>
@endsection

@section('content')
    <div class="px-3 my-4">
        <form class="card mx-auto max-w-3xl" onsubmit="alert('This functionality is not implemented'); return false">
            <div class="card-header card-header-title">Contact Us</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="fullName" class="form-label">Name</label>
                    <input type="text" class="form-control" name="full_name" id="fullName">
                </div>
                <div class="form-group">
                    <label for="fullName" class="form-label">Email</label>
                    <input type="text" class="form-control" name="full_name" id="fullName">
                </div>
                <div class="form-group">
                    <label for="fullName" class="form-label">Subject</label>
                    <input type="text" class="form-control" name="full_name" id="fullName">
                </div>
                <div class="form-group">
                    <label for="fullName" class="form-label">Message</label>
                    <textarea class="form-control" name="full_name" id="fullName"></textarea>
                </div>
                <button class="btn btn-primary">Send Message</button>
            </div>
        </form>
    </div>
@endsection