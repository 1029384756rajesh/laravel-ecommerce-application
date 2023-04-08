@extends('admin.base')

@section('content')

<form action="" class="card mx-auto my-4" style="max-width: 700px;">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span class="fw-bold text-primary">Attributes</span>
        <button class="btn btn-sm btn-primary">Add</button>
    </div>

    <div class="card-body">
        <div class="row" id="attributesContainer">
            <div class="col-3">
                <input type="text" class="form-control" placeholder="Attribute">
            </div>

            <div class="col-8">
                <div class="form-control">
                    <div class="d-none gap-2 flex-wrap align-items-center option-list font-base mb-3"></div>
                    <input type="text" class="form-control-unstyle" onkeyup="handleOptionChange(event)" placeholder="Write options with comma separated">
                </div>
            </div>

            <div class="col-1">
                <button class="btn btn-sm btn-primary">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(".options").onchange = function() {
        if ($(this).val().includes(",")) 
        {
            $(this).attr("placeholder", "")

            $(this).parent().closest(".option-list").append(`
            <button class="btn btn-light">
                <span class="option-separator">${event.target.value.split(",")[0]}</span>
                <span class="fa fa-times" onclick="removeOption(event)"></span>
            </button>
            `)

            $(this).val("")
        }
    }

    function removeOption(event) 
    {
        event.target.parentElement.remove()
    }

    function addNew(event) 
    {
        $("#attributesContainer").append(`
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" placeholder="Attribute">
            </div>

            <div class="col-8">
                <div class="form-control">
                    <div class="d-none gap-2 flex-wrap align-items-center option-list font-base mb-3"></div>
                    <input type="text" class="form-control-unstyle" onkeyup="handleOptionChange(event)" placeholder="Write options with comma separated">
                </div>
            </div>

            <div class="col-1">
                <button class="btn btn-sm btn-primary">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        `)
    }
</script>

@endsection