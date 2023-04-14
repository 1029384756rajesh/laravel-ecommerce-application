@extends("admin.base")

@section("content")

<div class="card mx-auto my-4" style="max-width: 700px;">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span class="fw-bold text-primary">Attributes</span>
        <button class="btn btn-sm btn-dark" id="add_new">Add New</button>
    </div>

    <div class="card-body">
        @if (count($attributes) == 0)
        
        <div class="alert alert-warning">No Attributes Found</div>

        @endif

        @foreach ($attributes as $attribute)

        <div class="row mb-3">
            <div class="col-3">
                <input type="text" name="attribute" class="form-control" value="{{ $attribute->name }}" placeholder="Attribute">
            </div>

            <div class="col-8">

                <div class="form-control">

                    <div class="mb-2 d-flex gap-2 flex-wrap">
                        @foreach ($attribute->options as $option)

                        <button class="btn btn-success" type="button">
                            <span class="option">{{ $option->name }}</span>

                            <i class="fa fa-times ms-1 remove-option"></i>
                        </button>

                        @endforeach
                    </div>

                    <input type="text" style="border: none; outline:none" class="option-input">

                </div>

            </div>

            <div class="col-1">
                <button type="button" class="btn btn-sm btn-primary remove-attribute"><i class="fa fa-times"></i></button>
            </div>
        </div>

        @endforeach
    </div>

    <div class="card-footer">
        <button class="btn btn-primary btn-sm" id="btn_save">Save</button>
    </div>
</form>

<script>
    const oldAttributes = @json($attributes)


    $("#add_new").click(function() {
        $(".alert.alert-warning").hide();

        $(".card-footer").show();

        $(".card-body").append(`
        <div class="row mb-3">
            <div class="col-3">
                <input type="text" name="attribute" class="form-control" placeholder="Attribute">
            </div>

            <div class="col-8">
                <div class="form-control">
                    <div class="mb-2 d-flex gap-2 flex-wrap"></div>
                    <input type="text" style="border: none; outline:none" class="option-input">
                </div>
            </div>

            <div class="col-1">
                <button type="button" class="btn btn-sm btn-primary remove-attribute"><i class="fa fa-times"></i></button>
            </div>
        </div>
        `)
    })

    $(".card").on("click", ".remove-attribute", function(){
        $(this).closest(".row").remove()
    })

    $(".card").on("click", ".remove-option", function(){
        $(this).parent().get(0).remove()
    })

    $(".card").on("keyup", ".option-input", function(){
        const value = $(this).val()

        if(!value.includes(",") || !value) return

        $($(this).closest(".form-control").children("div")).append(`
        <button class="btn btn-success" type="button">
            <span class="option">${value.substring(0, value.length - 1)}</span>
            <i class="fa fa-times remove-option"></i>
        </button>
        `)

        $(this).val("")
    })

    $("#btn_save").click(function() {
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

        fetch("/admin/products/{{ $product_id }}/attributes", {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                attributes
            })
        })
        .then(async response => {
            console.log(await response.json());
            if(response.status === 200){
                window.location.href = "http://localhost:8000/admin/products/{{$product_id}}/variations"
            }
        })

        console.log(attributes);
    })

    $(".alert.alert-warning").is(":visible") && $(".card-footer").hide();
</script>

@endsection