<div class="mb-3">
    @if ($label)
        <label class="form-label">Image</label>
    @endif

    <div class="border border-2 lfm-img-btn">
        <input type="hidden" name="{{ $name }}" value="{{ old($name, $value) }}">

        @if (old($name, $value))
            <div class="position-relative w-100 h-100 lfm-img-container">
                <i class="fa fa-close position-absolute top-0 start-0 h-100 w-100 d-none align-items-center text-white 
                lfm-close justify-content-center"></i>

                <img class="img-fluid lfm-img-preview" src="{{ old($name, $value) }}">
            </div>            
        @else
            <img height="100px" width="100px" class="img-fluid" src="data:image/png;base64,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">   
        @endif
    </div>

    @error($name)
        <span>{{ $message }}</span>
    @enderror
</div>