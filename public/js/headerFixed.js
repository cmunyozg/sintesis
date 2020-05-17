$(document).ready(function () {
    header();
  });
  
function header() {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 142) {
            $('.headerFixed').addClass("fijado").removeClass('oculto');

        } else {
            $('.headerFixed').removeClass("fijado").addClass("oculto");

        }
    });
}