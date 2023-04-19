


$(document).ready(function(){
    $(".add-product").submit(function(event) {
        event.preventDefault()
        console.log(CKEDITOR.instances['editor'].getData());
        alert($("#editor").html())
    })

    $(".lfm-btn").click(function() {
        window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")

        window.SetUrl = items => {
            $(this).find("input[type=hidden]").val(items[0].url)
            $(this).find(".lfm-container").removeClass("d-none")
            $(this).find(".lfm-container").addClass("d-block")
            $(this).find(".lfm-preview").attr("src", items[0].url)
            $(this).find(".lfm-placeholder").hide()
        }
    })

    $(".lfm-close").click(function(event) {
        event.stopPropagation()
        $(this).closest(".lfm-btn").find("input[type=hidden]").val("")
        $(this).closest(".lfm-btn").find(".lfm-container").addClass("d-none")
        $(this).closest(".lfm-btn").find(".lfm-container").removeClass("d-block")
        $(this).closest(".lfm-btn").find(".lfm-preview").attr("src", "")
        $(this).closest(".lfm-btn").find(".lfm-placeholder").show()
    })

    $(".lfmMulContainer").on("click", ".lfmMulRemove", function() {
        $(this).parent().get(0).remove()
    })

    $(".lfmMulPlaceholder").click(function() {
        window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")

        window.SetUrl = items => {
            items.forEach(item => {
                $(".lfmMulContainer").prepend(`
                <div class="position-relative border border-2 lfm-mul-container" style="cursor:pointer; height: 100px; width: 100px;">
                    <input type="hidden" class="lfmMulInput">
                    <i class="fa fa-close position-absolute top-0 start-0 h-100 w-100 d-none align-items-center text-white 
                    lfm-close justify-content-center lfmMulRemove"></i>
                    <img src="${item.url}" class="w-100 h-100 img-fluid lfmMulPreview">
                </div>
                `)
            })
        }
    })

    $(".gallery-container").click(function() {
        
        window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")
    
        window.SetUrl = function (items) {
            items.forEach(item => {
                $(".gallery-container").append(`
                    <div class="gallery-item">
                        <img src="${item.url}" class="gallery-img"/>
                        <input value="${item.url}" type="hidden" name="gallery[]"/>
                        <i class="fa fa-close gallery-btn-remove"></i>
                    </div>
                `)
            })
        }

    })

    $(".gallery-container").on("click", ".gallery-btn-remove", function(event){
        event.stopPropagation()
        $(this).parent().get(0).remove()
    });

    $(".product-img").click(function() {
        window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")

        window.SetUrl = items => {
            $(this).attr("src", items[0].url)
            $(".image_url").val(items[0].url)
        }
    })
    

    document.querySelectorAll(".lfm").forEach(button => {

        button.onclick = () => {
    
            const targetInput = button.querySelector(`.${button.getAttribute("data-input")}`)
            const targetPreview = button.querySelector(`.${button.getAttribute("data-preview")}`)

            window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")
    
            window.SetUrl = function (items) {
    
                const filePath = items.map(item => item.url).join(",")

                targetInput.value = filePath;
                targetInput.dispatchEvent(new Event("change"))
    
                targetPreview.src = ""
    
                items.forEach(function (item) {
                    let img = document.createElement('img')
                    img.setAttribute('style', 'height: 5rem')
                    img.setAttribute('src', item.url)

                    const input = document.createElement("input")
                    input.setAttribute("type", "hidden")
                    input.setAttribute("name", $)
                    input.value = item.url

                    targetPreview.src = item.thumb_url
                })
    
                targetPreview.dispatchEvent(new Event("change"));
            }
        }
    })
})