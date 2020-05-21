$(document).ready(function () {
    header();
  });
  
  // Muestra el fixed header cuando se hace scroll, sólo en dispositivos de más de 850px de ancho
function header() {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 147 && $(window).width() > 850) {
            $('.headerFixed').addClass("fijado").removeClass('oculto');
            

        } else {
            $('.headerFixed').removeClass("fijado").addClass("oculto");

        }
    });
}