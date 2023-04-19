<div class="lfm" data-input="lfm-input" data-preview="lfm-img" style="cursor:pointer">
    @if ($label)
        <label for="lfm-input" class="form-label">{{ $label }}</label>
    @endif

    <img src="{{ old($name, $value) }}" class="{{ $class }} lfm-img" style="{{ $style }}">

    @if ($slot != "")
        {{ $slot }}
    @else
        <input class="lfm-input" type="hidden" name="{{ $name }}" value="{{ old($name, $value) }}">
    @endif
</div>

