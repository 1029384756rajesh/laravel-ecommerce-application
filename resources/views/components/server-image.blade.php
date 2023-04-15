<div class="lfm" data-input="lfm-input" data-preview="lfm-img" style="cursor:pointer">
    {{-- <input id="thumbnail" class="d-none" type="hidden" name="{{ $name }}" value="{{ old($name, $value) }}"> --}}

    <img src="{{ old($name, $value) }}" class="{{ $class }} lfm-img" style="{{ $style }}">

    @if ($slot)
    {{ $slot }}
    @else
    <input class="lfm-input" type="hidden" name="{{ $name }}" value="{{ old($name, $value) }}">
    @endif

</div>

