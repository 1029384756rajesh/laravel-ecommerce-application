@extends('base')

@section('content')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<div class="input-group" id="lfm" data-input="thumbnail" data-preview="imagePreview" style="cursor:pointer">
    <input id="thumbnail" class="d-none" type="hidden" name="{{ $name }}" value="{{ $value }}">

    <img src="{{ $value }}" id="imagePreview">
</div>

  <script>
    $("input[id=thumbnail]").change(function() {
      console.log($(this).val());
    })

    lfm("lfm", "image", {prefix: "laravel-filemanager", type: "image"});
  </script>
@endsection