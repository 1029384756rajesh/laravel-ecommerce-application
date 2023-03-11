@extends('base')

@section('content')
    <div class="container px-2 my-4">
        <div class="card">
            <div class="card-header fw-bold text-primary d-flex justify-content-between align-items-center">
                <span>My Orders</span>
                <a href="" class="btn btn-sm btn-primary">Add New</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-10">
                        <p>
                            <span class="fw-bold">Order No - </span>
                            <span>34085</span>
                        </p>
                        <p>
                            <span class="fw-bold">Status - </span>
                            <span class="badge bg-success">Delivered</span>
                        </p>
                        <p>
                            <span class="fw-bold">Last Updated - </span>
                            <span>12-02-22 10:15 PM</span>
                        </p>
                        <p>
                            <span class="fw-bold">Placed At - </span>
                            <span>12-02-22 10:15 PM</span>
                        </p>
                        <p class="mb-0">
                            <span class="fw-bold">City - </span>
                            <span>Banglore</span>
                        </p>
                    </div>
                    <div class="col-12 col-md-2 d-flex flex-column gap-2 mt-3">
                        <button class="btn btn-warning btn-sm" style="max-width: 150px">View Details</button>
                    </div>
                </div>
                <div class="row mt-3 pt-3 border-top">
                    <div class="col-12 col-md-10">
                        <p>
                            <span class="fw-bold">Order No - </span>
                            <span>34085</span>
                        </p>
                        <p>
                            <span class="fw-bold">Status - </span>
                            <span class="badge bg-success">Delivered</span>
                        </p>
                        <p>
                            <span class="fw-bold">Last Updated - </span>
                            <span>12-02-22 10:15 PM</span>
                        </p>
                        <p>
                            <span class="fw-bold">Placed At - </span>
                            <span>12-02-22 10:15 PM</span>
                        </p>
                        <p class="mb-0">
                            <span class="fw-bold">City - </span>
                            <span>Banglore</span>
                        </p>
                    </div>
                    <div class="col-12 col-md-2 d-flex flex-column gap-2 mt-3">
                        <button class="btn btn-warning btn-sm" style="max-width: 150px">View Details</button>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <nav class="text-end" aria-label="orders page navigation">
                    <ul class="pagination mb-0 d-inline-flex">
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
            </div>
        </div>
    </div>
@endsection