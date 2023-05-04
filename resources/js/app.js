$(document).ready(function() {

    $("#navToggler").click(function() {
        if($("#navMenu").hasClass("nav-menu-close")) {
            $("#navMenu").removeClass("nav-menu-close")
            $("#navMenu").addClass("nav-menu-open")
        } else {
            $("#navMenu").addClass("nav-menu-close")
            $("#navMenu").removeClass("nav-menu-open")
        }
    })

    $("#accountIcon").click(function() {
        $("#accountMenu").slideToggle()
    })
    
    $("[data-fp=single]").click(function() {
        window.open("/laravel-filemanager?type=image", "FileManager", "width=900,height=600")
        window.SetUrl = items => {
            $(this).find($(this).attr("data-fp-input")).val(items[0].url)
            $(this).find($(this).attr("data-fp-preview")).attr("src", items[0].url)
        }
    })

    $("[data-fp-reset]").click(function(event) {
        event.stopPropagation()
        $(this).parent().find($(this).parent().attr("data-fp-input")).val("")
        $(this).parent().find($(this).parent().attr("data-fp-preview")).attr("src", "/assets/placeholder.png")
    })

    $(".gallery-img").click(function() {
        $("#mainImg").attr("src", $(this).attr("src"))
    })
    $("#gallery").sortable()

    $("[data-fp=multiple]").click(function() {
        window.open("http://localhost:8000/laravel-filemanager?type=image", "FileManager", "width=900,height=600")
        
        window.SetUrl = items => {
            items.forEach(item => {
                $($(this).attr("data-fp-container")).prepend(`
                    <li class="cursor-pointer relative group h-20 w-20 rounded border border-gray-300 overflow-hidden">
                    <div data-fp-remove class="group-hover:flex hidden absolute top-2 right-2 h-10 w-10 bg-black bg-opacity-50 items-center justify-center text-white">
                    <i class="fa fa-close text-2xl cursor-pointer"></i>
                </div>
                        <input type="hidden" name="${$(this).attr("data-fp-name")}" value="${item.url}">
                        <img src="${item.url}" class="w-full h-full object-cover">
                    </li>            
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