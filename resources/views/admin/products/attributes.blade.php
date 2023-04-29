@extends("admin.base")

@section("head")
    <title>Attributes</title>
@endsection

@section("content")
<div class="card mx-auto my-4 max-w-5xl">
    <div class="card-header card-header-title">Attributes</div>

    <div class="card-body">
        @if (count($attributes) == 0)
            <div class="alert alert-warning">No Attributes Found</div>
        @endif

        @foreach ($attributes as $attribute)
            <div class="flex items-start gap-4 mb-5 last:mb-0 attribute">
                <input type="text" name="attribute" class="form-control w-48" value="{{ $attribute->name }}" placeholder="Attribute">

                <div class="form-control flex-1">
                    <div class="mb-2 flex gap-2 flex-wrap options">
                        @foreach ($attribute->options as $option)
                            <button class="btn btn-secondary">
                                <span class="option">{{ $option->name }}</span> 
                                <i class="fa fa-times ms-1 remove-option"></i>
                            </button>
                        @endforeach
                    </div>
                    <input type="text" class="option-input form-control border-none">
                </div>

                <button class="btn btn-sm btn-outline-secondary remove-attribute">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endforeach
    </div>

    <div class="card-footer flex justify-end gap-2">
        <button id="btnSave" class="btn btn-primary">Save</button>
        <button id="addNew" class="btn btn-outline-secondary">Add new</button>
    </div>
</div>

<script>
    const oldAttributes = @json($attributes)

    $("#addNew").click(function() {
        $(".alert.alert-warning").hide();

        $(".card-footer").show();

        $(".card-body").append(`
            <div class="flex items-start gap-4 mb-5 last:mb-0 attribute">
                <input type="text" name="attribute" class="form-control w-48" placeholder="Attribute">

                <div class="form-control flex-1">
                    <div class="mb-2 flex gap-2 flex-wrap options"></div>
                    <input type="text" class="option-input form-control border-none">
                </div>

                <button class="btn btn-sm btn-outline-secondary remove-attribute">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        `)
    })

    $(".card").on("click", ".remove-attribute", function(){
        $(this).closest(".attribute").remove()
    })

    $(".card").on("click", ".remove-option", function(){
        $(this).parent().get(0).remove()
    })

    $(".card").on("keyup", ".option-input", function(){
        const value = $(this).val()

        if(!value.includes(",") || !value) return

        $(this).parent().find(".options").append(`
            <button class="btn btn-secondary">
                <span class="option">${value.substring(0, value.length - 1)}</span> 
                <i class="fa fa-times ms-1 remove-option"></i>
            </button>
        `)

        $(this).val("")
    })

    $("#btnSave").click(function() {
        const attributes = []

        $(".attribute").each(function() {
            const attribute = {
                name: $(this).find("input[name=attribute]").val(),
                options: []
            }

            $(this).find(".option").each(function() {
                attribute.options.push($(this).html())
            })

            attributes.push(attribute)
        })

        $(this).attr("disabled", true)

        fetch("/admin/products/{{ $product_id }}/attributes", {
            method: "post",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                attributes
            })
        })
        .then(async response => {
            if(response.status === 200) {
                window.location.href = "/admin/products/{{ $product_id }}/variations"
            }
        })
    })

    $(".alert.alert-warning").is(":visible") && $(".card-footer").hide();
</script>
@endsection