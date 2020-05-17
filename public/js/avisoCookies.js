$(document).ready(function () {
    compruebaAceptaCookies();
});

// Si la variable no está guardada, muestra la caja
function compruebaAceptaCookies() {
    if (localStorage.aceptaCookies != 'true') {
        $('#divCookies').removeClass("oculto");
    }
}

// Guarda la variable cuando el usuario acepta las cookies y oculta la caja
function aceptarCookies() {
    localStorage.aceptaCookies = 'true';
    $('#divCookies').addClass("oculto");
}