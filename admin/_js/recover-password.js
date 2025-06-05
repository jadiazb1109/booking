import { clsGenerales } from './_generales.js';

document.addEventListener('DOMContentLoaded', () => {

    const clsGenerales_ = new clsGenerales();

    const txtCorreo = document.getElementById('txtCorreo');
    const btnRestablecerClave = document.getElementById('btnRestablecerClave');

    txtCorreo.focus();
    btnRestablecerClave.addEventListener('click', btnRestablecerClaveClick);
    txtCorreo.addEventListener('keydown', inputCharacters);

    function inputCharacters(e) {

        if (event.keyCode == 13) {
            btnRestablecerClaveClick(e);
        }

    }


    function btnRestablecerClaveClick(e) {
        e.preventDefault();

        if (!txtCorreo.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your email address", "error");
            txtCorreo.focus();
            return;
        }

        if (!clsGenerales_.fnValidarFromatoCorreo(txtCorreo.value)) {
            clsGenerales_.mtdMostrarMensaje("Enter a valid email address", "error");
            txtCorreo.focus();
            return;
        }

        clsGenerales_.mtdActivarLoad(btnRestablecerClave, "Reset...");

        $.ajax({
            url: "../../api/v1/general/resetPassword/" + txtCorreo.value,
            type: "GET",
            dataType: 'json',
            crossDomain: true,
            error: function () {
                clsGenerales_.mtdDesactivarLoad(btnRestablecerClave, "Reset");
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
            },
        }).done((respuesta) => {

            clsGenerales_.mtdDesactivarLoad(btnRestablecerClave, "Reset");

            if (respuesta["state"] === 'ok') {
                clsGenerales_.mtdMostrarMensaje(respuesta["message"], "success", 5000);
                txtCorreo.focus();
                txtCorreo.value = "";
            }
            if (respuesta["state"] === 'ko') {
                clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
            }
        });

    }

});