$(document).ready(function () {
    compruebaAceptaCookies();
});

// Si la variable no está guardada, muestra la caja
function compruebaAceptaCookies() {
    if (localStorage.aceptaCookies != 'true') {
        $('#divCookies').removeClass("oculto");
    }
}


// Guarda la variable cuando el usuario acepta las cookies y oculta la caja.
// Se ejecuta como evento al clickar en Aceptar Cookies
function aceptarCookies() {
    localStorage.aceptaCookies = 'true';
    $('#divCookies').addClass("oculto");
}

