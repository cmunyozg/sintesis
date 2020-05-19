$('#formBuscador').submit(function (event) {
    if ($('#fechaInicio').val()) {
        var fechaFin = new Date($('#fechaFin').val());
        var fechaInicio = new Date($('#fechaInicio').val());

        if (fechaFin < fechaInicio) {
            alert('La fecha final es anterior a la fecha inicial');
            $('#fechaFin').focus();
            return false;
        }
        
    }
});