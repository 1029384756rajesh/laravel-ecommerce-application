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
            <div class="attribute flex items-start gap-4 mb-5 last:mb-0">
                <input type="text" name="attribute" class="form-control w-48" value="{{ $attribute->name }}" placeholder="Attribute">

                <div class="form-control flex-1">
                    <div class="options mb-2 flex gap-2 flex-wrap">
                        @foreach ($attribute->options as $option)
                            <div class="btn btn-secondary">
                                <span class="option">{{ $option }}</span> 
                                <i class="remove-option fa fa-times ms-1"></i>
                            </div>
                        @endforeach
                    </div>
                    <input type="text" class="input-option form-control border-none">
                </div>

                <button class="remove-attribute btn btn-sm btn-outline-secondary">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endforeach
    </div>

    <div class="card-footer flex justify-end gap-2">
        <button class="btn-save btn btn-primary">Save</button>
        <button class="btn-new btn btn-outline-secondary">Add new</button>
    </div>
</form>

<script>
    const oldAttributes = @json($attributes)

    $(".card-body").on("click", ".remove-attribute", function() {
        $(this).parent().get(0).remove()

        $(".attribute").length == 0 && $(".card-body").prepend(`<div class="alert alert-warning">No Attributes Found</div>`)
    })

    $(".card-body").on("keyup", ".input-option", function() {
        let value = $(this).val().trim()
        
        if(!value.includes(",") || value.length == 1) return

        value = value.substring(0, value.length - 1)

        $(this).val("")

        $(this).parent().find(".options").append(`
            <div class="btn btn-secondary">
                <span class="option">${value}</span> 
                <i class="remove-option fa fa-times ms-1"></i>
            </div>
        `)
    })

    $(".card-body").on("click", ".remove-option", function() {
        $(this).parent().get(0).remove()
    })

    $(".btn-new").click(function() {
        $(".alert").hide()

        $(".card-body").append(`
            <div class="attribute flex items-start gap-4 mb-5 last:mb-0">
                <input type="text" name="attribute" class="form-control w-48" placeholder="Attribute">

                <div class="form-control flex-1">
                    <div class="options mb-2 flex gap-2 flex-wrap"></div>
                    <input type="text" class="input-option form-control border-none">
                </div>

                <button class="remove-attribute btn btn-sm btn-outline-secondary">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        `)
    })

    $(".btn-save").click(async function() {
        let error = null
        const attributes = []

        $(".attribute").each(function() {
            const name = $(this).find("input[name=attribute]").val().trim()
            const options = []

            if(name.length == 0) {
                error = "Attribute name can not be empty"
            } else if(name.length > 20) {
                error = "Attribute name must be within 20 characters"
            } else if($(this).find(".option").length == 0) {
                error = "Option can not be empty"
            }
            
            $(this).find(".option").each(function() {
                options.push($(this).html())
            })

            attributes.push({name, options})
        })

        if(error || attributes.length === 0) {
            return alert(error)
        }
        
        $(this).attr("disabled", true)

        const response = await fetch("/admin/products/{{$product->id}}/attributes", {
            method: "post",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({attributes})
        }) 

        console.log(await response.text());

        $(this).attr("disabled", false)
    })
</script>
@endsection