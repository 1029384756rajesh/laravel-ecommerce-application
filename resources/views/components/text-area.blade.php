<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{$label}}</label>
    <input type="{{ $type }}" value="{{ old($name) ? old($name) : $value }}" class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" name="{{ $name }}" id="{{ $id }}">
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>