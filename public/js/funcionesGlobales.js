/* Función para mosntrar un mensaje al enviar peticiones al servidor */
var ajaxBlock = function () { $.blockUI(
    { message: 'Transfiriendo datos con el servidor...',
        //theme: true,
        baseZ: 2000 
    }
)}
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

// call this before showing SweetAlert: para desbloquear el input
function fixBootstrapModal() {
  var modalNode = document.querySelector('.modal[tabindex="-1"]');
  if (!modalNode) return;

  modalNode.removeAttribute('tabindex');
  modalNode.classList.add('js-swal-fixed');
}

// call this before hiding SweetAlert (inside done callback):
function restoreBootstrapModal() {
  var modalNode = document.querySelector('.modal.js-swal-fixed');
  if (!modalNode) return;

  modalNode.setAttribute('tabindex', '-1');
  modalNode.classList.remove('js-swal-fixed');
}

/*****
** modo=1->entero,modo=2->string
*/
function GetVar(variable,modo=1) {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    var dato=vars[variable];
    return (dato==undefined?(modo==1?0:""):vars[variable]); 
}
