@extends("admin.base")

@section("head")
    <title>Customers</title>
@endsection

@section("content")
<div class="card">
    <div class="card-header card-header-title">Customers</div>

    <div class="card-body">
        <div class="table-responsive">
            <div class="table min-w-[1024px]">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Since</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($users) == 0)
                            <tr>
                                <td colspan="4" class="text-center">No Users Found</td>
                            </tr>
                        @endif

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>

                                <td>{{ $user->email }}</td>

                                <td>{{ date("d-m-Y", strtotime($user->created_at))}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection