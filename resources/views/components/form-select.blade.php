<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <select class="form-select form-control {{ $errors->has($name) ? "is-invalid" : "" }}" name="{{ $name }}" id="{{ $id }}">
        <option></option>

        @foreach ($options as $option)

        <option {{ $option->id == old($name, $value) ?  "selected" : "" }} value="{{ $option->id }}">{{ $option->name }}</option>
       
        @endforeach 
    </select>

    @error($name)

    <div class="invalid-feedback">{{ $message }}</div>
    
    @enderror
</div>