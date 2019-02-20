/* Función para mosntrar un mensaje al enviar peticiones al servidor */
var ajaxBlock = function () { $.blockUI({ message: 'Transfiriendo datos con el servidor...' }) }
$(document).ajaxStart(ajaxBlock).ajaxStop($.unblockUI);

/* Funcion que muestra una alerta de error en el mensaje enviado */
function muestraAlerta(tipo, mensaje) {
    swal({
        type: tipo,
        title: mensaje
    });
    return;
}

/* Funcion que redondea un número */
function redondear(num) {
    num = Intl.NumberFormat().format(Math.round(num));
    return num;
}

/* Función que pone el foco en el input enviado */
function setfocus(item) {
    setTimeout(function () {
        item.focus();
    }, 250);
}

/* Función que formatea un número con comas y los decimales especifícados */
function formatear(num, dec) {
    var estilo = {
        minimumFractionDigits: dec,
        maximumFractionDigits: dec
    };
    return num.toLocaleString('en', estilo);
}

/* Función que no permite inster la letra "e" "+" "-" en inputs numéricos */
function eliminaEInput(event) {
    /* + - */
    if (event.which == 109 || event.which == 107) {
        event.preventDefault();
    }
    if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57 && event.wich < 96 || event.wich > 105) {
        event.preventDefault();
    }
}

function validarInput(input) {
    if (!$('#' + input.id)[0].checkValidity()) {
        $('#' + input.id)[0].reportValidity();
        $('#' + input.id).parents('.form-line').addClass('error');
        return 'invalid';
    }
    return 'valid';
}

 