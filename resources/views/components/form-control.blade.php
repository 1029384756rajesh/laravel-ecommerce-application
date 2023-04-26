<div class="mb-5">
    <label for="{{ $id }}" class="form-label">{{$label}}</label>

    @if ($type == "textarea")
        <textarea class="form-control {{ $errors->has($name) ? "border-red-600" : "" }}" name="{{ $name }}" id="{{ $id }}">{{ old($name) ? old($name) : $value }}</textarea>
    @else
        <input type="{{ $type }}" value="{{ old($name, $value) }}" class="form-control {{ $errors->has($name) ? "border-red-400" : "" }}" name="{{ $name }}" id="{{ $id }}">
    @endif

    @error($name)
        <div class="text-red-600 mt-1 text-m">{{ $message }}</div>
    @enderror
</div>