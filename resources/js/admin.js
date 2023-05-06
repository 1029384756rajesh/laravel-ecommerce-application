$(document).ready(function() {
    ClassicEditor.create(document.querySelector("#editor"))
    
    $("[data-fp=single]").click(function() {
        window.open("/laravel-filemanager?type=image", "FileManager", "width=900,height=600")
        
        window.SetUrl = items => {
            $(this).parent().find($(this).attr("data-fp-input")).val(items[0].url)
            $(this).attr("src", items[0].url)
        }
    })

    $("[data-fp=multiple]").click(function() {
        window.open("/laravel-filemanager?type=image", "FileManager", "width=900,height=600")
        
        window.SetUrl = items => {
            $(this).parent().find($(this).attr("data-fp-container")).html("")

            items.forEach(item => {
                $(this).parent().find($(this).attr("data-fp-container")).append(`
                    <li>
                        <input type="hidden" name="${$(this).attr("data-fp-name")}" value="${item.url}">
                        <img src="${item.url}" class="h-20 w-20 border border-gray-300 object-cover">
                    </li>   
                `)
            })
        }
    })

    $(".nav-toggler").click(function() {
        if($(".sidebar").hasClass("-left-56")) {
            $(".sidebar").removeClass("-left-56")
            $(".sidebar").addClass("left-0")
        } else {
            $(".sidebar").removeClass("left-0")
            $(".sidebar").addClass("-left-56")
        }
    })

    $(".sortable").sortable()
})