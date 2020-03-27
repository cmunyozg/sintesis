window.onload = start;
function start() {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 142) {
            $('.headerFixed').addClass("fijado").removeClass('oculto');

        } else {
            $('.headerFixed').removeClass("fijado").addClass("oculto");

        }
    });
}