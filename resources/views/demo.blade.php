@extends('base')

@section('content')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<form action="/demo" method="post">
  @csrf
  <div class="form-group">
    <label for="" class="form-label">Names</label>
    <input type="text" class="form-control" name="name[0]">
    <input type="text" class="form-control" name="name[1]">
    <input type="text" class="form-control" name="name[2]">
    <input type="text" class="form-control" name="name[3]">
    @if ($errors->has('name.0'))
        {{-- @foreach ($errors->get('name.*') as $item) --}}
            @foreach ($errors->get('name.0') as $i)
                <div class="invalid-feedback">{{ $i }}</div>  
            @endforeach
        {{-- @endforeach --}}
    @endif
  </div>
  <button type="submit">Submit</button>
</form>


@endsection