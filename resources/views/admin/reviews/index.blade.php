@extends('admin.base')

@section('content')
<div class="container my-4 px-3">
    <div class="card">
        <div class="card-header fw-bold text-primary">Customer Reviews</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" style="min-width: 1024px">
              <thead>
                <tr>
                  <th scope="col">Product</th>
                  <th scope="col">Customer</th>
                  <th scope="col">Review</th>
                  <th scope="col">Reviewed At</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                  @if (count($reviews) == 0)
                  <tr>
                      <td colspan="4" class="text-center">No Reviews Found</td>
                  </tr>
                  @endif

                  @foreach ($reviews as $review)
                  <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="/uploads/{{ $review->product_image_url }}" height="60" width="60" class="img-fluid" alt="">
                            <span>{{ $review->product_name }}</span>
                        </div>
                      </td>
                      <td>
                        <div>
                          <p>
                            <span class="fw-semibold">Name - </span>
                            <span>{{ $review->user_name }}</span>
                          </p>
                          <p>
                            <span class="fw-semibold">Emal - </span>
                          <span>{{ $review->user_email }}</span>
                          </p>
                        </div>
                      </td>
                      <td>{{ $review->review }}</td>
                      <td>{{ date('d-m-Y', strtotime($review->created_at)) }}</td>
                      <td>
                          <div class="d-flex gap-1">
                              <form action="{{ route('admin.reviews.approve', ['review' => $review->id]) }}" method="POST">
                                  @csrf
                                  @method('PATCH')

                                  <button type="submit" class="btn btn-warning btn-sm">
                                      <span class="material-icons">done</span>
                                  </button>
                              </form>

                              <form action="{{ route('admin.reviews.destroy', ['review' => $review->id]) }}" method="POST">
                                  @csrf
                                  @method('DELETE')

                                  <button type="submit" class="btn btn-danger btn-sm">
                                      <span class="material-icons">delete</span>
                                  </button>
                              </form>
                          </div>
                      </td>
                  </tr>  
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
@endsection