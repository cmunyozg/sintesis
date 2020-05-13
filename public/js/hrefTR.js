
// Genera un enlace en cada fila de la tabla al evento al que hace referencia
$("tr > .pointer").click(function () {
    var href = $(this).parent().data("href");
    window.location = href;
});
