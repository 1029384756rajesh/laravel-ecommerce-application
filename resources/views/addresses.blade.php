@extends('base')

@section('content')
<div class="container px-2 my-4">
    <div class="card">
        <div class="card-header fw-bold text-primary d-flex justify-content-between align-items-center">
            <span>My Address</span>
            <a href="{{ route('addresses.create') }}" class="btn btn-sm btn-primary">Add New</a>
        </div>
        <div class="card-body">
            @foreach ($addresses as $address)
            <div class="row mt-3 pt-3 border-top address">
                <div class="col-12 col-md-10">
                    <p>
                        <span class="fw-bold">Full Name - </span>
                        <span>{{ $address->name }}</span>
                    </p>
                    <p>
                        <span class="fw-bold">Mobile - </span>
                        <span>{{ $address->mobile }}</span>
                    </p>
                    <p>
                        <span class="fw-bold">Address line 1 - </span>
                        <span>{{ $address->address_line_1 }}</span>
                    </p>
                    <p>
                        <span class="fw-bold">Address line 2 - </span>
                        <span>{{ $address->address_line_2 }}</span>
                    </p>
                    <p>
                        <span class="fw-bold">City - </span>
                        <span>{{ $address->city }}</span>
                    </p>
                    <p class="mb-0">
                        <span class="fw-bold">Pincode - </span>
                        <span>{{ $address->pincode }}</span>
                    </p>
                </div>
                <div class="col-12 col-md-2 d-flex flex-column gap-2 mt-3 mt-md-0">
                    <a href="{{ route('addresses.edit', ['address' => $address->id]) }}" class="btn btn-warning btn-sm" style="max-width: 100px">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="deleteAddress(event, {{ $address->id }})" style="max-width: 100px">Delete</button>
                </div>
            </div>                    
            @endforeach
        </div>
    </div>
</div>

<script>
    async function deleteAddress(event, addressId) 
    {
        const response = await fetch(`/addresses/${addressId}?_method=DELETE`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })

        if(response.status === 200)
        {
            alert("Address deleted successfully")
            event.target.closest(".address").remove()
        }
        else 
        {
            alert("Sorry, An unknown error occur")
        }
    }
</script>
@endsection