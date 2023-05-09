/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
$(document).ready(function () {
  $(".nav-toggler").click(function () {
    if ($(".nav-menu").hasClass("nav-menu-close")) {
      $(".nav-menu").removeClass("nav-menu-close");
      $(".nav-menu").addClass("nav-menu-open");
    } else {
      $(".nav-menu").addClass("nav-menu-close");
      $(".nav-menu").removeClass("nav-menu-open");
    }
  });
  $(".account-icon").click(function () {
    $(".account-menu").slideToggle("fast");
  });
});
/******/ })()
;