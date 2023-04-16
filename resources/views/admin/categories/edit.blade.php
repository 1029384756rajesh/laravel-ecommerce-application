@extends("admin.base")

@section("content")
<div class="container my-4 px-3">
    <div class="card">
        <div class="card-header fw-bold text-primary">Edit Category</div>

        <form enctype="multipart/form-data" action="/admin/categories/{{ $category->id }}" class="card-body" method="post">
            @csrf
            @method("patch")

            <x-form-control type="text" label="Name" id="name" name="name" :value="$category->name"/>

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Id</label>
                    <select name="parent_id" class="form-control form-select">
                        <option></option>
                        @foreach ($categories as $c)
    
                        <option    {{ $category->parent_id == $c["id"] ? "selected" : ""}} value={{ $c["id"] }}> 
                            @if ($c["label"] > 1)
                                @for ($i = 1; $i < $c["label"]; $i++)
                                —
                                @endfor
                            @endif
                         
                            {{ $c["name"]}}</option>
                        @endforeach
                      </select>
                </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2({
        placeholder: 'Select an option',
    width: "600px",
    data: data,
    formatSelection: function(item) {
      return item.text
    },
    formatResult: function(item) {
      return item.text
    },
    templateResult: formatResult,
    });
});
    function formatResult(node) {
    var $result = $('<span style="padding-left:' + (200 * node.lebel) + 'px;">' + node.name + '</span>');
    return $result;
  };

    $("#mySelect").select2({
    placeholder: 'Select an option',
    width: "600px",
    data: data,
    formatSelection: function(item) {
      return item.text
    },
    formatResult: function(item) {
      return item.text
    },
    templateResult: formatResult,
  });
</script>
@endsection