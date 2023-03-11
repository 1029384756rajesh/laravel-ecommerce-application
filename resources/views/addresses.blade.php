@extends('base')

@section('content')
    <div class="container px-2 my-4">
        <div class="card">
            <div class="card-header fw-bold text-primary d-flex justify-content-between align-items-center">
                <span>My Address</span>
                <a href="" class="btn btn-sm btn-primary">Add New</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <p>
                            <span class="fw-bold">Full Name - </span>
                            <span>Rajesh Rout</span>
                        </p>
                        <p>
                            <span class="fw-bold">Mobile - </span>
                            <span>5678754566</span>
                        </p>
                        <p>
                            <span class="fw-bold">Address line 1 - </span>
                            <span>Jayanagar, 3rd corss, 3rd phase</span>
                        </p>
                        <p>
                            <span class="fw-bold">Address line 2 - </span>
                            <span>Near l.n public school</span>
                        </p>
                        <p>
                            <span class="fw-bold">City - </span>
                            <span>Banglore</span>
                        </p>
                        <p>
                            <span class="fw-bold">Pincode - </span>
                            <span>455555</span>
                        </p>
                    </div>
                    <div class="col-12 col-md-2 d-flex flex-column gap-2">
                        <button class="btn btn-warning btn-sm" style="max-width: 100px">Edit</button>
                        <button class="btn btn-danger btn-sm" style="max-width: 100px">Delete</button>
                    </div>
                </div>
                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-md-10">
                        <p>
                            <span class="fw-bold">Full Name - </span>
                            <span>Rajesh Rout</span>
                        </p>
                        <p>
                            <span class="fw-bold">Mobile - </span>
                            <span>5678754566</span>
                        </p>
                        <p>
                            <span class="fw-bold">Address line 1 - </span>
                            <span>Jayanagar, 3rd corss, 3rd phase</span>
                        </p>
                        <p>
                            <span class="fw-bold">Address line 2 - </span>
                            <span>Near l.n public school</span>
                        </p>
                        <p>
                            <span class="fw-bold">City - </span>
                            <span>Banglore</span>
                        </p>
                        <p>
                            <span class="fw-bold">Pincode - </span>
                            <span>455555</span>
                        </p>
                    </div>
                    <div class="col-12 col-md-2 d-flex flex-column gap-2">
                        <button class="btn btn-warning btn-sm" style="max-width: 100px">Edit</button>
                        <button class="btn btn-danger btn-sm" style="max-width: 100px">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection