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
    
})