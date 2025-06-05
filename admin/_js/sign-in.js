import { clsGenerales } from './_generales.js';

document.addEventListener('DOMContentLoaded', () => {

    const clsGenerales_ = new clsGenerales();

    const txtUsuario = document.getElementById('txtUsuario');
    const txtClave = document.getElementById('txtClave');
    const btnIniciarSesion = document.getElementById('btnIniciarSesion');

    txtUsuario.focus();   
    btnIniciarSesion.addEventListener('click', btnIniciarSesionClick);
    txtUsuario.addEventListener('keydown', inputCharacters);
    txtClave.addEventListener('keydown', inputCharacters);

    function inputCharacters(e) {

        if (event.keyCode == 13) {
            btnIniciarSesionClick(e);
        }

    }
    

    function btnIniciarSesionClick(e) {
        e.preventDefault();  

        if (!txtUsuario.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your username", "error");
            txtUsuario.focus();
            return;
        }

        if (!txtClave.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your password", "error");
            txtClave.focus();
            return;
        }     

        clsGenerales_.mtdActivarLoad(btnIniciarSesion,"loading ...");

        $.ajax({
            url: "../../api/v1/general/validateLogin/"+txtUsuario.value+"/"+btoa(txtClave.value),
            type: "GET",
            dataType: 'json',
            crossDomain: true,
            error: function() {
                clsGenerales_.mtdDesactivarLoad(btnIniciarSesion,"Log in");
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
            },
        }).done((respuesta) => {

            clsGenerales_.mtdDesactivarLoad(btnIniciarSesion,"Log in");

            if (respuesta["state"] === 'ok') {
                setTimeout(() => { location.href = "../app/home"; }, 1000);

                //almacenamos los datos del usuario en la memoria del navegador aplication/storage/local storage
                localStorage.setItem("USER", JSON.stringify(respuesta["data"]));
                localStorage.setItem("API_KEY", respuesta["data"].token);
                localStorage.setItem("ACCES_PAG", true);

                clsGenerales_.mtdMostrarMensaje(respuesta["message"]);
            }
            if (respuesta["state"] === 'bl') {
                clsGenerales_.mtdMostrarMensaje(respuesta["message"], "warning");
            }
            if (respuesta["state"] === 'ko') {
                clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
            }
        });

    }
    
    //se valida los dato que estenn almacenados de un usuario en el navegador.. si son validos se direcciona a la pagina home.php
    if (localStorage.getItem("API_KEY")) {

        $.ajax({
            url: "../../api/v1/general/validateToken/"+ clsGenerales_.obtenerAPI_KEY(),
            type: "GET",
            crossDomain: true,
            dataType: 'json',
            error: function() {
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "error");
            }
        }).done((respuesta) => {
            if (respuesta["state"] === 'ok') {

                location.href = "../app/home";

            }else{

                localStorage.removeItem("USER");
                localStorage.removeItem("API_KEY");

            }
        });

    }

});