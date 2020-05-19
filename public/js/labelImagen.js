$(document).ready(function () {
    $('.custom-file-label').html('Elige una imagen');
    $('#evento_imagen').on('change', function () {
        //obtiene y muestra en el label el nombre del archivo de la imagen
        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    })
    $('#usuario_imagen').on('change', function () {
        //obtiene y muestra en el label el nombre del archivo de la imagen
        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    })
});
