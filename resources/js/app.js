$(document).ready(function() {
    
    $("[data-fp=single]").click(function() {
        window.open("/laravel-filemanager?type=image", "FileManager", "width=900,height=600")

        window.SetUrl = items => {
            $($(this).attr("data-fp-input")).val(items[0].url)
            $($(this).attr("data-fp-preview")).attr("src", items[0].url)
        }
    })


    $("[data-fp=multiple]").click(function() {
        window.open("/laravel-filemanager?type=image", "FileManager", "width=900,height=600")

        window.SetUrl = items => {
            items.forEach(item => {
                $($(this).attr("data-fp-container")).prepend(`
                    <div class="relative group h-20 w-20 rounded border border-gray-300 overflow-hidden">
                        <div data-fp-remove class="group-hover:flex hidden absolute inset-0 bg-black bg-opacity-50 items-center justify-center text-white">
                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                        </div>
                        <input type="hidden" name="${$(this).attr("data-fp-name")}" value="${item.url}">
                        <img src="${item.url}" class="w-full h-full object-cover">
                    </div>            
                `)
            })
        }
    })

    $(".card-body").on("click", "[data-fp-remove]", function() {
        $(this).parent().get(0).remove()
    })

    $("#navMenu").click(function() {
        if($("#sidebar").hasClass("-left-56")) {
            $("#sidebar").removeClass("-left-56")
            $("#sidebar").addClass("left-0")
        } else {
            $("#sidebar").removeClass("left-0")
            $("#sidebar").addClass("-left-56")
        }
    })

})