@extends('admin.base')

@section('content')

<form action="" class="card mx-auto my-4" style="max-width: 700px;">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span class="fw-bold text-primary">Attributes</span>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-primary" onclick="save(event)">Save</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="append(event)">Add</button>
        </div>
    </div>

    <div class="card-body">
        @foreach ($attributes as $attribute)
        <div class="row">
            <div class="col-3">
                <input type="text" name="attribute" class="form-control" value="{{ $attribute->name }}" placeholder="Attribute">
            </div>

            <div class="col-8">
                <div class="form-control">
                    <div class="mb-2 d-flex gap-2 flex-wrap">
                        @foreach ($attribute->options as $option)
                        <button class="btn btn-success" type="button">
                            <span class="option">{{ $option->name }}</span>
                            <i class="fa fa-times ms-1" onclick="removeOption(event)"></i>
                        </button>
                        @endforeach
                    </div>
                    <input type="text" class="form-control-unstyle" onkeyup="setOption(event)">
                </div>
            </div>

            <div class="col-1">
                <button type="button" class="btn btn-sm btn-primary" onclick="removeAttributes(event)">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>
</form>

<script>
    const oldAttributes = @json($attributes)


    function append() {
        $(".card-body").append(`
        <div class="row">
            <div class="col-3">
                <input type="text" name="attribute" class="form-control" placeholder="Attribute">
            </div>

            <div class="col-8">
                <div class="form-control">
                    <div class="mb-2 d-flex gap-2 flex-wrap"></div>
                    <input type="text" class="form-control-unstyle" onkeyup="setOption(event)">
                </div>
            </div>

            <div class="col-1">
                <button type="button" class="btn btn-sm btn-primary" onclick="removeAttributes(event)">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        `)
    }

    function removeAttributes(event) {
        event.target.closest(".row").remove()
    }

    function setOption({ target }) {
        const value = target.value

        if(!value.includes(",")) return

        $(target.closest(".form-control").querySelector("div")).append(`
        <button class="btn btn-success" type="button">
            <span class="option">${value.substring(0, value.length - 1)}</span>
            <i class="fa fa-times" onclick="removeOption(event)"></i>
        </button>
        `)

        target.value = ""
    }

    function save(event) {
        const attributes = []

        document.querySelectorAll(".row").forEach(element => {
            const attribute = {
                name: element.querySelector("input[name=attribute]").value,
                options: []
            }

            element.querySelectorAll(".option").forEach(ele => attribute.options.push(ele.innerHTML))

            attributes.push(attribute)
        })

        event.target.disabled = true

        fetch(`/api/products/20/attributes`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                attributes
            })
        })
        .then(response => {
            if(response.status === 200){
                window.location.href = "http://localhost:8000/api/products/20/variations"
            }
        })

        console.log(attributes);
    }

    function removeOption({ target }) 
    {
       target.parentElement.remove()
    }
</script>

@endsection