$(document).ready(function() {
    ClassicEditor.create(document.querySelector("#editor"))

    $(".nav-toggler").click(function() {
        if($(".sidebar").hasClass("-left-56")) {
            $(".sidebar").removeClass("-left-56")
            $(".sidebar").addClass("left-0")
        } else {
            $(".sidebar").removeClass("left-0")
            $(".sidebar").addClass("-left-56")
        }
    })
})