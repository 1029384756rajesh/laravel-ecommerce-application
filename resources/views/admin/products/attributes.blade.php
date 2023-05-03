@extends("admin.base")

@section("head")
    <title>Attributes</title>
@endsection

@section("content")
<form action="/admin/products/{{ $product->id }}/attributes" method="POST" class="card mx-auto my-4 max-w-5xl">
    @csrf

    <div class="card-header card-header-title">Attributes</div>

    <div class="card-body">
        @if (count($product->attributes) == 0)
            <div class="alert alert-warning">No Attributes Found</div>
        @endif
<?php  

echo "<pre>";
    print_r(old());
echo "</pre>";
?>
        @foreach (old("attributes[]", $product->attributes) as $attribute)
            <div data-index="{{ $loop->index }}" class="flex items-start gap-4 mb-5 last:mb-0 attribute">
                <?php $index = $loop->index ?>
                <input type="text" name="attributes[{{ $index }}][name]" class="form-control w-48" value="{{ $attribute->name }}" placeholder="Attribute">
<input type="text" name="demo" value="demo">
                <div class="form-control flex-1">
                    <div class="mb-2 flex gap-2 flex-wrap options">
                        @foreach ($attribute->options as $option)
                            <div class="btn btn-secondary">
                                <input type="text" name="attributes[{{ $index }}][options][]" class="option">{{ $option->value }}</span> 
                                <i class="fa fa-times ms-1 remove-option"></i>
                            </div>
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
        <button id="addNew" type="button" class="btn btn-outline-secondary">Add new</button>
    </div>
</form>

<script>
    const oldAttributes = @json($product->attributes)

    $("#addNew").click(function() {
        $(".alert.alert-warning").hide();

        $(".card-footer").show();

        $(".card-body").append(`
            <div data-index="${$(".attribute").last().attr("data-index") ? Number($(".attribute").last().attr("data-index")) + 1 : 0}" class="flex items-start gap-4 mb-5 last:mb-0 attribute">
                <input type="text" name="attributes[${$(".attribute").length}][name]" class="form-control w-48" placeholder="Attribute">

                <div class="form-control flex-1">
                    <div class="options">
                        
                    </div>
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
            <div class="btn btn-secondary">
                <input value="${value.substring(0, value.length - 1)}" type="text" name="attributes[${$(this).closest(".attribute").attr("data-index")}][options][]" class="mb-2 flex gap-2 flex-wrap options"></div>
                <i class="fa fa-times ms-1 remove-option"></i>
            </div>
        `)

        $(this).val("")
    })

    $("#btnSave").click(function() {
        const attributes = []

        $(".attribute").each(function() {
            const attribute = {
                name: $(this).find("input[name=attribute]").val(),
                values: []
            }

            $(this).find(".option").each(function() {
                attribute.values.push($(this).html())
            })

            attributes.push(attribute)
        })

        // $(this).attr("disabled", true)

        fetch("/admin/products/{{ $product->id }}/attributes", {
            method: "post",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accepts": "application/json"
            },
            body: JSON.stringify({
                attr: attributes
            })
        })
        .then(async response => {
            console.log(await response.json());
            // if(response.status === 200) {
            //     window.location.href = "/admin/products/{{ $product->id }}/variations"
            // }
        })
    })

    // $(".alert.alert-warning").is(":visible") && $(".card-footer").hide();
</script>
@endsection