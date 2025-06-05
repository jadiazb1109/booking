import { clsGenerales } from './_generales.js';

document.addEventListener('DOMContentLoaded', () => {

    const clsGenerales_ = new clsGenerales();

    var htmlButon = "";
    var selectId = 0;
    var txtPagina = document.getElementById('txtPagina').value;
    var txtCodigoMenu = document.getElementById('txtCodigoMenu').value;


    const txtInfoUsuario = document.getElementById('txtInfoUsuario');
    const txtInfoUsuarioCargo = document.getElementById('txtInfoUsuarioCargo');

    const txtPCorreo = document.getElementById('txtPCorreo');
    const txtPDireccion = document.getElementById('txtPDireccion');
    const txtPCiudad = document.getElementById('txtPCiudad');
    const txtPEstado = document.getElementById('txtPEstado');
    const txtPCodigoZip = document.getElementById('txtPCodigoZip');
    const txtPTelefono = document.getElementById('txtPTelefono');
    const txtPFechaNacimiento = document.getElementById('txtPFechaNacimiento');
    const btnGuardarInfomacion = document.getElementById('btnGuardarInfomacion');

    const txtUsuario = document.getElementById('txtUsuario');
    const txtClaveA = document.getElementById('txtClaveA');
    const txtClaveN = document.getElementById('txtClaveN');
    const txtClaveC = document.getElementById('txtClaveC');
    const btnGuardarClave = document.getElementById('btnGuardarClave');

    const formAvatar = document.getElementById('formAvatar');
    const txtModalId = document.getElementById('txtModalId');
    const btnCargarAvatar = document.getElementById('btnCargarAvatar');
    const uploadedAvatar = document.getElementById('uploadedAvatar');
    const uplBtnImagen = document.getElementById('upload');
    const btnResetAvatar = document.getElementById('btnResetAvatar');      

    txtModalId.value = clsGenerales_.obtenerDataUsuario().id;

    let dirAvatar = "../assets/images/avatars/";
    let avatarAnt = dirAvatar;

    if (uploadedAvatar) {
        uplBtnImagen.onchange = () => {

            var dataForm = new FormData(formAvatar);
            if (uplBtnImagen.files[0]) {

                clsGenerales_.mtdActivarLoad(btnCargarAvatar, "....");

                $.ajax({
                    url: "cargar_documento.php",
                    type: "POST",
                    data: dataForm,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: (respuesta) => {
                        respuesta = JSON.parse(respuesta);
                        if (respuesta["state"] === 'ok') {

                            $.ajax({
                                url: "../../api/v1/user/userUpdateAvatar/"+ clsGenerales_.obtenerDataUsuario().id,
                                type: "PUT",
                                dataType: 'json',
                                crossDomain: true,
                                headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                                data: JSON.stringify({
                                    avatar: respuesta["data"].archivo,
                                    id_usuario: clsGenerales_.obtenerDataUsuario().id
                                }),
                                error: function () {
                                    clsGenerales_.mtdDesactivarLoad(btnCargarAvatar, "update avatar");
                                    clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
                                },
                            }).done((respuesta) => {

                                clsGenerales_.mtdDesactivarLoad(btnCargarAvatar, "update avatar");

                                if (respuesta["state"] === 'ok') {

                                    $.ajax({
                                        url: "cargar_documento.php",
                                        type: "POST",
                                        dataType: 'json',
                                        data: {
                                            opcion: "eliminar_avatar",
                                            avatar: avatarAnt
                                        }
                                    }).done((respuesta) => {
                                        if (respuesta["state"] === 'ok') {
                                            clsGenerales_.mtdMostrarMensaje("Avatar updated");
                                            uploadedAvatar.src = window.URL.createObjectURL(uplBtnImagen.files[0]);
                                            //setTimeout(() => { location.href = "my-profile"; }, 1500);
                                        }
                                    });

                                }
                                if (respuesta["state"] === 'ko') {
                                    clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
                                }
                            });
                        }
                        if (respuesta["state"] === 'ko') {
                            clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
                        }
                        return;
                    }
                });
            }
        };
        btnResetAvatar.onclick = () => {

            clsGenerales_.mtdActivarLoad(btnResetAvatar, "....");

            $.ajax({
                url: "../../api/v1/user/userUpdateAvatar/"+ clsGenerales_.obtenerDataUsuario().id,
                type: "PUT",
                dataType: 'json',
                crossDomain: true,
                headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
                data: JSON.stringify({
                    avatar: "01.png",
                    id_usuario: clsGenerales_.obtenerDataUsuario().id
                }),
                error: function () {
                    clsGenerales_.mtdDesactivarLoad(btnResetAvatar, "Remove");
                    clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
                },
            }).done((respuesta) => {

                clsGenerales_.mtdDesactivarLoad(btnResetAvatar, "Remove");

                if (respuesta["state"] === 'ok') {

                    $.ajax({
                        url: "cargar_documento.php",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            opcion: "eliminar_avatar",
                            avatar: avatarAnt
                        }
                    }).done((respuesta) => {

                        if (respuesta["state"] === 'ok') {
                            clsGenerales_.mtdMostrarMensaje("Avatar removed");

                            uplBtnImagen.value = '';
                            uploadedAvatar.src = dirAvatar + "01.png";
                            //setTimeout(() => { location.href = "my-profile"; }, 1500);
                        }
                    });

                }
                if (respuesta["state"] === 'ko') {
                    clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
                }
            });
        };
    }


    $.ajax({
        url: "../../api/v1/user/users/" + clsGenerales_.obtenerDataUsuario().id,
        type: "GET",
        crossDomain: true,
        dataType: 'json',
        headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
        error: function () { clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning"); }
    }).done((respuesta) => {

        if (respuesta["state"] === 'ok') {

            setTimeout(() => {

                avatarAnt = dirAvatar + respuesta["data"][0].image;
                uploadedAvatar.src = avatarAnt;

                txtInfoUsuario.innerHTML = clsGenerales_.toFristUpperCase(respuesta["data"][0].people);
                txtUsuario.value = respuesta["data"][0].username;

                txtPCorreo.value = respuesta["data"][0].email;
                txtPDireccion.value = respuesta["data"][0].address;
                txtPCiudad.value = respuesta["data"][0].city;
                txtPEstado.value = respuesta["data"][0].state;
                txtPCodigoZip.value = respuesta["data"][0].zip_code;
                txtPTelefono.value = respuesta["data"][0].phone;
                txtPFechaNacimiento.value = respuesta["data"][0].date_birth;

            }, 1000);
        }

    });

    btnGuardarInfomacion.addEventListener('click', btnGuardarInfomacionClick);
    function btnGuardarInfomacionClick(e) {
        e.preventDefault();

        if (!txtPCorreo.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your email", "error");
            txtPCorreo.focus();
            return;
        }

        if (!clsGenerales_.fnValidarFromatoCorreo(txtPCorreo.value)) {
            clsGenerales_.mtdMostrarMensaje("Enter your valid email", "error");
            txtPCorreo.focus();
            return;
        }

        if (!txtPDireccion.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your address", "error");
            txtPDireccion.focus();
            return;
        }

        if (!txtPCiudad.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your city", "error");
            txtPCiudad.focus();
            return;
        }

        if (!txtPEstado.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your state", "error");
            txtPEstado.focus();
            return;
        }

        if (!txtPCodigoZip.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your zip code", "error");
            txtPCodigoZip.focus();
            return;
        }

        if (!txtPTelefono.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your phone number", "error");
            txtPTelefono.focus();
            return;
        }

        if (!txtPFechaNacimiento.value) {
            clsGenerales_.mtdMostrarMensaje("Select your date of birth", "error");
            txtPFechaNacimiento.focus();
            return;
        }


        clsGenerales_.mtdActivarLoad(btnGuardarInfomacion, "update ...");

        $.ajax({
            url: "../../api/v1/people/people/profile/" + clsGenerales_.obtenerDataUsuario().id_people,
            type: "PUT",
            dataType: 'json',
            crossDomain: true,
            headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
            data: JSON.stringify({
                email: txtPCorreo.value,
                phone: txtPTelefono.value,
                address: txtPDireccion.value,
                city: txtPCiudad.value,
                state: txtPEstado.value,
                zip_code: txtPCodigoZip.value,
                date_birth: txtPFechaNacimiento.value ? txtPFechaNacimiento.value : null,
                id_user: clsGenerales_.obtenerDataUsuario().id
            }),
            error: function () {
                clsGenerales_.mtdDesactivarLoad(btnGuardarInfomacion, "update information");
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
            },
        }).done((respuesta) => {

            clsGenerales_.mtdDesactivarLoad(btnGuardarInfomacion, "update information");

            if (respuesta["state"] === 'ok') {
                clsGenerales_.mtdMostrarMensaje(respuesta["message"]);
            }
            if (respuesta["state"] === 'ko') {
                clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
            }
        });
    }

    btnGuardarClave.addEventListener('click', btnGuardarClaveClick);
    function btnGuardarClaveClick(e) {
        e.preventDefault();

        if (!txtClaveA.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your current password", "error");
            txtClaveA.focus();
            return;
        }

        if (!txtClaveN.value) {
            clsGenerales_.mtdMostrarMensaje("Enter your new password", "error");
            txtClaveN.focus();
            return;
        }

        if (!txtClaveC.value) {
            clsGenerales_.mtdMostrarMensaje("Confirm your new password", "error");
            txtClaveC.focus();
            return;
        }

        if (txtClaveN.value != txtClaveC.value) {
            clsGenerales_.mtdMostrarMensaje("The new password does not match", "error");
            txtClaveC.focus();
            return;
        }


        clsGenerales_.mtdActivarLoad(btnGuardarClave, "update ...");

        $.ajax({
            url: "../../api/v1/user/userUpdatePassword/" + clsGenerales_.obtenerDataUsuario().id,
            type: "PUT",
            dataType: 'json',
            crossDomain: true,
            headers: { "Api-Key": clsGenerales_.obtenerAPI_KEY() },
            data: JSON.stringify({
                clave_actual: btoa(txtClaveA.value),
                clave_nueva: btoa(txtClaveN.value),
                id_usuario: clsGenerales_.obtenerDataUsuario().id
            }),
            error: function () {
                clsGenerales_.mtdDesactivarLoad(btnGuardarClave, "Update password");
                clsGenerales_.mtdMostrarMensaje("Could not complete request to server", "warning");
            },
        }).done((respuesta) => {

            clsGenerales_.mtdDesactivarLoad(btnGuardarClave, "Update password");

            if (respuesta["state"] === 'ok') {
                clsGenerales_.mtdMostrarMensaje(respuesta["message"]);
            }
            if (respuesta["state"] === 'ko') {
                clsGenerales_.mtdMostrarMensaje(respuesta["message"], "error");
            }
        });
    }


});