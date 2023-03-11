@extends('admin.base')

@section('content')
<div class="container my-4 px-3">    
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-bold text-primary">Sliders</span>
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-sm btn-primary">Add New</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" style="min-width: 1024px">
              <thead>
                <tr>
                  <th scope="col" width="10%">Image</th>
                  <th scope="col" width="25%">Title</th>
                  <th scope="col" width="40%">Description</th>
                  <th scope="col" width="15%">Last Updated</th>
                  <th scope="col" width="5%"></th>
                </tr>
              </thead>
              <tbody>
                @if (count($sliders) == 0)
                    <tr>
                      <td colspan="5" class="text-center">No Sliders Found</td>
                    </tr>
                @endif
                @foreach ($sliders as $slider)
                <tr>
                  <td>
                      <img src="/uploads/{{ $slider->image_url}}" class="img-fluid" width="100">
                  </td>
                  <td>{{ $slider->title }}</td>
                  <td>{{ $slider->description }}</td>
                  <td>{{ date('d-m-Y', strtotime($slider->created_at))}}</td>
                  <td>
                     <div class="d-flex gap-1">
                      <a href="{{ route('admin.sliders.edit', ['slider' => $slider->id]) }}" class="btn btn-sm btn-warning">
                          <span class="material-icons">edit</span>
                      </a>
                      <form action="{{ route('admin.sliders.destroy', ['slider' => $slider->id]) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button type="submit" class="btn btn-sm btn-danger">
                              <span class="material-icons p-0 m-0">delete</span>
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