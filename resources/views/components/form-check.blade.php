<div class="form-check mb-3">
    <input type="hidden" value="0" name="{{ $name }}" id="{{ $id }}">

    <input class="form-check-input" {{ old($name, $value) ? "checked" : "" }} type="checkbox" value="1" name="{{ $name }}" id="{{ $id }}">
    
    <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
</div>