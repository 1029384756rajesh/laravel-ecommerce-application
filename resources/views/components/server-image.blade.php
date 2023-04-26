<div class="mb-3">
    <label class="form-label">{{ $label }}</label>

    <div class="lfm border rounded">
        <input type="hidden" name="{{ $name }}" value="{{ old($name, $value) }}">

        <img src="{{ ($current = old($name, $value)) ? $current : "/assets/placeholder.png" }}" class="lfm-preview">

        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
    $(".lfm").click(function() {
        window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")

        window.SetUrl = items => {
            $(this).find("input").attr("value", items[0].url)
            $(this).find("img").attr("src", items[0].url)
        }
    })
</script>
