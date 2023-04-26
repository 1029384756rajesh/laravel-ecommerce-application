$(document).ready(function() {
    
    $("[data-fp=single]").click(function() {
        window.open("/laravel-filemanager?type=image", "FileManager", "width=900,height=600")

        window.SetUrl = items => {
            $($(this).attr("data-fp-input")).val(items[0].url)
            $($(this).attr("data-fp-preview")).attr("src", items[0].url)
        }
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