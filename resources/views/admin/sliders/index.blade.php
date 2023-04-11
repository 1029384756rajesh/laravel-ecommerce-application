@extends("admin.base")

@section("content")
<div class="container my-4 px-3">    

    <div class="card">

        <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-bold text-primary">Sliders</span>
            <a href="/admin/sliders/create" class="btn btn-sm btn-primary">Add New</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 1024px">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Last Updated</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sliders) == 0)

                        <tr>
                            <td colspan="3" class="text-center">No Sliders Found</td>
                        </tr>

                        @endif

                        @foreach ($sliders as $slider)

                        <tr>
                            <td>
                                <img src="{{ $slider->image_url }}" height="60px" class="img-fluid" width="60px">
                            </td>

                            <td>{{ date("d-m-Y", strtotime($slider->created_at))}}</td>
                          
                            <td>
                                <div class="d-flex gap-1">
                                    <form action="/admin/sliders/{{ $slider->id }}" method="post">
                                      @csrf
                                      @method("delete")

                                      <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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